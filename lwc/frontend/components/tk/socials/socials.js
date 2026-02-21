
import { LightningElement, api } from 'lwc'
import './socials.scss'
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
