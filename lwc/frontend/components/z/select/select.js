import { LightningElement, track, api } from 'lwc';
import './select.scss';

export default class Select extends LightningElement {

    @api required;
    @api label;
    @api options;
    @api error;

    @track isOpen;

    @api showError(){
        this.error = true;
    }

    get currentOption(){
        return this.options.find(option => option.selected);
    }

    get value(){
        return this.currentOption?.name;
    }

    get selectBlockCss(){
        let result = "select__value-block";
        if(this.value != 0 && !this.value){
            result += ' select__value-block_empty';
        }
        if(this.error){
            result += ' select__value-block_error';
        }

        if(this.isOpen){
            result += ' select__value-block_open';
        }
        return result;
    }

    toggleHandler() {
        this.isOpen = !this.isOpen;
    }

    closeHandler() {
        this.isOpen = false;
    }

    chooseOption(event) {
        const value = event.currentTarget.dataset.value;
        if (this.currentValue?.id != value) {
            this.closeHandler();
            this.error = false;
            this.dispatchEvent(
                new CustomEvent('change', { detail: value })
            );
        }
    }
}