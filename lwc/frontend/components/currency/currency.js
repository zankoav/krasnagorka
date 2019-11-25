/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import {LightningElement, track, api} from 'lwc';
import {setCookie, getCookie} from "../utils/utils";
import './currency.scss';

const COOKIE_CURRENCY_SELECTED_KEY = 'cur_selected';
const COOKIE_CURRENCY_VALUE_KEY = 'currency';
const MAX_AGE = 3600 * 24 * 100;

const RUS_FLAG = require('./../../icons/flags/rur.svg');
const BYN_FLAG = require('./../../icons/flags/byn.svg');
const USD_FLAG = require('./../../icons/flags/usd.svg');
const EUR_FLAG = require('./../../icons/flags/eur.svg');

export default class Currency extends LightningElement {

    @api currenciesPrices;
    @track isOpenList;
    @track currentCurrency;
    @track currencies = [
        {
            value: 'rur',
            label: 'rus',
            icon: RUS_FLAG,
        },
        {
            value: 'byn',
            label: 'byn',
            icon: BYN_FLAG,
        },
        {
            value: 'usd',
            label: 'usd',
            icon: USD_FLAG,
        },
        {
            value: 'eur',
            label: 'eur',
            icon: EUR_FLAG,
        },
    ];

    connectedCallback(){

        this.currencies.forEach(currency => {
            currency.price = this.currenciesPrices[currency.value];
        });

        const currencyCookieValue = getCookie(COOKIE_CURRENCY_SELECTED_KEY);

        if(currencyCookieValue){
            this.currentCurrency = this.currencies.find(item => item.value === currencyCookieValue);
        }else{
            this.currentCurrency = this.currencies.find(item => item.value === 'byn');
            setCookie(COOKIE_CURRENCY_SELECTED_KEY, this.currentCurrency.value, {'max-age': MAX_AGE});
            setCookie(COOKIE_CURRENCY_VALUE_KEY, this.currentCurrency.price, {'max-age': MAX_AGE});
        }
    }

    showCurrenciesList() {
        this.isOpenList = !this.isOpenList;
    }

    chooseCurrency(event) {
        const currencyLabel = event.currentTarget.dataset.lang;
        const currency = this.currencies.find(item => item.label === currencyLabel);
        if (currency) {
            this.currentCurrency = currency;
            setCookie(COOKIE_CURRENCY_SELECTED_KEY, currency.value, {'max-age': MAX_AGE});
            setCookie(COOKIE_CURRENCY_VALUE_KEY, currency.price, {'max-age': MAX_AGE});
            this.isOpenList = false;
        }
    }
}



