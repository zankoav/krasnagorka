jQuery(document).ready(function (e) {
    var targetMargin;
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
                            css2 = `
                            .fc-view .fc-body .fc-start, .fc-view .fc-body .fc-end {
                                border:0;
                            }
                            .fc-view .fc-body .fc-start:before {
                                    content:'';
                                    position:absolute;
                                    width:0;
                                    height:0;
                                    left:0;
                                    top:0;
                                    border-top:8px solid transparent;
                                    border-left:${cielWidth}px solid white;
                            }
                            .fc-view .fc-body .fc-end:after {
                                    content:'';
                                    position:absolute;
                                    width:0;
                                    height:0;
                                    right:0;
                                    top:0;
                                    border-bottom:8px solid transparent;
                                    border-right:${cielWidth}px solid white;
                            }`,

                            head = document.head || document.getElementsByTagName('head')[0],
                            style = document.createElement('style');
                        
                            head.appendChild(style);
                            
                            style.type = 'text/css';
                            if (style.styleSheet){
                              // This is required for IE8 and below.
                              style.styleSheet.cssText = css;
                            } else {
                              style.appendChild(document.createTextNode(css2));
                            }
                             console.log('targetMargin', targetMargin);
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