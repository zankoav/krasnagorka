import {LightningElement, api, track} from 'lwc';
import './contactsPopup.scss';
import velcome from './../../icons/velcome.svg';
import life from './../../icons/life.svg';
import mts from './../../icons/mts.svg';
import envelope from './../../icons/envelope.svg';
import clock from './../../icons/clock.svg';
import viber from './../../icons/messangers/viber.svg';
import whatsapp from './../../icons/messangers/whatsapp.svg';
import telegram from './../../icons/messangers/telegram.svg';

const DEFAULT_CSS_CLASS = 'contacts-popup';
const ACTIVE_CSS_CLASS = 'contacts-popup contacts-popup_active';

const ICONS = {
    velcome: velcome,
    viber: viber,
    whatsapp: whatsapp,
    telegram: telegram,
    mts: mts,
    life: life,
    envelope: envelope,
    clock: clock,
};

export default class ContactsPopup extends LightningElement {

    @api model;

    @track icons = ICONS;
    @track cssClass = DEFAULT_CSS_CLASS;
    @track hrefVelcome;
    @track hrefMts;
    @track hrefLife;
    @track hrefEmail;

    @api
    set isOpen(value) {

        this.cssClass = value ? ACTIVE_CSS_CLASS : DEFAULT_CSS_CLASS;

    }

    get isOpen() {
        return this.cssClass === ACTIVE_CSS_CLASS;
    }


    connectedCallback() {
        this.hrefVelcome = `tel: ${this.model.velcome}`;
        this.hrefMts = `tel: ${this.model.mts}`;
        this.hrefLife = `tel: ${this.model.life}`;
        this.hrefEmail = `mailto: ${this.model.email}`;
    }

    hidePopup() {
        this.dispatchEvent(new CustomEvent('hidepopup'));
    }

    renderedCallback() {
        const input = this.template.querySelector('input');

        if (input) {
            input.focus();
        }
    }
}