/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, track, api } from 'lwc'
import './calendar.scss'
import { skip } from 'z/utils'

const message_1 = 'Нельзя бронировать прошлые даты',
    message_2 = 'Дата выезда должна быть позже даты заезда',
    message_3 = 'В интервале бронирования не должно быть занятых дат',
    message_4 = 'Выберите свободную дату',
    message_5 = 'На эти даты пакетный тур не доступен',
    message_6 = 'Минимальное количество ночей '

let $ = jQuery
let events, jsFromDate, jsToDate, $calendar, happyEvents

export default class Calendar extends LightningElement {
    @api settings
    @track loading

    get dateStart() {
        return this.settings.dateStart ? this.settings.dateStart.replace(/-/g, '.') : '—'
    }

    get dateEnd() {
        return this.settings.dateEnd ? this.settings.dateEnd.replace(/-/g, '.') : '—'
    }

    get cssCalendar() {
        return this.settings.eventTabId ? 'calendar calendar_event' : 'calendar'
    }

    initDate(date) {
        let result
        if (date) {
            result = {
                d: new moment(date, 'DD-MM-YYYY').format('YYYY-MM-DD')
            }
        }
        return result
    }

    async connectedCallback() {
        jsFromDate = this.initDate(this.settings.dateStart)
        jsToDate = this.initDate(this.settings.dateEnd)
        const calendarSlug = this.settings.calendars.find((c) => c.selected).slug
        const calendarId = this.settings.calendars.find((c) => c.selected).id
        this.loading = true
        $calendar = null
        events = null
        const response = await fetch(`https://krasnagorka.by/wp-json/calendars/${calendarSlug}`)
        events = await response.json()
        const happyEventsResponse = await fetch(`https://krasnagorka.by/wp-json/happy/v1/events/`)
        happyEvents = await happyEventsResponse.json()
        if (happyEvents) {
            this.dispatchEvent(
                new CustomEvent('happyevents', {
                    detail: happyEvents,
                    bubbles: true,
                    composed: true
                })
            )
        }
        this.loading = false
        await skip()
        this.template.querySelector('.calendar__content').innerHTML = this.getTemplate()
        $calendar = $('#calendar')
        const step = this
        let defaultDate = jsFromDate ? jsFromDate.d : undefined
        if (this.settings.scenario === 'Package') {
            defaultDate = new moment(this.settings.package.start_date, 'MM/DD/YYYY').format(
                'YYYY-MM-DD'
            )
        }
        $calendar.fullCalendar({
            height: 380,
            locale: 'ru',
            defaultDate: defaultDate,
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            events: events,
            viewRender: function (view, element) {
                const dates = $(element).find('[data-date]')
                const start = dates[0].getAttribute('data-date')
                const end = dates[dates.length - 1].getAttribute('data-date')

                step.dispatchEvent(
                    new CustomEvent('happyeventsrange', {
                        detail: { start, end },
                        bubbles: true,
                        composed: true
                    })
                )

                if (step.settings.scenario === 'Package') {
                    const startDate = jQuery.fullCalendar
                        .moment(step.settings.package.start_date, 'MM/DD/YYYY')
                        .format('YYYY-MM-DD')
                    const endDate = jQuery.fullCalendar
                        .moment(step.settings.package.end_date, 'MM/DD/YYYY')
                        .format('YYYY-MM-DD')
                    $(dates).each((index, date) => {
                        const strDate = date.getAttribute('data-date')
                        if (strDate < startDate || strDate > endDate) {
                            date.style.backgroundColor = '#eee'
                        }

                        if (step.settings.package.depricatedDayes.indexOf(strDate) > -1) {
                            date.style.backgroundColor = '#eee'
                        }
                    })
                }
            },
            eventAfterAllRender: () => {
                this.updateStyle()
                const table = document.querySelector('#calendar table')
                table.className = 'main-table'
                if (jsFromDate) {
                    const element = document.querySelector(
                        `.fc-widget-content[data-date="${jsFromDate.d}"]`
                    )
                    if (element) {
                        jsFromDate = {
                            d: jsFromDate.d,
                            el: element
                        }
                        $(jsFromDate.el).addClass('cell-range')
                    }
                }

                if (jsToDate) {
                    const element = document.querySelector(
                        `.fc-widget-content[data-date="${jsToDate.d}"]`
                    )
                    if (element) {
                        jsToDate = { d: jsToDate.d, el: element }
                        $(jsToDate.el).addClass('cell-range')
                    }
                }
                fillCells()
                addInOutDelimiters(events)
                addEventsIcons()
            },
            dayClick: function (date, jsEvent, view) {
                if (step.settings.eventTabId) {
                    return
                }
                const d = date.format('YYYY-MM-DD')
                const cell = this
                if (!jsFromDate) {
                    initFrom(d, cell, {
                        scenario: step.settings.scenario,
                        package: step.settings.package
                    })
                } else if (jsFromDate && jsFromDate.d === d) {
                    clearAll()
                    fillCells()
                } else if (
                    jsFromDate &&
                    !jsToDate &&
                    jsFromDate.d < d &&
                    checkDateRange(events, jsFromDate.d, d, {
                        scenario: step.settings.scenario,
                        package: step.settings.package
                    })
                ) {
                    jsToDate = { d: d, el: cell }
                    $(jsToDate.el).addClass('cell-range')
                    fillCells()
                } else if (
                    jsFromDate &&
                    jsToDate &&
                    jsToDate.d !== d &&
                    jsFromDate.d < d &&
                    checkDateRange(events, jsFromDate.d, d, {
                        scenario: step.settings.scenario,
                        package: step.settings.package
                    })
                ) {
                    $(jsToDate.el).removeClass('cell-range').empty()
                    addEventsIcons()
                    jsToDate = { d: d, el: cell }
                    $(jsToDate.el).addClass('cell-range')

                    fillCells()
                } else if (jsToDate && jsToDate.d === d) {
                    $(jsToDate.el).removeClass('cell-range').empty()
                    addEventsIcons()
                    jsToDate = null
                    fillCells()
                } else if (jsFromDate && jsFromDate.d > d) {
                    showMessage(message_2)
                }

                if (jsFromDate && jsToDate) {
                    const fromDateClearFormat = new moment(jsFromDate.d, 'YYYY-MM-DD')
                    const toDateClearFormat = new moment(jsToDate.d, 'YYYY-MM-DD')

                    step.dispatchEvent(
                        new CustomEvent('update', {
                            detail: {
                                dateStart: fromDateClearFormat.format('DD-MM-YYYY'),
                                dateEnd: toDateClearFormat.format('DD-MM-YYYY')
                            },
                            bubbles: true,
                            composed: true
                        })
                    )
                } else if (jsFromDate) {
                    const fromDateClearFormat = new moment(jsFromDate.d, 'YYYY-MM-DD')

                    step.dispatchEvent(
                        new CustomEvent('update', {
                            detail: {
                                dateStart: fromDateClearFormat.format('DD-MM-YYYY'),
                                dateEnd: null
                            },
                            bubbles: true,
                            composed: true
                        })
                    )
                } else {
                    step.dispatchEvent(
                        new CustomEvent('update', {
                            detail: {
                                dateStart: null,
                                dateEnd: null
                            },
                            bubbles: true,
                            composed: true
                        })
                    )
                }
            }
        })

        function addEventsIcons() {
            for (let event of happyEvents.items) {
                if (event.icon) {
                    const eventDayElement = $calendar[0].querySelector(
                        `.fc-day[data-date="${event.date}"]`
                    )
                    if (eventDayElement) {
                        let iconElement = eventDayElement.querySelector('.fc-day-event__icon')
                        if (!iconElement) {
                            iconElement = document.createElement('img')
                            iconElement.setAttribute(
                                'src',
                                `${happyEvents.icon_path}${event.icon}.svg`
                            )
                            iconElement.setAttribute('class', 'fc-day-event__icon')
                            eventDayElement?.appendChild(iconElement)
                        }
                    }
                }
            }
        }

        function addInOutDelimiters() {
            for (let event of events) {
                const elementStart = $calendar[0].querySelector(
                    `.fc-widget-content[data-date="${event.start}"]`
                )

                var endEvent = jQuery.fullCalendar
                    .moment(event.end, 'YYYY-MM-DD')
                    .subtract(1, 'days')
                    .format('YYYY-MM-DD')

                const elementEnd = $calendar[0].querySelector(
                    `.fc-widget-content[data-date="${endEvent}"]`
                )

                if (elementStart && elementStart.innerHTML) {
                    elementStart.innerHTML += delimeterFromView
                } else if (elementStart && !elementStart.innerHTML) {
                    elementStart.innerHTML = delimeterFromView
                }

                if (elementEnd && elementEnd.innerHTML) {
                    elementEnd.innerHTML += delimeterToView
                } else if (elementEnd && !elementEnd.innerHTML) {
                    elementEnd.innerHTML = delimeterToView
                }
            }
        }
    }

