import {LightningElement, track , api } from 'lwc';
import './stepCheckout.scss';

export default class StepCheckout extends LightningElement {
    @api settings;

    bookingHandler(){
        console.log('booking');
    }

    backButtonHandler(){
        const newMenu = this.settings.menu.map(it => {
            return {...it, active:it.value === 'contacts'};
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