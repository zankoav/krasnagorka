import {LightningElement, track , api } from 'lwc';
import {skip} from 'z/utils';
import './stepDate.scss';
const message_1 = "Нельзя бронировать прошлые даты",
    message_2 = "Дата выезда должна быть позже даты заезда",
    message_3 = "В интервале бронирования не должно быть занятых дат",
    message_4 = "Выберите свободную дату";
    
let $ = jQuery;
let events, jsFromDate, jsToDate, $calendar;

const IMG_BOOKING = require('./../../icons/date-clicking-selecting.png');


export default class StepDate extends LightningElement {

    @api settings;
    @track loading;
    @track bookingImg = IMG_BOOKING;
    @track error;

    get dateStart(){
        return this.settings.dateStart || ' - ';
    }

    get dateEnd(){
        return this.settings.dateEnd || ' - ';
    }

    backButtonHandler(){
        const newMenu = this.settings.menu.map(it => {
            return {...it, active:it.value === 'house'};
        });
        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    menu: newMenu
                 }, 
                 bubbles:true, 
                 composed:true
             })
        );
    }

    nextButtonHandler(){
        if(!this.settings.dateStart){
            this.error = 'Выберите дату заезда';
        }else if(!this.settings.dateEnd){
            this.error = 'Выберите дату выезда';
        }else{
            const newMenu = this.settings.menu.map(it => {
                return {...it, active:it.value === 'contacts'};
            });
            this.dispatchEvent(
                new CustomEvent('update', {
                     detail: {
                        menu: newMenu
                     }, 
                     bubbles:true, 
                     composed:true
                 })
            );
        }
    }

    initDate(date){
        let result;
        if(date){
            result = {
                d: (new moment(date, "DD-MM-YYYY")).format("YYYY-MM-DD")
            };
        }
        return result;
    }

    async connectedCallback(){
        events = null;
        jsFromDate = this.initDate(this.settings.dateStart);
        console.log('jsFromDate', jsFromDate);
        jsToDate = this.initDate(this.settings.dateEnd);
        console.log('jsToDate', jsToDate);
        $calendar = null;
        this.loading = true;
        const culendarSlug = this.settings.calendars.find(c => c.selected).slug;
        const response = await fetch(`https://krasnagorka.by/wp-json/calendars/${culendarSlug}`);
        events = await response.json();
        this.loading = false;
        await skip();
        this.template.querySelector('.step-date__calendar').innerHTML = this.getTemplate();
        $calendar = $('#calendar');
        const step = this;
        $calendar.fullCalendar({
            height: 400,
            locale: "ru",
            header: {
                left: "prev",
                center: "title",
                right: "next"
            },
            events: events,
            eventAfterAllRender:  () => {
                this.updateStyle();
                if (jsFromDate) {
                    const element = document.querySelector(
                        `.fc-widget-content[data-date="${jsFromDate.d}"]`
                    );
                    if (element) {
                        jsFromDate = {
                            d: jsFromDate.d,
                            el: element
                        };
                        $(jsFromDate.el).addClass("cell-range");
                    }
                }

                if (jsToDate) {
                    const element = document.querySelector(
                        `.fc-widget-content[data-date="${jsToDate.d}"]`
                    );
                    if (element) {
                        jsToDate = { d: jsToDate.d, el: element };
                        $(jsToDate.el).addClass("cell-range");
                    }
                }
                fillCells();
            },
            dayClick: function (date, jsEvent, view) {
                const d = date.format("YYYY-MM-DD");
                const cell = this;
            
                if (!jsFromDate) {
                    initFrom(d, cell);
                } else if (jsFromDate && jsFromDate.d === d) {
                    clearAll();
                    fillCells();
                } else if (
                    jsFromDate &&
                    !jsToDate &&
                    jsFromDate.d < d &&
                    checkDateRange(events, jsFromDate.d, d)
                ) {
                    jsToDate = { d: d, el: cell };
                    $(jsToDate.el).addClass("cell-range");
                    fillCells();
                } else if (
                    jsFromDate &&
                    jsToDate &&
                    jsToDate.d !== d &&
                    jsFromDate.d < d &&
                    checkDateRange(events, jsFromDate.d, d)
                ) {
                    $(jsToDate.el)
                        .removeClass("cell-range")
                        .empty();
                    jsToDate = { d: d, el: cell };
                    $(jsToDate.el).addClass("cell-range");

                    fillCells();
                } else if (jsToDate && jsToDate.d === d) {
                    $(jsToDate.el)
                        .removeClass("cell-range")
                        .empty();
                    jsToDate = null;
                    fillCells();
                } else if (jsFromDate && jsFromDate.d > d) {
                    showMessage(message_2);
                }
            

                if (jsFromDate && jsToDate) {
                    const fromDateClearFormat = new moment(
                        jsFromDate.d,
                        "YYYY-MM-DD"
                    );
                    const toDateClearFormat = new moment(
                        jsToDate.d,
                        "YYYY-MM-DD"
                    );

                    step.dispatchEvent(
                        new CustomEvent('update', {
                             detail: {
                                dateStart: fromDateClearFormat.format("DD-MM-YYYY"),
                                dateEnd: toDateClearFormat.format("DD-MM-YYYY")
                             }, 
                             bubbles:true, 
                             composed:true
                         })
                    );
                } else if (jsFromDate) {
                    const fromDateClearFormat = new moment(
                        jsFromDate.d,
                        "YYYY-MM-DD"
                    );
                    step.dispatchEvent(
                        new CustomEvent('update', {
                             detail: {
                                dateStart: fromDateClearFormat.format("DD-MM-YYYY"),
                                dateEnd: null
                             }, 
                             bubbles:true, 
                             composed:true
                         })
                    );
                } else {
                    step.dispatchEvent(
                        new CustomEvent('update', {
                             detail: {
                                dateStart: null,
                                dateEnd: null
                             }, 
                             bubbles:true, 
                             composed:true
                         })
                    );
                }
            }
        });

        
    }

    updateStyle(){
        const head = document.head || document.getElementsByTagName("head")[0];
        if(this.calendarStyle){
            head.removeChild(this.calendarStyle);
        }
        this.calendarStyle = document.createElement("style");
        const targetMargin = $($(".fc-day-top")[0]).width()/2;
        const css =`.fc-view .fc-body .fc-start { 
                        margin-left: ${targetMargin}px; 
                        border-top-left-radius: 5px;
                        border-bottom-left-radius: 5px;
                    }
                    .fc-view .fc-body .fc-end { 
                        margin-right: ${targetMargin}px;
                        border-top-right-radius: 5px;
                        border-bottom-right-radius: 5px;
                    }`;
        this.calendarStyle.appendChild(
            document.createTextNode(css)
        );
        head.appendChild(this.calendarStyle);
    }

    getTemplate(){
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
        `;
    }
}

function initFrom(d, el) {
    var a = new moment(Date.now());
    if (
        d >= a.format("YYYY-MM-DD") &&
        checkStartDate(events, d)
    ) {
        jsFromDate = { d: d, el: el };
        $(jsFromDate.el).addClass("cell-range");
    } else if (d < a.format("YYYY-MM-DD")) {
        showMessage(message_1);
    }
}

function fillCells() {
    $calendar.find(`.cell-between`).removeClass("cell-between");
    if (jsToDate) {
        $calendar.find('.fc-day[data-date]').each(function () {
                const $item = $(this);
                const dateStr = $item.data("date");
                if (jsFromDate.d < dateStr && jsToDate.d > dateStr) {
                    $item.addClass("cell-between");
                }
            }
        );
    }
}

function clearAll() {
    if (jsToDate) {
        $(jsToDate.el).removeClass("cell-range");
    }
    if (jsFromDate) {
        $(jsFromDate.el).removeClass("cell-range");
    }
    jsToDate = null;
    jsFromDate = null;
}

function checkStartDate(events, startDate) {
    var result = true;

    for (var i = 0; i < events.length; i++) {
        var event = events[i];
        var startEvent = jQuery.fullCalendar
            .moment(event.start, "YYYY-MM-DD")
            .format("YYYY-MM-DD");
        var endEvent = jQuery.fullCalendar
            .moment(event.end, "YYYY-MM-DD")
            .subtract(1, "days")
            .format("YYYY-MM-DD");

        if (startDate < endEvent && startDate > startEvent) {
            result = false;
            showMessage(message_4);
            break;
        }
    }

    return result;
}

function checkDateRange(events, startDate, endDate) {
    var result = true;

    for (var i = 0; i < events.length; i++) {
        var event = events[i];
        var startEvent = jQuery.fullCalendar
            .moment(event.start, "YYYY-MM-DD")
            .format("YYYY-MM-DD");
        var endEvent = jQuery.fullCalendar
            .moment(event.end, "YYYY-MM-DD")
            .subtract(1, "days")
            .format("YYYY-MM-DD");

        if (startDate < endEvent && endDate > startEvent) {
            result = false;
            showMessage(message_3);
            break;
        }
    }

    return result;
}

function showMessage(message) {
    new ErrorAlert(message);
}

function ErrorAlert(message) {
    this.messageElement = $(
        `<div class="error-message"><p class="error-message__inner">Ошибка! ${message}</p></div>`
    );
    $(document.body).append(this.messageElement);
    setTimeout(() => {
        this.messageElement.fadeIn(function () {
            $(this).remove();
        });
    }, 2000);
}