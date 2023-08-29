import { api } from 'lwc'
import BaseElement from 'base/BaseElement'

import './decodingPriceLine.scss'

export default class DecodingPrice extends BaseElement {
    @api season

    get needBreakets() {
        return (
            this.season.price_block.base_price_without_upper ||
            this.season.price_block.people_sale ||
            this.season.price_block.days_sale
        )
    }

    get price() {
        let result = this.season.price_block.base_price_without_upper
            ? this.season.price_block.base_price_without_upper
            : this.season.price_block.base_price
        return this.currencyModel(result)
    }

    get priceBlockTotal() {
        return this.currencyModel(this.season.price_block.total)
    }

    get priceBlockSmallAnimalsPrice() {
        return this.currencyModel(this.season.price_block.small_animals_price)
    }

    get priceBlockSmallAnimalsTotalPrice() {
        return this.currencyModel(this.season.price_block.small_animals_total)
    }

    get priceBlockBigAnimalsPrice() {
        return this.currencyModel(this.season.price_block.big_animals_price)
    }

    get priceBlockBigAnimalsTotalPrice() {
        return this.currencyModel(this.season.price_block.big_animals_total)
    }
}
