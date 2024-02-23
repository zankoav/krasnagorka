/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc'
import './menu.scss'

export default class Menu extends LightningElement {
    @api model

    get telegramLink() {
        const tg = this.model.socials.find((item) => item.value === 'telegram')
        return tg?.url
    }

    get a1Link() {
        return `tel:${this.model.info.a1}`
    }

    get mtsLink() {
        return `tel:${this.model.info.mts}`
    }

    get mailLink() {
        return `mailto:${this.model.info.email}`
    }
}
