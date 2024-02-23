/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc'
import moment from 'moment'
import './slider.scss'

export default class Slider extends LightningElement {
    @api model

    renderedCallback() {
        const slider = this.template.querySelector('.slider')
        slider.innerHTML = getSwiperTemplate(this.model.events)
        new Swiper('.swiper', {
            // Optional parameters
            loop: true,
            spaceBetween: 0,
            slidesPerView: 'auto',
            centeredSlides: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        })
    }
}

function getSwiperTemplate(events) {
    moment.locale('ru')
    const slides = events
        .map((event) => {
            const timeFrom = new moment(event.date_start).format('D MMMM')
            const timeEnd = new moment(event.date_end).format('D MMMM')
            return `
                <div class="swiper-slide">
                    <a class="swiper-slide__link" href="${event.link}" style="background-image:url(${event.img});">
                        <h3 class="swiper-slide__title">${event.title}</h3>
                        <h6 class="swiper-slide__date">c ${timeFrom} по ${timeEnd}</h6>
                    </a>
                </div>
            `
        })
        .join('')
    return `
        <!-- Slider main container -->
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                ${slides}
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    `
}
