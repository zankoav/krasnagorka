/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc';
import './paymentMethods.scss';

const PAYMENT_METHODS_OPTIONS = [
    {
        label:"Картой",
        value:"card"
    },
    {
        label:"Картой позже",
        value:"card_layter"
    },
    {
        label:"В офисе",
        value:"office"
    }
];

export default class PaymentMethods extends LightningElement {
   
    paymentMethods;
    prepaidOptions;
    @api settings;

    get prepead(){
        return this.settings.payment 
            && this.settings.minPrice 
            && this.settings.total.total_price >= this.settings.minPrice;
    }

    get paymentText(){

        const paymentMethod = this.settings.paymentMethod;
        const prepaidType = this.settings.prepaidType;

        let result = ''
        if(paymentMethod == 'card'){
            if(prepaidType == 100){
                result = this.settings.textFullCard
            }else{
                result = this.settings.textPartCard
            }
        }else if(paymentMethod == 'card_layter'){
            if(prepaidType == 100){
                result = this.settings.textFullLaterCard
            }else{
                result = this.settings.textPartLaterCard
            }
        }else if(paymentMethod == 'office'){
            if(prepaidType == 100){
                result = this.settings.textFullOffice
            }else{
                result = this.settings.textPartOffice
            }
        }
        
        return result;
    }

    connectedCallback(){
        if(this.settings.payment){
            this.prepaidOptions = this.settings.prepaidOptions.map((option,index) => {
                let selected;
                if(!this.settings.prepaidType && index === 0){
                    selected = true;
                }else if(this.settings.prepaidType){
                    selected = this.settings.prepaidType === option.value;
                }
                return {...option, selected: selected};
            });
            this.paymentMethods = PAYMENT_METHODS_OPTIONS.map((option,index) => {
                let selected;
                if(!this.settings.paymentMethod && index === 0){
                    selected = true;
                }else if(this.settings.paymentMethod){
                    selected = this.settings.paymentMethod === option.value;
                }
                return {...option, selected: selected};
            });
            if(!this.prepead){
                this.dispatchEvent(
                    new CustomEvent('update', {
                        detail: {
                        prepaidType: this.prepaidOptions[0].value
                        }, 
                        bubbles:true, 
                        composed:true
                     })
                );
            }
        }
    }

    paymentMethodsHandle(event){
        const value = event.detail;
        this.paymentMethods = this.paymentMethods.map(item => {
            return {...item, selected: item.value === value};
        });
        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    paymentMethod: value
                 }, 
                 bubbles:true, 
                 composed:true
             })
        );
    }

    prepaidOptionsHandle(event){
        const value = event.detail;
        this.prepaidOptions = this.prepaidOptions.map(item => {
            return {...item, selected: item.value === value};
        });
        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    prepaidType: value
                 }, 
                 bubbles:true, 
                 composed:true
             })
        );
    }
}
