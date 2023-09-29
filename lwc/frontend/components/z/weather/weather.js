/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc'
import './weather.scss'

export default class Weather extends LightningElement {
    @api weather

    get today() {
        return this.weather[0]
    }

    get todayText() {
        return replaceNbsps(this.weather[0].text)
    }

    get firstDay() {
        return this.weather[1]
    }

    get secondDay() {
        return this.weather[2]
    }

    get thirdDay() {
        return this.weather[3]
    }
}

function replaceNbsps(str) {
    var re = new RegExp(String.fromCharCode(160), 'g')
    return str.replace(re, ' ')
}
