/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc';
import './admin.scss';

const img = require('./../../icons/big-fuel-marker.png');

export default class Admin extends LightningElement {
    _img = img;
    @api model;
}
