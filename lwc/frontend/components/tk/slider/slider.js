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
    const slides = events
        .map((event) => {
            const timeFrom = new moment(event.date_start).format('DD.MM.YYYY')
            const timeEnd = new moment(event.date_end).format('DD.MM.YYYY')
            return `
                <a class="swiper-slide" href="${event.link}">
                    <div class="swiper-slide__link"  style="background-image:url(${event.img});">
                    </div>
                    <div class="swiper-slide__container">
                        <h3 class="swiper-slide__title">${event.title}</h3>
                        <h6 class="swiper-slide__date">${timeFrom} - ${timeEnd}</h6>
                        <p class="swiper-slide__price-info">
                            <span class="swiper-slide__price-currency">${event.price} BYN</span>
                            <span class="swiper-slide__price-description">${event.price_description}</span>
                        </p>
                    </div>
                </a>
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
