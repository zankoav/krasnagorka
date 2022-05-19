/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc';
import './footer.scss';

export default class Footer extends LightningElement {
    @api model;
}
