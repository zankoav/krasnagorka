import {LightningElement, track , api } from 'lwc';
import './stepsNavigator.scss';

export default class StepsNavigator extends LightningElement {
    
    delta = 0;

    @api settings;



    constructor(){
        super();
        this.move = this.moveMouse.bind(this);
        this.itemPressedHandler = this.itemPressed.bind(this);
    }


    renderedCallback(){
        this.animate();
    }

    animate(){
        
        this.template.querySelectorAll('.steps-navigator__item').forEach((element, index) => {
            element.className = this.settings.menu[index].active ? 
                'steps-navigator__item steps-navigator__item_active' : 
                this.settings.menu[index].available ? 'steps-navigator__item steps-navigator__item_available' :
                'steps-navigator__item';
        });

        if(!this.wrapper){
            this.wrapper = this.template.querySelector('.steps-navigator__wrapper');
            this.navigator = this.template.querySelector('.steps-navigator');
            this.wrapper.addEventListener('mousedown', this.pressDown.bind(this), {passive: true});
            this.wrapper.addEventListener('touchstart', this.pressDown.bind(this), {passive: true});
            window.addEventListener('mouseup', this.pressUp.bind(this), {passive: true});
            window.addEventListener('touchend', this.pressUp.bind(this), {passive: true});
        }

        setTimeout(()=>{
            const activeItem = this.template.querySelector('.steps-navigator__item_active');

            if(!activeItem)return;

            const offsetLeft = activeItem.offsetLeft;
            const offsetWidth = activeItem.offsetWidth;
            const offsetWidthNavigator = this.navigator.offsetWidth;
            const deltaNeedToMoveLeft = offsetWidth + offsetLeft - offsetWidthNavigator;
            this.wrapper.style.transition = 'transform .3s';
            if(deltaNeedToMoveLeft > 0){
                this.delta = -deltaNeedToMoveLeft;
            }else{
                this.delta = 0 ;
            }
            this.wrapper.style.transform = `translate3d(${this.delta}px,0,0)`;
            setTimeout(()=>{
                this.wrapper.style.transition = 'none';
            }, 400);

        },200);
    }

    pressDown(event){
        window.addEventListener('mousemove', this.move, false);
        window.addEventListener('touchmove', this.move, false);
        const touches = event.changedTouches;
        this.deltaMove = 0;
        this.clientX = event.clientX || touches[0].clientX;
        this.template.querySelectorAll('.steps-navigator__item').forEach(item => {
            item.addEventListener('mouseup', this.itemPressedHandler, false);
        })
    }

    pressUp(event){
        window.removeEventListener('mousemove', this.move, false);
        window.removeEventListener('touchmove', this.move, false);
    }

    moveMouse(event){
        const touches = event.changedTouches;
        let clientX = event.clientX || touches[0].clientX;
        this.deltaMove = this.clientX - clientX;
        this.delta -= this.deltaMove;
        this.clientX = clientX;
        let totalSize = 0;

        this.template.querySelectorAll('.steps-navigator__item').forEach(element => {
            totalSize += element.offsetWidth;
        });

        if(this.delta > 0 || this.navigator.offsetWidth >= totalSize){
            this.delta = 0;
        }else if(this.delta < this.navigator.offsetWidth - totalSize){
            this.delta = this.navigator.offsetWidth - totalSize;
        }

        this.wrapper.style.transform = `translate3d(${this.delta}px,0,0)`;

        if(Math.abs(this.deltaMove) > 0){
            this.template.querySelectorAll('.steps-navigator__item').forEach(item => {
                item.removeEventListener('mouseup', this.itemPressedHandler, false);
            });
        }
    }

    itemPressed(event){
        const value = event.currentTarget.dataset.value;
        const item = this.settings.menu.find(item => item.value === value);
        if(!item.active && item.available){
            const newMenu = this.settings.menu.map(it =>{
                return {...it, active: it.value === item.value};
            });
            this.dispatchEvent(
               new CustomEvent('update', {
                    detail: {
                        menu: newMenu
                    }, 
                    bubbles:true, 
                    composed:true
                })
            );
        }
    }
}