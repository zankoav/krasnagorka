var targetMargin;
jQuery(document).ready(function (e) {
    setTimeout(function () {
        e('[id^="calendar_"]').each(function () {
            cUrl = e(this).data("url"), e(this).fullCalendar({
                height: 300,
                loading: function (r) {
                    if(!targetMargin){
                        var cielWidth = e(e(".fc-day-top")[0]).width();
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
                    1 == r ? e(this).children("#cloader").show() : e(this).children("#cloader").hide()
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
        }), parseInt(e(window).width()) < 760 && e("#footer .avgrund-btn").each(function () {
            e(this).attr("href", "/kak-zabronirovat/"), e(this).removeClass("avgrund-btn")
        })
        
        
    }, 3000);
});

jQuery('.booking-houses__calendars-button').on('click', function (event) {
    event.preventDefault();
    var calendarShortcod = jQuery(this).data('calendar');
    var attArray = calendarShortcod.split('\"');
    var data = {
        action: 'calendar_action',
        id: attArray[1],
        slug:attArray[3]
    };
    var $parent = jQuery(this).parent().parent();
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
});