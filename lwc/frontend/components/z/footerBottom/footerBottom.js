/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api, track } from 'lwc'
import './footerBottom.scss'
import ICON_VK from 'img/socials/vk.svg'
import ICON_OK from 'img/socials/ok.svg'
import ICON_INSTA from 'img/socials/insta.svg'
import ICON_FB from 'img/socials/fb.svg'
import ICON_YOUTUBE from 'img/socials/youtube.svg'
import ICON_TELEGRAM from 'img/socials/tg.svg'
import ICON_TIKTOK from 'img/socials/tiktok.svg'

const SOCIALS_ICONS = {
    insta: ICON_INSTA,
    ok: ICON_OK,
    vk: ICON_VK,
    fb: ICON_FB,
    youtube: ICON_YOUTUBE,
    telegram: ICON_TELEGRAM,
    tiktok: ICON_TIKTOK
}

export default class FooterBottom extends LightningElement {
    @track socials
    @track _model
    @track phone
    @track hrefPhone

    @api showMobilePhone
    @api set model(value) {
        this._model = value
        this.socials = this.model.footerBottom.socials
            .map((item) => {
                return {
                    ...item,
                    icon: SOCIALS_ICONS[item.value]
                }
            })
            .filter((item) => item.url)
    }

    get model() {
        return this._model
    }

    connectedCallback() {
        if (this.showMobilePhone) {
            this.phone = this.model.popupContacts.a1
            this.hrefPhone = `tel: ${this.phone}`
        }
    }

    renderedCallback() {
        this.template.querySelector('.footer-bottom__right-side').innerHTML =
            this.model.footerBottom.unp
    }
}
