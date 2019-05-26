jQuery(document).ready(function($) {
    var slug = $('#sbc_order_taxonomy_select').val();


    $('#calendar').fullCalendar({
        loading: function (bool) {
            console.log('events are being rendered'); // Add your script to show loading
        },
        eventAfterAllRender: function (view) {
            console.log('all events are rendered'); // remove your loading
        },
        locale: 'ru',
        events: {
            url: '/wp-json/calendars/'+slug
        },
        selectable: true,
        select: function(start, end) {
            st = moment(start).format("YYYY-MM-DD");
            en = moment(end).subtract(1, 'days');
            en = moment(en).format("YYYY-MM-DD");
            $('#sbc_order_start').val(st);
            $('#sbc_order_end').val(en);
        },
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        }
    });


    $('#sbc_order_taxonomy_select').change(function () {
        slug = $(this).val();
        slug = '/wp-json/calendars/'+slug;

        $('#calendar').fullCalendar('destroy');
        $('#calendar').fullCalendar({
            loading: function (bool) {
                console.log('events are being rendered'); // Add your script to show loading
            },
            eventAfterAllRender: function (view) {
                console.log('all events are rendered'); // remove your loading
            },
            locale: 'ru',
            events: {
                url: slug
            },
            selectable: true,
            select: function(start, end) {
                st = moment(start).format("YYYY-MM-DD");
                en = moment(end).subtract(1, 'days');
                en = moment(en).format("YYYY-MM-DD");
                $('#sbc_order_start').val(st);
                $('#sbc_order_end').val(en);
            },
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            }
        });
    });

});