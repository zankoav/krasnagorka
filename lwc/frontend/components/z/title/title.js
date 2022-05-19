/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc';
import './title.scss';

export default class Title extends LightningElement {
    @api title;
}
