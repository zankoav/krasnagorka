export default function Slider(classSlider){
    
    const FIRST = 'FIRST',
    LAST = 'LAST';

	const elementWrapper = document.querySelector(classSlider);
    let slides = elementWrapper.querySelectorAll('.slide-js');
    if(slides?.length < 2){
        return;
    }
    const fistElementClone = slides[0].cloneNode(true);
    fistElementClone.setAttribute('data-index',FIRST);
    const lastElementClone = slides[slides.length - 1].cloneNode(true);
    lastElementClone.setAttribute('data-index',LAST);

    elementWrapper.prepend(lastElementClone);
    elementWrapper.append(fistElementClone);

    slides = elementWrapper.querySelectorAll('.slide-js');
    const size = slides[0].clientWidth;
    let counter = 1;
    const transition = 'transform .4s ease-in';
    elementWrapper.style.transform = `translateX(${ -size*counter}px)`;

    elementWrapper.addEventListener('transitionend', () => {

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
        elementWrapper.style.transition = offTransition ? 'none' : transition;
        elementWrapper.style.transform = `translateX(${ -size*counter}px)`;
    }

    this.next = function(){
        if(counter >= slides.length - 1) return; 
        counter++;
        reinitWrapper(false);
    }
    
    this.prev = function(){
        if(counter <= 0) return;
        counter--;
        reinitWrapper(false);
    }
}
