/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc'
import './weather.scss'

export default class Weather extends LightningElement {
    @api model

    get today() {
        return this.model.weather[0]
    }

    get todayTemp() {
        return this.model.weather[0]?.temp.replace('&nbsp;', ' ')
    }
}
