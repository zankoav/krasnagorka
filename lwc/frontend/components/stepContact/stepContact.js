import {LightningElement, track , api } from 'lwc';
import './stepContact.scss';

export default class StepContact extends LightningElement {

    @api settings;
    @track error;
    
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

        // let newMenu = this.settings.menu.map(it => {
        //     let result;
        //     if(it.value === 'contacts' || it.value === 'checkout'){
        //         result = {
        //             ...it, 
        //             available: false
        //         };
        //     }else{
        //         result = {...it};
        //     }
        //     return result;
        // });


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