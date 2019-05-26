import './latest-projects.scss';
import Swiper from 'swiper';

new Swiper('.latest-projects__swiper', {
    slidesPerView: 4,
    spaceBetween: 32,
    loop: true,
    pagination: {
        el: '.latest-projects__pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.latest-projects__next',
        prevEl: '.latest-projects__prev',
    },
    breakpoints: {
        480: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1280: {
            slidesPerView: 4,
        }
    }
});
