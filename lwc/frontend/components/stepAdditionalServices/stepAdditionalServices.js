import { LightningElement, api, track } from 'lwc'
import './stepAdditionalServices.scss'

export default class StepAdditionalServices extends LightningElement {
    @api settings
    @track error

    get babyBedLabel() {
        return `Добавить детскую кроватку (${this.settings.babyBedPrice} BYN / ночь)`
    }

    get bathHouseBlackLabel() {
        return `Баня по-черному (${this.settings.bathHouseBlackPrice} BYN / 2 часа)`
    }

    get bathHouseWhiteLabel() {
        return `Баня по-белому (${this.settings.bathHouseWhitePrice} BYN / 2 часа)`
    }

    get bathHouseWhite() {
        return !!this.settings.bathHouseWhite
    }

    get bathHouseBlack() {
        return !!this.settings.bathHouseBlack
    }

    get seansWhiteOptions() {
        return Array.from(Array(24), (_, index) => index + 1).map((item) => {
            return {
                id: item,
                name: item,
                selected: this.settings.bathHouseWhite === item
            }
        })
    }

    get seansBlackOptions() {
        return Array.from(Array(24), (_, index) => index + 1).map((item) => {
            return {
                id: item,
                name: item,
                selected: this.settings.bathHouseBlack === item
            }
        })
    }

    changeBabyBadHandler(event) {
        const name = event.target.name
        let value = event.target.checked
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

    changeBathHouseBlackPriceHandler(event) {
        const name = event.target.name
        const count = event.target.checked ? 1 : null

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    [name]: count
                },
                bubbles: true,
                composed: true
            })
        )
    }

    changeBathHouseWhitePriceHandler(event) {
        const name = event.target.name
        const count = event.target.checked ? 1 : null

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    [name]: count
                },
                bubbles: true,
                composed: true
            })
        )
    }

    seansChange(event) {
        const count = parseInt(event.detail)
        const name = event.target.getAttribute('data-name')
        console.log(name, count)

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    [name]: count
                },
                bubbles: true,
                composed: true
            })
        )
    }

    nextButtonHandler() {
        const newMenu = this.settings.menu.map((it) => {
            return { ...it, active: it.value === 'contacts' }
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

    backButtonHandler() {
        const newMenu = this.settings.menu.map((it) => {
            return { ...it, active: it.value === 'house' }
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
