/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, track, api } from 'lwc'
import { setCookie, getCookie } from '../utils/utils'
import './currency.scss'

const COOKIE_CURRENCY_SELECTED_KEY = 'cur_selected'
const COOKIE_CURRENCY_VALUE_KEY = 'currency'
const MAX_AGE = 3600 * 24 * 100

import RUS_FLAG from './../../../icons/flags/rur.svg'
import BYN_FLAG from './../../../icons/flags/byn.svg'
import USD_FLAG from './../../../icons/flags/usd.svg'
import EUR_FLAG from './../../../icons/flags/eur.svg'

export default class Currency extends LightningElement {
    @api currenciesPrices
    @track isOpenList
    @track currentCurrency
    @track currencies = [
        {
            value: 'rur',
            label: 'rus',
            icon: RUS_FLAG
        },
        {
            value: 'byn',
            label: 'byn',
            icon: BYN_FLAG
        },
        {
            value: 'usd',
            label: 'usd',
            icon: USD_FLAG
        },
        {
            value: 'eur',
            label: 'eur',
            icon: EUR_FLAG
        }
    ]

    connectedCallback() {
        if (this.currenciesPrices) {
            this.currencies.forEach((currency) => {
                currency.price = this.currenciesPrices[currency.value]
            })

            const currencyCookieValue = getCookie(COOKIE_CURRENCY_SELECTED_KEY)

            if (currencyCookieValue) {
                this.currentCurrency = this.currencies.find(
                    (item) => item.value === currencyCookieValue
                )
            } else {
                this.currentCurrency = this.currencies.find((item) => item.value === 'byn')
                setCookie(COOKIE_CURRENCY_SELECTED_KEY, this.currentCurrency.value, {
                    'max-age': MAX_AGE
                })
                setCookie(COOKIE_CURRENCY_VALUE_KEY, this.currentCurrency.price, {
                    'max-age': MAX_AGE
                })
            }
        }
    }

    showCurrenciesList() {
        this.isOpenList = !this.isOpenList
    }

    chooseCurrency(event) {
        const currencyLabel = event.currentTarget.dataset.lang
        const currency = this.currencies.find((item) => item.label === currencyLabel)
        if (currency) {
            this.currentCurrency = currency
            setCookie(COOKIE_CURRENCY_SELECTED_KEY, currency.value, { 'max-age': MAX_AGE })
            setCookie(COOKIE_CURRENCY_VALUE_KEY, currency.price, { 'max-age': MAX_AGE })
            this.isOpenList = false
        }
    }
}
