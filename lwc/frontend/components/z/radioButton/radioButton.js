
import { LightningElement, api } from 'lwc';
import './radioButton.scss';

export default class RadioButton extends LightningElement {
    @api item;

    get cssClass(){
        return this.item.selected ? "radio-button radio-button_selected" : "radio-button";
    }

    fierEvent(){
        this.dispatchEvent(new CustomEvent('radiochange', {
            detail:this.item.value,
            bubbles:true,
            composed: true
        }));
    }
}