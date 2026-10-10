import { LightningElement, track, api } from 'lwc'
import './stepHouse.scss'
import IMG_BOOKING from './../../../icons/date-clicking-selecting.png'

export default class StepHouse extends LightningElement {
    @api settings
    @track loading
    @track bookingImg = IMG_BOOKING
    @track error
    @track priceInfoExpanded = false

    happyEventsObj
    happyEventsObjRange

    get showPriceInfo() {
        return !this.settings.eventId && !this.settings.package
    }

    get priceInfoContentClass() {
        return `step-house__info-content${this.priceInfoExpanded ? ' step-house__info-content_open' : ''}`
    }

    get priceInfoHidden() {
        return !this.priceInfoExpanded
    }

    get peopleCountLabel() {
        let result = 'Количество человек'
        return result
    }

    get eventChilds() {
        return [
            {
                id: this.settings.eventModel.childs,
                selected: true,
                name: this.settings.eventModel.childs
            }
        ]
    }

    get fireEvents() {
        const calendar = this.settings.calendars.find((c) => c.selected)
        return (
            this.settings.fier_events
                ?.filter((item) => item.calendar == calendar.id)
                .map((item) => {
                    const from = new moment(item.from, 'MM/DD/YYYY').format('YYYY-MM-DD')
                    const to = new moment(item.to, 'MM/DD/YYYY').format('YYYY-MM-DD')
                    const fromDisplay = new moment(item.from, 'MM/DD/YYYY').format('DD.MM.YYYY')
                    const toDisplay = new moment(item.to, 'MM/DD/YYYY').format('DD.MM.YYYY')
                    return {
                        id: `${item.tab_id}-${item.calendar}-${from}-${to}`,
                        params: {
                            eventTabId: item.tab_id,
                            booking: item.house,
                            calendarId: item.calendar,
                            from,
                            to,
                            ...(calendar.isTerem ? { terem: calendar.name } : {})
                        },
                        title: calendar.name,
                        description: item.sale_text?.replace(/[\t\n\r]+/g, ' '),
                        dates: `${fromDisplay} - ${toDisplay}`,
                        price: {
                            rub: item.new_price,
                            penny: '00'
                        },
                        image: this.settings.house.picture
                    }
                }) || []
        )
    }

    get soonEvents() {
        const selectedDateStart = this.settings.dateStart
            ? moment(this.settings.dateStart, 'DD-MM-YYYY')
            : null
        const selectedDateEnd = this.settings.dateEnd
            ? moment(this.settings.dateEnd, 'DD-MM-YYYY')
            : null

        return (this.settings.package_tour || [])
            .filter((item) => {
                if (!selectedDateStart || !selectedDateEnd) {
                    return false
                }

                const eventDateStart = moment.unix(item.date_start).startOf('day')
                const eventDateEnd = moment.unix(item.date_finish).endOf('day')

                return (
                    selectedDateStart.isSameOrAfter(eventDateStart, 'day') &&
                    selectedDateEnd.isSameOrBefore(eventDateEnd, 'day')
                )
            })
            .map((item) => {
                const url = new URL(item.event_link, window.location.origin)

                return {
                    ...item,
                    params: Object.fromEntries(url.searchParams.entries())
                }
            })
    }

    get showSoonEvents() {
        const selectedCalendar = this.settings.calendars?.find((item) => item.selected)

        return Boolean(
            this.soonEvents.length &&
                this.settings.house &&
                selectedCalendar &&
                this.settings.dateStart &&
                this.settings.dateEnd
        )
    }

    get showChilds() {
        return this.settings.scenario === 'Event' && this.settings.eventModel.enabled_child
    }

    get showDaylySales() {
        return !this.settings.eventId && this.settings.scenario !== 'Package'
    }

    get showPackageDaylySales() {
        return this.settings.scenario == 'Package' && this.settings.package.daysSales.length
    }

    get showPackageInfo() {
        return this.settings.package
    }

    get happyEvents() {
        let result = []

        if (this.happyEventsObj && this.happyEventsObjRange) {
            const iconPath = this.happyEventsObj.icon_path
            const items = this.happyEventsObj.items.filter(
                (item) =>
                    item.date >= this.happyEventsObjRange.start &&
                    item.date <= this.happyEventsObjRange.end
            )

            for (const item of items) {
                const isNewItem = result.find((it) => it.icon === item.icon)
                if (!isNewItem && item.description) {
                    result.push({
                        index: `${item.date}`,
                        icon: item.icon,
                        img: `${iconPath}${item.icon}.svg`,
                        description: item.description
                    })
                }
            }
        }
        return result
    }

    get dateStart() {
        return this.settings.dateStart ? this.settings.dateStart.replace(/-/g, '.') : '—'
    }

    get dateEnd() {
        return this.settings.dateEnd ? this.settings.dateEnd.replace(/-/g, '.') : '—'
    }

    get currentSeason() {
        return this.settings.seasons.find((season) => season.current)
    }

    get showEventMessageInfo() {
        return this.settings.eventTabId && this.settings.eventTabMessageInfo
    }

    get eventOpportunities() {
        return this.settings.eventModel.content.filter((item) => !!item).join(', ')
    }

