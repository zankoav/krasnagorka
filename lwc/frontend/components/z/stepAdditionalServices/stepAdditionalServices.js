import BaseBookingElement from 'base/baseBookingElement'

import './stepAdditionalServices.scss'

export default class StepAdditionalServices extends BaseBookingElement {
    error

    get bathHouseBlackPrice() {
        return this.currencyModel(this.settings.bathHouseBlackPrice)
    }

    get bathHouseWhitePrice() {
        return this.currencyModel(this.settings.bathHouseWhitePrice)
    }

    get babyBedPrice() {
        return this.currencyModel(this.settings.babyBedPrice)
    }

    get animalsLabel() {
        return `Домашние животные`
    }

    get smallAnimalsAvailable() {
        return this.settings.seasons
            .find((s) => s.current)
            .houses.find((h) => h.id == this.settings.house.id).smallAnimalPrice
    }
    
    get bigAnimalsAvailable() {
        return this.settings.seasons
            .find((s) => s.current)
            .houses.find((h) => h.id == this.settings.house.id).bigAnimalPrice
    }

    get showBathHouses() {
        let result = true
        if (this.settings.package?.services?.find((item) => item == '5')) {
            result = false
        }
        return result
    }

    get bathHouseWhite() {
        return !!this.settings.bathHouseWhite
    }

    get bathHouseBlack() {
        return !!this.settings.bathHouseBlack
    }

    get showBabyBedService() {
        let result = !this.settings.calendars.find((cr) => cr.selected)?.isDeprecatedBabyBed
        if (result && this.settings.eventTabId) {
            result = this.settings.baby_bed_available
        } else if (result) {
            result = this.settings.total.baby_bed_available
        }
        return result
    }

    get showAnimalsService() {
        let result = false
        if (this.isPackage) {
            result = false
        } else if (this.settings.total?.accommodation) {
            result = false
        } else {
            result = !this.settings.calendars.find((cr) => cr.selected)?.isDeprecateAnimals
        }
        return result
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

    get smallAnimalOptions() {
        return Array.from(Array(3), (_, index) => index).map((item) => {
            return {
                id: item,
                name: item,
                selected: this.settings.smallAnimalCount === item
            }
        })
    }

    get bigAnimalOptions() {
        return Array.from(Array(3), (_, index) => index).map((item) => {
            return {
                id: item,
                name: item,
                selected: this.settings.bigAnimalCount === item
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

    changeAnimalsViewHandler(event) {
        const animalsShow = event.target.checked ? 1 : null

        const detail = {
            animalsShow: animalsShow
        }

        if (!animalsShow) {
            detail.smallAnimalCount = null
            detail.bigAnimalCount = null
        }

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: detail,
                bubbles: true,
                composed: true
            })
        )
    }

    seansChange(event) {
        const count = parseInt(event.detail)
        const name = event.target.getAttribute('data-name')

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

    animalsChange(event) {
        const count = parseInt(event.detail)
        const name = event.target.getAttribute('data-name')

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
        let newMenu
        if (this.settings.package?.services?.find((item) => item == '1')) {
            newMenu = this.settings.menu.map((it) => {
                return { ...it, active: it.value === 'house' }
            })
        } else {
            newMenu = this.settings.menu.map((it) => {
                return { ...it, active: it.value === 'food' }
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
}
