/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc';
import './widgets.scss';

export default class Widgets extends LightningElement {
    @api model;
}
