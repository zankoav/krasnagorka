<?php

    $from = $_POST['from'];
    $to = $_POST['to'];
    $seasonId = $_POST['season-id'];

    if(isset($_POST['season-generator'], $from, $to, $seasonId)){
        // to do
    }

?>

<link href="https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/css/public_style.css" rel="stylesheet"/>
<script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery.min.js' id='jquery-core-js'></script>
<script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>
<script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/dist/vendor/moment.min.js' id='moment-js'></script>
<script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/fullcalendar.min.js' id='fullcalendar-js'></script>
<script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/ru.js' id='ru-js'></script>

<div class="wrap">
    <h1 class="wp-heading">Seasons generator</h1>
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
    <form action="" method="POST">
        <input type="date" name="from" readonly/>
        <input type="date" name="to" readonly/>
        <input type="hidden" name="season-id" readonly/>
        <input type="submit" name="season-generator" value="Create"/>
    </form>
</div>

<script>
    let $ = jQuery;
        $calendar = $('#calendar');
        $calendar.fullCalendar({
            height: 400,
            locale: "ru",
            header: {
                left: "prev",
                center: "title",
                right: "next"
            },
            /*events: events,
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
            }*/
        });
</script>