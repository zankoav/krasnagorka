import { LightningElement, api } from 'lwc'
import './priceView.scss'

export default class PriceView extends LightningElement {
    @api price
    @api color = 'red'
    @api currency = 'руб'

    get priceViewCss() {
        return `price-view price-view_${this.color}`
    }
}
