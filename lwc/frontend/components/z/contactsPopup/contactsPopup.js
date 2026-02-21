import { LightningElement, api, track } from 'lwc'
import './contactsPopup.scss'
import a1 from 'img/a1.png'
import life from 'img/life.svg'
import mts from 'img/mts.svg'
import envelope from 'img/envelope.svg'
import clock from 'img/clock.svg'
import viber from 'img/messangers/viber.svg'
import whatsapp from 'img/messangers/whatsapp.svg'
import telegram from 'img/messangers/telegram.svg'

const DEFAULT_CSS_CLASS = 'contacts-popup'
const ACTIVE_CSS_CLASS = 'contacts-popup contacts-popup_active'

const ICONS = {
    a1: a1,
    viber: viber,
    whatsapp: whatsapp,
    telegram: telegram,
    mts: mts,
    life: life,
    envelope: envelope,
    clock: clock
}

export default class ContactsPopup extends LightningElement {
    @api model

    @track icons = ICONS
    @track cssClass = DEFAULT_CSS_CLASS
    @track hrefA1
    @track hrefMts
    @track hrefLife
    @track hrefEmail

    @api
    set isOpen(value) {
        this.cssClass = value ? ACTIVE_CSS_CLASS : DEFAULT_CSS_CLASS
    }

    get isOpen() {
        return this.cssClass === ACTIVE_CSS_CLASS
    }

    get telegramLink() {
        const telegramItem = this.model.footerBottom.socials.find(
            (item) => item.value === 'telegram'
        )
        if (telegramItem) {
            return telegramItem.url
        }
    }

    connectedCallback() {
        if (this.model && this.model.popupContacts) {
            this.hrefA1 = `tel: ${this.model.popupContacts.a1}`
            this.hrefMts = `tel: ${this.model.popupContacts.mts}`
            this.hrefLife = `tel: ${this.model.popupContacts.life}`
            this.hrefEmail = `mailto: ${this.model.popupContacts.email}`
        }
    }

    hidePopup() {
        this.dispatchEvent(new CustomEvent('hidepopup'))
    }

    renderedCallback() {
        const input = this.template.querySelector('input')

        if (input) {
            input.focus()
        }
    }
}
