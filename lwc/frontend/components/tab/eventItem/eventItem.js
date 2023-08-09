import { LightningElement, api } from 'lwc'
import { UTILS } from 'core/utils'

import './eventItem.scss'

export default class EventItem extends LightningElement {
    static renderMode = 'light'

    @api group

    selectedPeople
    selectedChild
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
        return `https://krasnagorka.by/booking-form/?eventId=${this.group.eventId}&eventTabId=${this.group.eventTabId}&calendarId=${this.selectedApportament}&people=${this.selectedPeople}&var=${this.selectedVar}&obj=${this.selectedItem.house}&child=${this.selectedChild}`
    }

    get priceFromOnePeople() {
        let price = this.selectedItem.new_price
            ? this.selectedItem.new_price
            : this.selectedItem.old_price

        return (
            (price + this.selectedVariant.pricePerDay) * (this.group.days.days.length - 1) +
            this.selectedVariant.priceSingle / this.selectedPeople
        )
    }

    get oldPriceFromOnePeople() {
        let price = this.selectedItem.new_price ? this.selectedItem.old_price : null
        return (
            (price + this.selectedVariant.pricePerDay) * (this.group.days.days.length - 1) +
            this.selectedVariant.priceSingle / this.selectedPeople
        )
    }

    get priceFromOneChild() {
        let result = 0
        if (this.selectedChild) {
            let price = this.selectedItem.new_price_child
                ? this.selectedItem.new_price_child
                : this.selectedItem.old_price_child
            result = (price + this.selectedVariant.pricePerDay) * (this.group.days.days.length - 1)
        }
        return result
    }

    get oldPriceFromOneChild() {
        let result = null
        let price = this.selectedItem.new_price_child ? this.selectedItem.old_price_child : null
        if (price) {
            result = (price + this.selectedVariant.pricePerDay) * (this.group.days.days.length - 1)
        }
        return result
    }

    get oldPrice() {
        let result = null
        let price = this.selectedItem.new_price ? this.selectedItem.old_price : null
        let childPrice = this.selectedItem.new_price_child
            ? this.selectedItem.old_price_child
            : null
        if (price) {
            result =
                (price + this.selectedVariant.pricePerDay) *
                    (this.group.days.days.length - 1) *
                    this.selectedPeople +
                this.selectedVariant.priceSingle

            if (childPrice) {
                result +=
                    (childPrice + this.selectedVariant.pricePerDay) *
                    (this.group.days.days.length - 1) *
                    this.selectedChild
            }
        }
        return result
    }

    get price() {
        let price = this.selectedItem.new_price
            ? this.selectedItem.new_price
            : this.selectedItem.old_price

        let childPrice = this.selectedItem.new_price_child
            ? this.selectedItem.new_price_child
            : this.selectedItem.old_price_child

        price =
            (price + this.selectedVariant.pricePerDay) *
                (this.group.days.days.length - 1) *
                this.selectedPeople +
            (childPrice + this.selectedVariant.pricePerDay) *
                (this.group.days.days.length - 1) *
                this.selectedChild +
            this.selectedVariant.priceSingle

        return UTILS.normalizePrice(price)
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

    get childOptions() {
        const min = 0
        const max = this.selectedItem.max_people - this.selectedPeople
        const result = []
        for (let i = min; i < max + 1; i++) {
            result.push({
                id: i,
                name: i,
                selected: i == this.selectedChild
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
        this.selectedChild = 0
    }

    renderedCallback() {
        this.querySelector('.event-item__content-editor').innerHTML = this.selectedItem.content
    }

    peopleHandler(event) {
        this.selectedPeople = parseInt(event.detail)
        this.selectedChild = 0
    }

    childHandler(event) {
        this.selectedChild = parseInt(event.detail)
    }

    apportomentsHandler(event) {
        this.selectedApportament = event.detail
        this.selectedPeople = this.selectedItem.min_people
        this.selectedChild = 0
    }

    variantsHandler(event) {
        this.selectedVar = event.detail
    }
}
