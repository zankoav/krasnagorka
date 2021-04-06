<?php

    $seasons = get_posts(['post_type'   => 'season', 'numberposts' => -1]);

    $from = $_POST['from'];
    $to = $_POST['to'];
    $seasonId = $_POST['season'];

    if(isset($_POST['season-generator'], $from, $to, $seasonId)){
        // Create post object
        $seasonInterval = array(
            'post_title'    => '',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 23,
            'post_type' => 'season_interval'
        );
        
        // Insert the post into the database
        $seasonIntervalId = wp_insert_post( $seasonInterval );
        update_post_meta($seasonIntervalId, 'season_id', $seasonId);
        update_post_meta($seasonIntervalId, 'season_from', $from);
        update_post_meta($seasonIntervalId, 'season_to', $to);

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
        flex: 1 0 500px;
        padding-right: 2rem;
    }

    .fc-view-container {
        background-color: #fff;
    }

    .reserved-type {
        display: inline-block;
        width: 20px;
        height: 20px;
        background-color: #65b2ed;
        margin-right: .25rem;

    }

    .reserved-type-wrapper {
        margin: 1.5rem 0 2rem;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .z-form-group {
        margin: 1rem 0;
    }

    .z-form-group__label {
        margin-right: 1rem;
        display: inline-block;
        width: 80px;
    }

    .z-input {
        display: inline-block;
        width: 200px;
    }

    .z-wrapper {
        display: flex;
    }

    .z-form {
        flex-grow: 1;
    }

    .mt-20 {
        margin-top: 2rem;
    }
</style>

<div class="wrap">
    <h1 class="wp-heading">Генератор сезонов</h1>
    <div class="z-wrapper">
        <div class="calendar_block">
            <div id="calendar"></div>
            <div class="reserved-type-wrapper">
                <b class="reserved-type"></b>Занято
            </div>
        </div>
        <form class="z-form"
              action=""
              method="POST">
            <div class="mt-20 cmb-td">
                <label class="z-form-group__label"
                       for="season-name">Сезон</label>
                <select class="cmb2_select"
                        id="season-name"
                        name="season">
                    <?php foreach($seasons as $season):?>
                    <option value="<?=$season->ID;?>">
                        <?=$season->post_title;?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="z-form-group">
                <label class="z-form-group__label"
                       for="season-from">Начало</label>
                <input id="season-from"
                       class="z-input"
                       type="text"
                       placeholder="Начало"
                       name="from"
                       readonly />
            </div>
            <div class="z-form-group">
                <label class="z-form-group__label"
                       for="season-to">Конец</label>
                <input id="season-to"
                       class="z-input"
                       type="text"
                       placeholder="Конец"
                       name="to"
                       readonly />
            </div>
            <input id="season-id"
                   type="hidden"
                   name="season-id"
                   readonly />
            <input type="submit"
                   class="button button-primary button-large"
                   name="season-generator"
                   value="Создать сезонный интервал" />
        </form>
    </div>


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