import { LightningElement, track, api } from 'lwc';
import './select.scss';

export default class Select extends LightningElement {

    @api disabledLabel = "-- Choose option --";
    @api required;

    @api set options(values) {
        this.values = values;
        console.log('this.values', this.values);
        this.css = this.values.find(opt => opt.selected) ?
            'select__options select__options_selected' :
            'select__options';
    };

    get options() {
        return this.values;
    }

    get cssStyle() {
        return this.required ? 'select select_required' : 'select';
    }

    @track values;
    @track css;

    @api showError() {
        this.css = 'select__options select__options_error';
    }

    changeOption(event) {
        this.dispatchEvent(
            new CustomEvent('change', { detail: event.target.value })
        );
    }
}