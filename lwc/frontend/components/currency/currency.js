/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import {LightningElement, track} from 'lwc';
import {setCookie} from "../utils/utils";
import './currency.scss';

const COOKIE_CURRENCY_SELECTED_KEY = 'cur_selected';
const COOKIE_CURRENCY_VALUE_KEY = 'currency';
const MAX_AGE = 3600 * 24 * 100;

const RUS_FLAG = require('./../../icons/flags/rur.svg');
const BYN_FLAG = require('./../../icons/flags/byn.svg');
const USD_FLAG = require('./../../icons/flags/usd.svg');
const EUR_FLAG = require('./../../icons/flags/eur.svg');

export default class Currency extends LightningElement {

    @track isOpenList;
    @track currencyFlag = BYN_FLAG;
    @track currencyLabel = 'byn';
    @track currencies = [
        {
            value: 'rur',
            label: 'rus',
            price: 1,
            icon: RUS_FLAG,
        },
        {
            value: 'byn',
            label: 'byn',
            price: 2,
            icon: BYN_FLAG,
        },
        {
            value: 'usd',
            label: 'usd',
            price: 3,
            icon: USD_FLAG,
        },
        {
            value: 'eur',
            label: 'eur',
            price: 4,
            icon: EUR_FLAG,
        },
    ];

    showCurrenciesList() {
        this.isOpenList = !this.isOpenList;
    }

    chooseCurrency(event) {
        const currencyLabel = event.currentTarget.dataset.lang;
        const currency = this.currencies.find(item => item.label === currencyLabel);
        if (currency) {
            this.currencyFlag = currency.icon;
            this.currencyLabel = currency.label;
            setCookie(COOKIE_CURRENCY_SELECTED_KEY, currency.value, {'max-age': MAX_AGE});
            setCookie(COOKIE_CURRENCY_VALUE_KEY, currency.price, {'max-age': MAX_AGE});
            this.isOpenList = false;
        }
    }
}



