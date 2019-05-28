jQuery(document).ready(function (e) {
    setTimeout(function () {
        console.log('calendar init');
        e('[id^="calendar_"]').each(function () {
            cUrl = e(this).data("url"), e(this).fullCalendar({
                height: 300,
                loading: function (r) {
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