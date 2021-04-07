<?php

    $seasons = get_posts(['post_type'   => 'season', 'numberposts' => -1]);
    
    $from = $_POST['from'];
    $to = $_POST['to'];
    $seasonId = $_POST['season'];

    if(isset($_POST['season-generator'], $from, $to, $seasonId) and !empty($from) and !empty($to)){
        // Create post object
        $seasonInterval = array(
            'post_title'    => "С $from По $to",
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

    }else if (isset($_POST['season-generator'])){
        $errroMessage = 'Заполните Даты';
    }

    $seasonIntervals = get_posts(['post_type'   => 'season_interval', 'numberposts' => -1]);
    $result = [];
    foreach($seasonIntervals as $interval){
        $from = get_post_meta($interval->ID,'season_from',1);
        $to = get_post_meta($interval->ID,'season_to',1);

        $dateFrom = new DateTime($from);
        $from = $dateFrom->format('Y-m-d');

        $dateTo = new DateTime($to);
        $to = $dateTo->format('Y-m-d');

        $result[]=[
            "id" => $interval->ID, 
            "start" => $from."T10:30:00", 
            "end" => $to."T11:30:00",
            "allDay" => false,
            "color"=> "#2271b1"
        ];
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
        background-color: #2271b1;
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

    .fc-time {
        display: none;
    }

    .ml-20 {
        margin-left: 2rem !important;
    }
</style>

<div class="wrap">
    <h1 class="wp-heading">Генератор сезонов</h1>
    <div class="z-wrapper">
        <div class="calendar_block">
            <div id="calendar"></div>
            <div class="reserved-type-wrapper">
                <b class="reserved-type"></b>Занято
                <input type="button"
                       id="z-clear"
                       class="ml-20 button button-large"
                       value="Очистить" />
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

    const message_1 = "Нельзя выбирать прошлые даты",
        message_2 = "Дата начала должна быть позже даты окончания интервала",
        message_3 = "Интервалы не должно пересекаться",
        message_4 = "Выберите свободную дату";

    let $ = jQuery;
    let events = JSON.parse('<?=json_encode($result)?>');
    let jsFromDate, jsToDate, $calendar;
    const errorMessage = "<?=$errroMessage;?>";
    if(errorMessage){
        showMessage(errorMessage);
    }

    $('#z-clear').click(function () {
        clearAll();
        fillCells();
        updateDates('', '');
    });

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
            const cell = this;
            const datePressed = date.format("YYYY-MM-DD");
            const dateToday = (new moment(Date.now())).format("YYYY-MM-DD");

            if (isBusy(datePressed)) {
                showMessage(message_4);
            } else if (datePressed < dateToday) {
                showMessage(message_1);
            } else if (!jsFromDate) {
                jsFromDate = { d: datePressed, el: cell };
                const fromDateClearFormat = new moment(
                    jsFromDate.d,
                    "YYYY-MM-DD"
                );
                $(jsFromDate.el).addClass("cell-range");
                updateDates(
                    fromDateClearFormat.format("DD-MM-YYYY"),
                    fromDateClearFormat.format("DD-MM-YYYY")
                );
            } else if (isBusyInterval(datePressed)) {
                showMessage(message_3);
            } else if (
                !jsToDate &&
                (new moment(jsFromDate.d, "YYYY-MM-DD")).format("YYYY-MM-DD") <= datePressed) {

                const fromDateClearFormat = new moment(
                    jsFromDate.d,
                    "YYYY-MM-DD"
                );

                jsToDate = { d: datePressed, el: cell };
                const toDateClearFormat = new moment(
                    jsToDate.d,
                    "YYYY-MM-DD"
                );

                fillCells();
                updateDates(
                    fromDateClearFormat.format("DD-MM-YYYY"),
                    toDateClearFormat.format("DD-MM-YYYY")
                );
            }
        }
    });

    function isBusy(date) {
        let result = false;

        events.forEach(event => {
            const from = (new moment(event.start, "YYYY-MM-DD")).format("YYYY-MM-DD");
            const to = (new moment(event.end, "YYYY-MM-DD")).format("YYYY-MM-DD");
            if (date >= from && date <= to) {
                result = true;
            }
        });
        return result;
    }

    function isBusyInterval(endDate) {
        let result = false;

        const startDate = new moment(
            jsFromDate.d,
            "YYYY-MM-DD"
        ).format("YYYY-MM-DD");

        events.forEach(event => {
            const startEvent = (new moment(event.start, "YYYY-MM-DD")).format("YYYY-MM-DD");
            const endEvent = (new moment(event.end, "YYYY-MM-DD")).format("YYYY-MM-DD");
            if (startEvent >= startDate && startEvent <= endDate) {
                result = true;
            }
        });
        return result;
    }

    function updateDates(from, to) {
        $('#season-from').val(from);
        $('#season-to').val(to);
    }

    function fillCells() {
        $calendar.find(`.cell-between`).removeClass("cell-between");
        if (jsToDate) {
            $calendar.find('.fc-day[data-date]').each(function () {
                const $item = $(this);
                const dateStr = $item.data("date");
                if (jsFromDate.d <= dateStr && jsToDate.d >= dateStr) {
                    $item.addClass("cell-between");
                }
            });
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