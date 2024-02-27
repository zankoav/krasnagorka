/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc'
import './socials.scss'
import ICON_VK from './../../../icons/socials/vk.svg'
import ICON_OK from './../../../icons/socials/ok.svg'
import ICON_INSTA from './../../../icons/socials/insta.svg'
import ICON_FB from './../../../icons/socials/fb.svg'
import ICON_YOUTUBE from './../../../icons/socials/youtube.svg'
import ICON_TELEGRAM from './../../../icons/socials/telegram.svg'
import ICON_TIKTOK from './../../../icons/socials/tiktok.svg'

const SOCIALS_ICONS = {
    insta: ICON_INSTA,
    ok: ICON_OK,
    vk: ICON_VK,
    fb: ICON_FB,
    youtube: ICON_YOUTUBE,
    telegram: ICON_TELEGRAM,
    tiktok: ICON_TIKTOK
}

export default class Socials extends LightningElement {
    @api model

    get socials() {
        return this.model.socials
            .map((item) => {
                return {
                    ...item,
                    icon: SOCIALS_ICONS[item.value]
                }
            })
            .filter((item) => item.url)
    }
}