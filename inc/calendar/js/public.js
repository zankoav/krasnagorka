var targetMargin, scriptPublic;

jQuery('.booking-houses__calendars-button').on('click', function (event) {
    event.preventDefault();
    if(!scriptPublic){
        scriptPublic = document.createElement('script');
        scriptPublic.onload = function() {
            loadCalendar.call(this);
        };
        scriptPublic.src = "https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/public.js";
        document.getElementsByTagName('body')[0].appendChild(script);
    }else{
        loadCalendar.call(this);
    }
});

function loadCalendar(obj) {
    var calendarShortcod = jQuery(this).data('calendar');
    var attArray = calendarShortcod.split('\"');
    var data = {
        action: 'calendar_action',
        id: attArray[1],
        slug:attArray[3]
    };
    var $parent = jQuery(this).parent().parent().parent().find('.booking-houses__calendars-inner');
    var $parentDate = jQuery(this).parent().parent().parent().find('.our-house__date');
    jQuery(this).remove();
    jQuery.ajax(kg_ajax.url, {
        data: data,
        method: 'post',
        success: function (response) {
            if(response){
                $parent.empty().html(response);
                var $calendar = $parent.find('[data-url]');
                var cUrl = $calendar.data("url");
                $calendar.fullCalendar({
                    height: 300,
                    loading: function (r) {
                        $parentDate.css({'max-width': 292});
                        if(!targetMargin){
                            var cielWidth = jQuery(jQuery(".fc-day-top")[0]).width();
                            if(cielWidth){
                                targetMargin = cielWidth/2;
                            }

                            if(targetMargin){
                                var css = '.fc-view .fc-body .fc-start { margin-left: '+targetMargin+'px; border-top-left-radius: 5px;border-bottom-left-radius: 5px;}.fc-view .fc-body .fc-end { margin-right: '+targetMargin+'px; border-top-right-radius: 5px;border-bottom-right-radius: 5px;}',
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
                    header: {left: "prev", center: "title", right: "next"},
                    events: {
                        url: cUrl, error: function () {
                            console.log("Ошибка загрузки данных")
                        }
                    },
                    eventOverlap: !1
                })
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
});