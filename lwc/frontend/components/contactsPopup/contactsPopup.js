import {LightningElement, api, track} from 'lwc';
import './contactsPopup.scss';
import a1 from './../../icons/a1.png';
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
    a1: a1,
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
    @track hrefA1;
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
        this.hrefA1 = `tel: ${this.model.a1}`;
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