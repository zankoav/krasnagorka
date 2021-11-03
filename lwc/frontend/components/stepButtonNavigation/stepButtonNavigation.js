import {LightningElement, track , api } from 'lwc';
import './stepButtonNavigation.scss';

export default class StepButtonNavigation extends LightningElement {
    @api isBackButtonNeed;
    @api nextTitle = "Далее";
    @api backTitle = "Назад";
    @api error;
    @api settings;


    get classForNextButton(){
        let canGoNext = false;
        this.settings.menu.forEach((item, index) => {
            console.log('item',item);
            if(!canGoNext && item.active && this.settings.menu[index + 1]){
                canGoNext = this.settings.menu[index + 1].available;
            }else if(!canGoNext && item.active && this.settings.menu.length === (index + 1)){
                canGoNext = true;
            }
        });
        return canGoNext ? 'step-button-navigation__button step-button-navigation__button_available' : 'step-button-navigation__button';
    }

    nextButtonPressed(){
        this.dispatchEvent(
            new CustomEvent('next', {bubbles:true, composed:true})
        );
    }

    backButtonPressed(){
        this.dispatchEvent(
            new CustomEvent('back', {bubbles:true, composed:true})
        );
    }
}