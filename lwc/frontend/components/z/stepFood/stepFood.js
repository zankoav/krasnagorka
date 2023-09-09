import { api } from 'lwc'
import BaseElement from 'base/BaseElement'

import './stepFood.scss'

export default class StepFood extends BaseElement {
    @api settings
    error

    get foodBreakfastPrice() {
        return this.currencyModel(this.settings.foodBreakfastPrice)
    }

    get foodLunchPrice() {
        return this.currencyModel(this.settings.foodLunchPrice)
    }

    get foodDinnerPrice() {
        return this.currencyModel(this.settings.foodDinnerPrice)
    }

    get foodTripleSalePrice() {
        return this.currencyModel(this.settings.foodTripleSalePrice)
    }

    get isCustom() {
        return (
            this.settings.foodVariant == 'custom' ||
            !this.variants.find((item) => item.value == this.settings.foodVariant)
        )
    }

    get variants() {
        let result = []

        if (this.settings.foodPackageBreakfastAvailable) {
            result.push({
                label: 'Завтраки',
                value: 'breakfast',
                postfix: `${this.settings.foodPackageBreakfastSale}%`,
                description: this.settings.foodPackageBreakfastDescription,
                selected: this.settings.foodVariant == 'breakfast'
            })
        }

        if (this.settings.foodPackageFullAvailable) {
            result.push({
                label: 'Полный пансион',
                value: 'full',
                postfix: this.settings.foodPackageFullSale ? `${this.settings.foodPackageFullSale}%` : null,
                description: this.settings.foodPackageFullDescription,
                selected: this.settings.foodVariant == 'full'
            })
        }

        result.push({
            label: 'Без питания',
            value: 'no_food',
            selected: this.settings.foodVariant == 'no_food'
        })

        result.push({
            label: 'Подобрать питание индивидуально',
            value: 'custom',
            selected: this.settings.foodVariant == 'custom'
        })

        if (!result.find((item) => item.value == this.settings.foodVariant)) {
            result = result.map((item) => {
                return { ...item, selected: item.value == 'custom' }
            })
        }

        return result
    }

    get foodAvailable() {
        return (
            this.settings.foodAvailable &&
            (this.settings.foodBreakfastPrice ||
                this.settings.foodLunchPrice ||
                this.settings.foodDinnerPrice)
        )
    }
    get optionsCount() {
        const counts = this.settings.counts.find((it) => it.selected).name
        const childCounts = this.settings.childCounts.find((it) => it.selected)?.name || 0
        let daysCount
        if (this.settings.eventTabId) {
            const dateStart = moment(this.settings.dateStart, 'DD-MM-YYYY')
            const dateEnd = moment(this.settings.dateEnd, 'DD-MM-YYYY')
            daysCount = dateEnd.diff(dateStart, 'days')
        } else {
            daysCount = this.settings.total.days_count
        }
        return (counts + childCounts) * daysCount + 1
    }

    get breakfastOptions() {
        return Array.from(Array(this.optionsCount), (_, index) => index).map((item) => {
            return {
                id: item,
                name: item,
                selected: this.settings.foodBreakfast === item
            }
        })
    }

    get lunchOptions() {
        return Array.from(Array(this.optionsCount), (_, index) => index).map((item) => {
            return {
                id: item,
                name: item,
                selected: this.settings.foodLunch === item
            }
        })
    }

    get dinnerOptions() {
        return Array.from(Array(this.optionsCount), (_, index) => index).map((item) => {
            return {
                id: item,
                name: item,
                selected: this.settings.foodDinner === item
            }
        })
    }

    connectedCallback() {
        this.changeVariantHandler({ detail: this.settings.foodVariant })
    }

    foodChange(event) {
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

    changeVariantHandler(event) {
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    foodVariant: event.detail
                },
                bubbles: true,
                composed: true
            })
        )
    }

    nextButtonHandler() {
        const newMenu = this.settings.menu.map((it) => {
            return { ...it, active: it.value === 'additional_services' }
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
