var targetMargin, scriptFullCalendar, scriptLocalCalendar, month;
var year = (new Date()).getFullYear();
var _startDate = '';
var _endDate = '';

jQuery('.booking-houses__calendars-button, .our-house__button-booking').on('click', function (event) {
    event.preventDefault();

    var func = loadCalendar.bind(this);
    if (!scriptFullCalendar) {
        scriptFullCalendar = document.createElement('script');
        scriptLocalCalendar = document.createElement('script');

        scriptFullCalendar.onload = function () {
            scriptLocalCalendar.src = "https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/ru.js";
            document.getElementsByTagName('body')[0].appendChild(scriptLocalCalendar);
        };
        scriptLocalCalendar.onload = function () {
            func();
        };

        scriptFullCalendar.src = "https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/fullcalendar.min.js";
        document.getElementsByTagName('body')[0].appendChild(scriptFullCalendar);

    } else {
        func();
    }
});


function loadCalendar() {
    var calendarShortcod = jQuery(this).data('calendar');
    var attArray = calendarShortcod.split('\"');
    var data = {
        action: 'calendar_action',
        id: attArray[1],
        slug: attArray[3]
    };
    var $parent = jQuery(this).parent().parent().parent().find('.booking-houses__calendars-inner');
    var $parentDate = jQuery(this).parent().parent().parent().find('.our-house__date');
    var $orderButton = jQuery(this).parent().parent().parent().find('.our-house__button[data-name]');
    var eventEndData;

    function setDate(){
        console.log('gg',_startDate, _endDate);
        setTimeout(function(){
            jQuery('[name="date-1"]').val(_startDate);
            jQuery('[name="date-2"]').val(_endDate);
            jQuery('#fancybox-close, #fancybox-overlay').on('click', function(){
                _startDate = '';
                _endDate = '';
            });
        }, 40);
    }
    jQuery('.house-booking__button').on('click', setDate);
    $orderButton.on('click', setDate);
    jQuery(this).remove();
    jQuery.ajax(kg_ajax.url, {
        data: data,
        method: 'post',
        success: function (response) {
            if (response) {
                console.log("response", response);
                
                $parent.empty().html(response);
                var $calendar = $parent.find('[data-url]');
                var cUrl = $calendar.data("url");
                $calendar.fullCalendar({
                    height: 300,
                    loading: function (r) {
                        $parentDate.css({'max-width': 292});
                        if (!targetMargin) {
                            var cielWidth = jQuery(jQuery(".fc-day-top")[0]).width();
                            if (cielWidth) {
                                targetMargin = cielWidth / 2;
                            }

                            if (targetMargin) {
                                var css = '.fc-view .fc-body .fc-start { margin-left: ' + targetMargin + 'px; border-top-left-radius: 5px;border-bottom-left-radius: 5px;}.fc-view .fc-body .fc-end { margin-right: ' + targetMargin + 'px; border-top-right-radius: 5px;border-bottom-right-radius: 5px;}',
                                    head = document.head || document.getElementsByTagName('head')[0],
                                    style = document.createElement('style');

                                head.appendChild(style);

                                style.type = 'text/css';
                                style.appendChild(document.createTextNode(css));
                            }
                        }
                        1 == r ? $calendar.children("#cloader").show() : $calendar.children("#cloader").hide()
                    },
                    locale: "ru",
                    selectable: true,
                    selectHelper: true,
                    header: {left: "prev", center: "title", right: "next"},
                    events: {
                        url: cUrl,
                        error: function () {
                            console.log("Ошибка загрузки данных")
                        }
                    },
                    selectAllow:function (selectInfo) {
                        var selectAllowEndDate = selectInfo.end.format('l');
                        console.log('selectAllowEndDate', selectAllowEndDate);
                        console.log('is allow', eventEndData === selectAllowEndDate);
                        console.log('events',this.events);
                        
                        return eventEndData === selectAllowEndDate;
                    },
                    selectOverlap: function(event) {
                        eventEndData = event.end.format('l');
                        console.log('eventEndData', eventEndData);
                        return true;//event.rendering === 'background';
                    },
                    select: function(startDate, endDate) {
                        _startDate = startDate.format();
                        _endDate = endDate.subtract(1, 'days').format();
                    }
                });

                var isAdmin = document.getElementById('wpadminbar');
                if (isAdmin && month) {
                    var noTime = jQuery.fullCalendar.moment(year + '-' + month + '-01');
                    $calendar.fullCalendar('gotoDate', noTime);
                }
            }
        },
        error: function (x, y, z) {
            console.log('error', x);
        }
    });
}


jQuery('.booking-houses__calendars-all-button').on('click', function (event) {
    event.preventDefault();
    jQuery('.booking-houses__calendars-button').trigger('click');
    jQuery(this).remove();
    month = jQuery("#admin-month option:selected").val();
    jQuery('#admin-month').remove();
    year = jQuery("#admin-years option:selected").val();
    jQuery('#admin-years').remove();
});