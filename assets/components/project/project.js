import './project.scss';
import $ from "jquery";
import fancybox from 'fancybox';

fancybox($);
import Swiper from "swiper";

$('.project__fancybox').on('click', function (event) {
    event.preventDefault();
});

$(window).on('resize', function () {
    if ($(window).width() > 768) {
        $('.project__fancybox').fancybox({
            openEffect: 'elastic',
            closeEffect: 'elastic',
            padding: 0,
            wrapCSS: 'project__fancy',
            helpers: {
                thumbs: {
                    width: 50,
                    height: 50
                }
            }
        });
    }
}).trigger('resize');


new Swiper('.project__swiper', {
    spaceBetween: 10,
    loop: true,
    pagination: {
        el: '.project__pagination',
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: '.project__next',
        prevEl: '.project__prev',
    }
});


