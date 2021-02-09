import './slider.scss';
import Slider from './../utils/Slider';

const slider = new Slider('.slider-main');
const nextButton = document.querySelector('.slider__next');
const prevButton = document.querySelector('.slider__prev');
nextButton.onclick = slider.next;
prevButton.onclick = slider.prev;