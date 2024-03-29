import { LightningElement, track, api } from 'lwc'
import Inputmask from 'inputmask'
import { skip } from 'z/utils'

import './stepContact.scss'

export default class StepContact extends LightningElement {
    @api settings
    @track error

    async connectedCallback() {
        gtag('event', 'step_navigation', {
            step: 'contacts',
            type: 'view'
        })
        await skip()
        this.phone = this.template.querySelector('[name="phone"]')
        Inputmask({ regex: '^\\+[0-9]*$' }).mask(this.phone)
    }

    backButtonHandler() {
        let newMenu
        if (this.settings.eventId) {
            newMenu = this.settings.menu.map((it) => {
                return { ...it, active: it.value === 'house' }
            })
        } else {
            newMenu = this.settings.menu.map((it) => {
                return { ...it, active: it.value === 'additional_services' }
            })
        }
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    menu: newMenu
                },
                bubbles: true,
                composed: true
            })
        )
    }

    nextButtonHandler() {
        if (!this.settings.fio) {
            this.error = 'Введите ФИО'
        } else if (!this.settings.phone) {
            this.error = 'Введите телефон'
        } else if (!this.settings.email) {
            this.error = 'Введите email'
        } else if (!this.emailValidator(this.settings.email)) {
            this.error = 'Поле Email не валидно'
        } else if (!this.settings.passport) {
            this.error = 'Введите паспортные данные'
        } else if (!this.settings.agreement) {
            this.error = 'Вы не согласились с договором присоединения'
        } else if (!this.settings.adult) {
            this.error = 'Подтвердите, что вам уже есть 18'
        } else {
            const newMenu = this.settings.menu.map((it) => {
                return { ...it, active: it.value === 'checkout' }
            })
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        menu: newMenu
                    },
                    bubbles: true,
                    composed: true
                })
            )
        }
    }

    emailValidator(email) {
        let re =
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return re.test(email)
    }

    changeHandler(event) {
        const name = event.target.name
        let value = event.target.value
        if (name === 'agreement' || name === 'adult') {
            value = event.target.checked
        }
        if (name === 'passport') {
            value = value.toUpperCase()
        }
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    [name]: value
                },
                bubbles: true,
                composed: true
            })
        )
    }
}