    connectedCallback() {
        const calendar = this.settings.calendars.find((c) => c.selected)
        if (calendar && !this.settings.house) {
            this.initHouse(calendar.id, calendar.isTerem)
        }
    }

    renderedCallback() {
        const title = this.template.querySelector('.step-house__subtitle')
        if (title && this.settings.package) {
            title.innerHTML = this.settings.package.title
        }
    }

    togglePriceInfo() {
        this.priceInfoExpanded = !this.priceInfoExpanded
    }

    loadFireEvent(event) {
        const fireEvent = this.fireEvents.find(
            (item) => String(item.id) === event.currentTarget.dataset.id
        )

        if (!fireEvent) {
            return
        }

        this.loadBookingModel(fireEvent.params)
    }

    loadSoonEvent(event) {
        const soonEvent = this.soonEvents.find(
            (item) => String(item.id) === event.currentTarget.dataset.id
        )
        if (!soonEvent) {
            return
        }

        this.loadBookingModel(soonEvent.params)
    }

    loadBookingModel(params) {
        this.dispatchEvent(
            new CustomEvent('loadbookingmodel', {
                detail: params,
                bubbles: true,
                composed: true
            })
        )
    }

    handlePriceInfoKeydown(event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault()
            this.togglePriceInfo()
        }
    }

    async initHouse(calendarId, isTeremCalendar) {
        const id = parseInt(calendarId)
        this.error = false
        this.loading = true
        const house = await fetch(
            `https://krasnagorka.by/wp-json/krasnagorka/v1/ls/house/?calendarId=${id}&isTeremCalendar=${isTeremCalendar}`
        )
            .catch((error) => {
                console.log('error', error)
            })
            .then((data) => data.json())

        this.loading = false
        const newCalendars = this.settings.calendars.map((c) => {
            return { ...c, selected: c.id === id }
        })

        const count = parseInt(house.peopleMaxCount)

        let counts = Array.from(Array(count), (_, i) => i + 1).map((it) => {
            let selected = false
            if (this.settings.people && this.settings.people == it) {
                selected = true
            }
            return {
                id: it,
                selected: selected,
                name: it
            }
        })

        let minPeople = this.settings.package?.calendars[id].min_people || 0
        counts = counts.filter((item) => item.id >= minPeople)

        let maxChild = newCalendars.find((c) => c.selected).maxChild
        maxChild = maxChild > 0 ? maxChild + 1 : 1

        const childCounts = Array.from(Array(maxChild), (_, i) => i).map((it) => {
            return {
                id: it,
                selected: false,
                name: it
            }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    calendars: newCalendars,
                    house: house,
                    counts: counts,
                    childCounts: childCounts
                },
                bubbles: true,
                composed: true
            })
        )
    }

    calendarChange(event) {
        this.error = false
        const calendar = this.settings.calendars.find((c) => c.id == event.detail)
        this.initHouse(calendar.id, calendar.isTerem)
        this.dispatchEvent(
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

    seasonsChange(event) {
        const seasons = this.settings.seasons.map((season) => {
            return {
                ...season,
                current: season.id == event.detail
            }
        })
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    seasons: seasons
                },
                bubbles: true,
                composed: true
            })
        )
    }

    countChange(event) {
        this.error = false
        const id = parseInt(event.detail)
        const newCounts = this.settings.counts.map((c) => {
            return { ...c, selected: c.id === id }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    counts: newCounts
                },
                bubbles: true,
                composed: true
            })
        )
        this.error = false
    }

    childCountChange(event) {
        const id = parseInt(event.detail)
        const newChildCounts = this.settings.childCounts.map((c) => {
            return { ...c, selected: c.id === id }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    childCounts: newChildCounts
                },
                bubbles: true,
                composed: true
            })
        )
        this.error = false
    }

    nextButtonHandler() {
        if (!this.settings.calendars.find((op) => op.selected)) {
            const selectorCalendars = this.template.querySelector('.step-house__calendars')
            if (selectorCalendars) {
                selectorCalendars.showError()
                this.error = 'Выберите домик'
            }
        } else if (!this.settings.counts.find((op) => op.selected)) {
            const selectorCounts = this.template.querySelector('.step-house__counts')
            if (selectorCounts) {
                selectorCounts.showError()
                this.error = 'Выберите количество отдыхающих'
            }
        } else if (!this.settings.dateStart) {
            this.error = 'Выберите дату заезда'
        } else if (!this.settings.dateEnd) {
            this.error = 'Выберите дату выезда'
        } else {
            let newMenu
            if (this.settings.eventId) {
                newMenu = this.settings.menu.map((it) => {
                    return { ...it, active: it.value === 'contacts' }
                })
            } else if (this.settings.package?.services?.find((item) => item == '1')) {
                newMenu = this.settings.menu.map((it) => {
                    return { ...it, active: it.value === 'additional_services' }
                })
            } else {
                newMenu = this.settings.menu.map((it) => {
                    return { ...it, active: it.value === 'food' }
                })
            }
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        menu: newMenu
                    },
                    bubbles: true,
                    composed: true
                })
            )
        }
    }

    handlerHappyEvents(event) {
        this.happyEventsObj = event.detail
    }

    handlerHappyEventsRange(event) {
        this.happyEventsObjRange = event.detail
    }
}
