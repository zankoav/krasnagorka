/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc';
import './weather.scss';

export default class Weather extends LightningElement {

    @api weather;
}
