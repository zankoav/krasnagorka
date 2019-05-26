import './welcome.scss';
import Swiper from 'swiper';

new Swiper('.welcome__swiper', {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    speed: 600,
    effect: 'fade',
    parallax: true,
    fadeEffect: {
        crossFade: true
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.welcome__pagination',
        clickable: true,
    }
});

