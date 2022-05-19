import { LightningElement, api, track } from 'lwc';
import './totalPrice.scss';

export default class TotalPrice extends LightningElement {
    
    @api settings;
    @track isOpenTotalPrice;

    get classNameMore(){
        return this.isOpenTotalPrice ? 'total-price__more total-price__more_active' : 'total-price__more';
    }

    get prepaidPrice(){
        const prepaid = parseInt(this.settings.total.total_price * this.settings.prepaidType / 100);
        return prepaid == parseInt(this.settings.total.total_price) ? null : prepaid;
    }

    tooglePrice(){
        this.isOpenTotalPrice = !this.isOpenTotalPrice;
    }
    
}