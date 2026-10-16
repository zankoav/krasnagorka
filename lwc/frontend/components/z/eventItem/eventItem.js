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

    get bookingModelParams() {
        return {
            eventId: this.group.eventId,
            eventTabId: this.group.eventTabId,
            calendarId: this.selectedApportament,
            people: this.selectedPeople,
            var: this.selectedVar,
            obj: this.selectedItem.house,
            child: this.selectedChild
        }
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

    get priceFromOnePeopleView() {
        return this.priceViewModel(this.priceFromOnePeople)
    }

    get priceFromOneChildView() {
        return this.priceViewModel(this.priceFromOneChild)
    }

    get priceView() {
        return this.priceViewModel(this.price)
    }

    priceViewModel(value) {
        const [rub, penny] = Number(value).toFixed(2).split('.')
        return { rub, penny }
    }

    get selectedVariant() {
        return this.group.variants.find((variant) => variant.id == this.selectedVar)
    }

    get selectedItem() {
        return this.group.items.find((item) => item.calendar == this.selectedApportament)
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
        this.selectedApportament = this.group.items.find((item) => item.selected).calendar
        this.selectedVar = this.group.variant_default
        const requestedChild = Number(this.group.childCount) || 0
        const requestedPeople = Number(this.group.peopleCount) || this.selectedItem.min_people
        const minimumPeople = Math.max(1, this.selectedItem.min_people - requestedChild)

        this.selectedPeople = Math.min(
            Math.max(requestedPeople, minimumPeople),
            this.selectedItem.max_people
        )
        this.selectedChild = this.selectedItem.enabled_child
            ? Math.min(requestedChild, this.selectedItem.max_people - this.selectedPeople)
            : 0
    }

    variantsHandler(event) {
        this.selectedVar = event.detail
    }

    selectBooking() {
        this.dispatchEvent(
            new CustomEvent('loadbookingmodel', {
                detail: this.bookingModelParams,
                bubbles: true,
                composed: true
            })
        )
    }
}
