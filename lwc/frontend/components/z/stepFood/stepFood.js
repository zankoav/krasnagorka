import { LightningElement, api, track } from 'lwc'
import './stepFood.scss'

export default class StepFood extends LightningElement {
    @api settings
    @track error

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
        console.log('daysCount', daysCount)
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
