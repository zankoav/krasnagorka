import {LightningElement, track , api } from 'lwc';
import './stepContact.scss';

export default class StepContact extends LightningElement {

    @api settings;
    // @api fio;
    // @api email;
    // @api phone;
    // @api count;
    // @api passport;
    // @api comment;

    // get isAvailable(){
    //     return  !!this.fio && 
    //             !!this.email && 
    //             !!this.phone &&
    //             !!this.count;
    // }

}