import { LightningElement, track, api } from 'lwc';
// import {getCookie, setCookie} from 'z/utils';
import './stepCheckout.scss';

// const MAX_AGE = 3600 * 24 * 100;
export default class StepCheckout extends LightningElement {
    @api settings;

    get calendar() {
        return this.settings.calendars.find(c => c.selected);
    }

    get peopleCount() {
        return this.settings.counts.find(c => c.selected).name;
    }

    get childCount() {
        const item = this.settings.childCounts.find(c => c.selected);
        return item ? item.name : 0;
    }

    get dateStart() {
        return this.settings.dateStart.replace(/-/g, ".");
    }

    get dateEnd() {
        return this.settings.dateEnd.replace(/-/g, ".");
    }

    get comment() {
        return this.settings.comment || '—';
    }

    get passport() {
        return this.settings.passport || '—';
    }

    get buttonTitle() {
        let title = "Оплатить";
        if(this.settings.paymentMethod !== 'card'){
            title = "Забронировать";
        }
        return title;
    }
    
    connectedCallback(){
        gtag('event', 'step_navigation', {
            "step":"checkout",
            "type":"view"
        });
    }

    async bookingHandler() {
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    bookingErrorMessage: null
                },
                bubbles: true,
                composed: true
            })
        );
        this.dispatchEvent(
            new CustomEvent('booking', {
                bubbles: true,
                composed: true
            })
        );
    }

    async bookingPay(){
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    bookingErrorMessage: null
                },
                bubbles: true,
                composed: true
            })
        );
        
        this.dispatchEvent(
            new CustomEvent('order', {
                bubbles: true,
                composed: true
            })
        );
    }

    backButtonHandler() {
        const newMenu = this.settings.menu.map(it => {
            return { ...it, active: it.value === 'contacts' };
        });
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    menu: newMenu
                },
                bubbles: true,
                composed: true
            })
        );
    }
}