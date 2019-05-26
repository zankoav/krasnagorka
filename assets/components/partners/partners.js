import './partners.scss';
import Swiper from 'swiper';

new Swiper('.partners__container', {
    slidesPerView: 7,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    breakpoints: {
        480: {
            slidesPerView: 2,
            spaceBetween: 40,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 40,
        },
        768: {
            slidesPerView: 5,
            spaceBetween: 40,
        },
        1440: {
            slidesPerView: 7,
            spaceBetween: 40,
        },
        1920: {
            slidesPerView: 10,
            spaceBetween: 40,
        }
    }
});


