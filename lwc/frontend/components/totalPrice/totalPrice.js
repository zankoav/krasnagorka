import { LightningElement, api } from 'lwc';
import './totalPrice.scss';

export default class TotalPrice extends LightningElement {
    @api settings;

    connectedCallback(){
        console.log('Total Price hide decoding');
    }
}