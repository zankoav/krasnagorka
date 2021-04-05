<?php

    $from = $_POST['from'];
    $to = $_POST['to'];
    $seasonId = $_POST['season-id'];

    if(isset($_POST['season-generator'], $from, $to, $seasonId)){
        echo $from,$to,$seaseonId;
    }

?>

<link href="https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/css/public_style.css"
      rel="stylesheet" />
<script type='text/javascript'
        src='https://krasnagorka.by/wp-includes/js/jquery/jquery.min.js'
        id='jquery-core-js'></script>
<script type='text/javascript'
        src='https://krasnagorka.by/wp-includes/js/jquery/jquery-migrate.min.js'
        id='jquery-migrate-js'></script>
<script type='text/javascript'
        src='https://krasnagorka.by/wp-includes/js/dist/vendor/moment.min.js'
        id='moment-js'></script>
<script type='text/javascript'
        src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/fullcalendar.min.js'
        id='fullcalendar-js'></script>
<script type='text/javascript'
        src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/ru.js'
        id='ru-js'></script>

<style>
    .cell-between,
    .cell-range {
        background-color: rgb(188, 232, 241);
    }

    .error-message {
        position: fixed;
        top: 100px;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        z-index: 9999999;
    }

    .error-message__inner {
        padding: 0.5rem 1rem;
        max-width: calc(100% - 50px);
        background-color: rgb(168, 3, 3);
        color: #fff;
        border-radius: 6px;
        box-shadow: 0 0px 4px 0px rgba(0, 0, 0, 0.75);
        font-size: 14px;
        font-weight: bold;
    }

    .calendar_block .calendar_legend ul li {
        width: 100%;
    }

    .calendar_block {
        width: 500px;
    }

    .fc-view-container {
        background-color: #fff;
    }
</style>

<div class="wrap">
    <h1 class="wp-heading">Seasons generator</h1>
    <div class="calendar_block">
        <div id="calendar"></div>
        <div class="calendar_legend">
            <ul>
                <li><b class="reserved"></b>Занято</li>
            </ul>
        </div>
    </div>
    <form action=""
          method="POST">
        <input id="season-from"
               type="hidden"
               name="from"
               readonly />
        <input id="season-to"
               type="hidden"
               name="to"
               readonly />
        <input id="season-id"
               type="hidden"
               name="season-id"
               readonly />
        <input type="submit"
               name="season-generator"
               value="Create" />
    </form>
</div>

<script>

    const message_1 = "Нельзя бронировать прошлые даты",
        message_2 = "Дата выезда должна быть позже даты заезда",
        message_3 = "В интервале бронирования не должно быть занятых дат",
        message_4 = "Выберите свободную дату";

    let $ = jQuery;
    let events = [];
    let jsFromDate, jsToDate, $calendar;
    $calendar = $('#calendar');

    $calendar.fullCalendar({
        height: 400,
        locale: "ru",
        header: {
            left: "prev",
            center: "title",
            right: "next"
        },
        events: events,
        eventAfterAllRender: () => {
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
            let newMenu;
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


                updateDates(
                    fromDateClearFormat.format("DD-MM-YYYY"),
                    toDateClearFormat.format("DD-MM-YYYY")
                );

            } else if (jsFromDate) {
                const fromDateClearFormat = new moment(
                    jsFromDate.d,
                    "YYYY-MM-DD"
                );


                updateDates(
                    fromDateClearFormat.format("DD-MM-YYYY")
                );
            } else {

                updateDates();
            }
        }
    });

    function updateDates(from, to) {
        console.log('from', from);
        console.log('to', to);
        $('#season-from').val(from);
        $('#season-to').val(to);
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
</script>