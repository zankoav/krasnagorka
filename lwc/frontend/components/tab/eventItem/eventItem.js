import { LightningElement, api } from 'lwc'
import './eventItem.scss'

export default class EventItem extends LightningElement {
    static renderMode = 'light'

    @api group

    selectedPeople
    selectedApportament
    selectedVar

    get img() {
        return this.selectedItem.image
    }

    get dateFrom() {
        return this.group.days.days.at(0)
    }

    get dateTo() {
        return this.group.days.days.at(-1)
    }

    get href() {
        return `https://krasnagorka.by/booking-form/?eventId=${this.group.eventId}&eventTabId=${this.group.eventTabId}&calendarId=${this.selectedApportament}&people=${this.selectedPeople}&var=${this.selectedVar}&obj=${this.selectedItem.house}`
    }

    get price() {
        return (
            (this.selectedItem.new_price + this.selectedVariant.pricePerDay) *
                (this.group.days.days.length - 1) *
                this.selectedPeople +
            this.selectedVariant.priceSingle
        )
    }

    get selectedVariant() {
        return this.group.variants.find((variant) => variant.id == this.selectedVar)
    }

    get selectedItem() {
        return this.group.items.find((item) => item.calendar == this.selectedApportament)
    }

    get peopleOptions() {
        const min = this.selectedItem.min_people
        const max = this.selectedItem.max_people
        const result = []
        for (let i = min; i < max + 1; i++) {
            result.push({
                id: i,
                name: i,
                selected: i == this.selectedPeople
            })
        }
        return result
    }

    get apportomentsOptions() {
        return this.group.items.map((item) => {
            return {
                id: item.calendar,
                name: item.calendar_name,
                selected: item.calendar == this.selectedApportament
            }
        })
    }

    get variantsOptions() {
        return this.group.variants.map((item) => {
            return {
                id: item.id,
                name: item.title,
                selected: item.id == this.selectedVar
            }
        })
    }

    get variantTooltip() {
        return [this.selectedVariant.descriptionPerDay, this.selectedVariant.descriptionSingle]
            .filter((item) => !!item)
            .join(', ')
    }

    connectedCallback() {
        console.log('group', this.group)
        this.selectedApportament = this.group.items.find((item) => item.selected).calendar
        this.selectedVar = this.group.variant_default
        this.selectedPeople = this.selectedItem.min_people
    }

    renderedCallback() {
        this.querySelector('.event-item__content-editor').innerHTML = this.selectedItem.content
    }

    peopleHandler(event) {
        this.selectedPeople = event.detail
    }

    apportomentsHandler(event) {
        this.selectedApportament = event.detail
        this.selectedPeople = this.selectedItem.min_people
    }

    variantsHandler(event) {
        this.selectedVar = event.detail
    }
}