    updateStyle() {
        const head = document.head || document.getElementsByTagName('head')[0]
        if (this.calendarStyle) {
            head.removeChild(this.calendarStyle)
        }
        this.calendarStyle = document.createElement('style')
        const targetMargin = $($('.fc-day-top')[0]).width() / 2
        const css = `.fc-view .fc-body .fc-start { 
                        margin-left: ${targetMargin}px; 
                        border-top-left-radius: 5px;
                        border-bottom-left-radius: 5px;
                    }
                    .fc-view .fc-body .fc-end { 
                        margin-right: ${targetMargin}px;
                        border-top-right-radius: 5px;
                        border-bottom-right-radius: 5px;
                    }
                    .fc-day-event__icon{
                        position: absolute;
                        bottom: 4px;
                        left: 4px;
                        width: 16px;
                        height: 16px;
                        object-fit: contain;
                    }`
        this.calendarStyle.appendChild(document.createTextNode(css))
        head.appendChild(this.calendarStyle)
    }

    getTemplate() {
        return `
            <div class="calendar_block">
                <div id="calendar"></div>
                <div class="calendar_legend">
                    <ul>
                        <li><b class="reserved"></b>Зарезервировано</li>
                        <li><b class="prepaid"></b>Предоплачено</li>
                        <li><b class="booked"></b>Оплачено</li>
                    </ul>
                </div>
            </div>
        `
    }
}

