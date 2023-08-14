import { LightningElement } from 'lwc'
import { CONSTANTS } from 'core/constants'

export default class BaseElement extends LightningElement {
    CONSTANTS = CONSTANTS

    currencyModel(value) {
        const priceArr = value.toFixed(2).split('.')
        return {
            rub: priceArr[0],
            penny: priceArr[1]
        }
    }
}
