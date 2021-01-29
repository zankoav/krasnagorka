import './slider.scss';

const FIRST = 'FIRST',
	  LAST = 'LAST';
const wrapper = document.querySelector('.slider__wrapper');
let slides = document.querySelectorAll('.slider__item');
const fistElementClone = slides[0].cloneNode(true);
fistElementClone.setAttribute('data-index',FIRST);
const lastElementClone = slides[slides.length - 1].cloneNode(true);
lastElementClone.setAttribute('data-index',LAST);
wrapper.prepend(lastElementClone);
wrapper.append(fistElementClone);
slides = document.querySelectorAll('.slider__item');
const size = slides[0].clientWidth;
let counter = 1;
const transition = 'transform .4s ease-in';
wrapper.style.transform = `translateX(${ -size*counter}px)`;

wrapper.addEventListener('transitionend', () => {

	if(slides[counter].dataset.index === LAST){
		counter = slides.length - 2;
		reinitWrapper(true);
	}
	
	if(slides[counter].dataset.index === FIRST){
		counter = slides.length - counter;
		reinitWrapper(true);
	}
});

function reinitWrapper(offTransition){
	wrapper.style.transition = offTransition ? 'none' : transition;
	wrapper.style.transform = `translateX(${ -size*counter}px)`;
}

export function next(){
	if(counter >= slides.length - 1) return; 
	counter++;
	reinitWrapper(false);
}

export function prev(){
	if(counter <= 0) return;
	counter--;
	reinitWrapper(false);
}

setInterval(prev, 2000);
// setTimeout(next, 4000);
// setTimeout(next, 6000);
// setTimeout(next, 8000);
// setTimeout(prev, 12000);
// setTimeout(prev, 14000);
// setTimeout(prev, 16000);
// setTimeout(prev, 18000);