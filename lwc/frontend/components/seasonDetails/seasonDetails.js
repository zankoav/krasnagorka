import { LightningElement, api } from 'lwc'
import './seasonDetails.scss'

export default class SeasonDetails extends LightningElement {
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
        const price = parseInt(this.targetHouse.price)
        return isNaN(price) ? null : price
    }

    get minPricePerDay() {
        const result =
            parseFloat(this.price) * parseFloat(this.targetHouse.minPeople.replace(',', '.'))
        return isNaN(result) ? null : parseInt(result)
    }

    get minDays() {
        return this.targetHouse.minDays
    }

    get smallAnimalPrice() {
        return this.targetHouse.smallAnimalPrice
    }

    get bigAnimalPrice() {
        return this.targetHouse.bigAnimalPrice
    }

    get smallAnimalsLabel() {
        return 'Стоимость для мелкого животного (<= 30 см от холки) за ночь'
    }
}
