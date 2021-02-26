import {LightningElement, track , api } from 'lwc';
import './stepCheckout.scss';

export default class StepCheckout extends LightningElement {
    @api settings;

    get calendarName(){
        return this.settings.calendars.find(c => c.selected).name;
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