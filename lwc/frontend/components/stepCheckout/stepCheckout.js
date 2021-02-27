import {LightningElement, track , api } from 'lwc';
// import {getCookie, setCookie} from 'z/utils';
import './stepCheckout.scss';

// const MAX_AGE = 3600 * 24 * 100;
export default class StepCheckout extends LightningElement {
    @api settings;

    get calendar(){
        return this.settings.calendars.find(c => c.selected);
    }

    get peopleCount(){
        return this.settings.counts.find(c => c.selected).name;
    }

    get dateStart(){
        return this.settings.dateStart.replaceAll('-', '.');
    }

    get dateEnd(){
        return this.settings.dateEnd.replaceAll('-', '.');
    }

    get comment(){
        return this.settings.commet || '—';
    }
    
    get passport(){
        return this.settings.passport || '—';
    }

    async bookingHandler(){
        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    bookingErrorMessage: null
                 }, 
                 bubbles:true, 
                 composed:true
             })
        );
        this.dispatchEvent(
            new CustomEvent('booking', {
                 bubbles:true, 
                 composed:true
             })
        );
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