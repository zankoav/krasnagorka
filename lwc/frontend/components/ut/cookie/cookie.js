import { LightningElement } from 'lwc'
import './cookie.scss'
import { getCookie, setCookie } from 'core/utils'

export default class Cookie extends LightningElement {
    static renderMode = 'light'
    static COOKIE_KEY = 'ls_cookie_bot'
    static COOKIE_VALUE = 'yes'

    renderedCallback() {
        const value = getCookie(Cookie.COOKIE_KEY)
        if (value == Cookie.COOKIE_VALUE) {
            this.hideMySelf()
        }
    }

    setCookie() {
        setCookie(Cookie.COOKIE_KEY, Cookie.COOKIE_VALUE, { secure: true, 'max-age': 86400 * 90 })
        this.hideMySelf()
    }

    hideMySelf() {
        const utCookie = document.querySelector('ut-cookie')
        document.body.removeChild(utCookie)
    }
}
