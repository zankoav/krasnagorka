/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc';
import './headerPrimary.scss';

export default class HeaderPrimary extends LightningElement {
    @api model;
}
