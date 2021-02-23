import {LightningElement, track , api } from 'lwc';
import './stepButtonNavigation.scss';

export default class StepButtonNavigation extends LightningElement {
    @api isBackButtonNeed;
    @api nextTitle = "Далее";
    @api backTitle = "Назад";
    @api error;

    get classForNextButton(){
        return this.canGoNext ? 'step-button-navigation__button step-button-navigation__button_available' : 'step-button-navigation__button';
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