const delimeterFromView = `<div class="date-delimiter date-delimiter_from">
                                <div class="date-delimiter__line"></div>
                            </div>`
const delimeterToView = `<div class="date-delimiter date-delimiter_to">
                                <div class="date-delimiter__line"></div>
                            </div>`

function initFrom(d, el, options = {}) {
    var a = new moment(Date.now())
    if (d < a.format('YYYY-MM-DD')) {
        showMessage(message_1)
        return
    }

    if (options.scenario === 'Package') {
        const startDate = jQuery.fullCalendar
            .moment(options.package.start_date, 'MM/DD/YYYY')
            .format('YYYY-MM-DD')
        const endDate = jQuery.fullCalendar
            .moment(options.package.end_date, 'MM/DD/YYYY')
            .format('YYYY-MM-DD')
        if (d < startDate || d > endDate) {
            showMessage(message_5)
            return
        }

        if (options.package.depricatedDayes.indexOf(d) > -1) {
            showMessage(message_5)
            return
        }
    }

    if (d >= a.format('YYYY-MM-DD') && checkStartDate(events, d)) {
        jsFromDate = { d: d, el: el }
        $(jsFromDate.el).addClass('cell-range')
    }
}

function fillCells() {
    $calendar.find(`.cell-between`).removeClass('cell-between')
    if (jsToDate) {
        $calendar.find('.fc-day[data-date]').each(function () {
            const $item = $(this)
            const dateStr = $item.data('date')
            if (jsFromDate.d < dateStr && jsToDate.d > dateStr) {
                $item.addClass('cell-between')
            }
        })
    }
}

function clearAll() {
    if (jsToDate) {
        $(jsToDate.el).removeClass('cell-range')
    }
    if (jsFromDate) {
        $(jsFromDate.el).removeClass('cell-range')
    }
    jsToDate = null
    jsFromDate = null
}

function checkStartDate(events, startDate) {
    var result = true

    for (var i = 0; i < events.length; i++) {
        var event = events[i]
        var startEvent = jQuery.fullCalendar.moment(event.start, 'YYYY-MM-DD').format('YYYY-MM-DD')
        var endEvent = jQuery.fullCalendar
            .moment(event.end, 'YYYY-MM-DD')
            .subtract(1, 'days')
            .format('YYYY-MM-DD')

        if (startDate < endEvent && startDate > startEvent) {
            result = false
            showMessage(message_4)
            break
        }
    }

    return result
}

function checkDateRange(events, startDate, endDate, options = {}) {
    var result = true

    if (options.scenario === 'Package') {
        const endPackageDate = jQuery.fullCalendar
            .moment(options.package.end_date, 'MM/DD/YYYY')
            .format('YYYY-MM-DD')
        if (endPackageDate < endDate) {
            showMessage(message_5)
            console.log('startDate', startDate)
            console.log('endDate', endDate)
            return false
        }

        let checkDepricatedDays = false

        options.package.depricatedDayes.forEach((day) => {
            if (startDate <= day && endDate >= day) {
                checkDepricatedDays = true
            }
        })

        if (checkDepricatedDays) {
            showMessage(message_5)
            return false
        }

        const startDateMoment = moment(startDate)
        const endDateMoment = moment(endDate)

        const nights = endDateMoment.diff(startDateMoment, 'days')
        if (nights < options.package.min_night) {
            showMessage(`${message_6} ${options.package.min_night}`)
            return false
        }
    }

    for (var i = 0; i < events.length; i++) {
        var event = events[i]
        var startEvent = jQuery.fullCalendar.moment(event.start, 'YYYY-MM-DD').format('YYYY-MM-DD')
        var endEvent = jQuery.fullCalendar
            .moment(event.end, 'YYYY-MM-DD')
            .subtract(1, 'days')
            .format('YYYY-MM-DD')

        if (startDate < endEvent && endDate > startEvent) {
            result = false
            showMessage(message_3)
            break
        }
    }

    return result
}

function showMessage(message) {
    new ErrorAlert(message)
}

function ErrorAlert(message) {
    this.messageElement = $(
        `<div class="error-message"><p class="error-message__inner">Ошибка! ${message}</p></div>`
    )
    $(document.body).append(this.messageElement)
    setTimeout(() => {
        this.messageElement.fadeIn(function () {
            $(this).remove()
        })
    }, 2000)
}
