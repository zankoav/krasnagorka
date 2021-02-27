import {LightningElement, track , api } from 'lwc';
import Inputmask from "inputmask";
import {skip} from "z/utils";

import './stepContact.scss';

export default class StepContact extends LightningElement {

    @api settings;
    @track error;

    async connectedCallback() {
        await skip();
        this.fio = this.template.querySelector('[name="username"]');
		Inputmask({ regex: "^[a-zA-Zа-яА-Я\s]*$" }).mask(this.fio);
		this.phone = this.template.querySelector('[name="phone"]');
		Inputmask({ regex: "^\\+[0-9]*$" }).mask(this.phone);
    }

    backButtonHandler(){
        const newMenu = this.settings.menu.map(it => {
            return {...it, active:it.value === 'date'};
        });
        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    menu: newMenu
                 }, 
                 bubbles:true, 
                 composed:true
             })
        );
    }

    nextButtonHandler(){
        if(!this.settings.fio){
            this.error = 'Введите ФИО';
        }else if(!this.settings.phone){
            this.error = 'Введите телефон';
        }else if(!this.settings.email){
            this.error = 'Введите email';
        }else if(!this.settings.agreement){
            this.error = 'Вы не согласились с договором присоединения';
        }else{
            const newMenu = this.settings.menu.map(it => {
                return {...it, active:it.value === 'checkout'};
            });
            this.dispatchEvent(
                new CustomEvent('update', {
                     detail: {
                        menu: newMenu
                     }, 
                     bubbles:true, 
                     composed:true
                 })
            );
        }
    }

    changeHandler(event){
        const name = event.target.name;
        let value = event.target.value;
        if(name === 'agreement'){
            value = event.target.checked;
        }
        if(name === 'passport'){
            value = value.toUpperCase();
        }
        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    [name]: value
                 }, 
                 bubbles:true, 
                 composed:true
             })
        );
    }
}