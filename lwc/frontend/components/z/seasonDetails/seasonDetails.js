import { api } from 'lwc'
import BaseBookingElement from 'base/baseBookingElement'

import './seasonDetails.scss'

export default class SeasonDetails extends BaseBookingElement {
    @api season
    @api house

    get targetHouse() {
        return this.season.houses.find((house) => {
            let result = house.id == this.house.id
            if (this.house.isTerem) {
                result = house.id == this.house.calendarId
            }
            return result
        })
    }

    get price() {
        // const price = parseInt(this.targetHouse.price)
        // return isNaN(price) ? null : price
        return this.targetHouse.price
    }

    get smartPrice() {
        return this.currencyModel(this.targetHouse.price)
    }

    get minPricePerDay() {
        const result = this.price * parseFloat(this.targetHouse.minPeople.replace(',', '.'))
        return isNaN(result) ? null : this.currencyModel(result)
    }

    get minDays() {
        return this.targetHouse.minDays
    }

    get smallAnimalPrice() {
        return this.currencyModel(this.targetHouse.smallAnimalPrice)
    }

    get bigAnimalPrice() {
        return this.currencyModel(this.targetHouse.bigAnimalPrice)
    }

    get showAnimalsService() {
        return !this.settings.calendars.find((cr) => cr.selected)?.isDeprecateAnimals
    }
}
