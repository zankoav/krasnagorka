import { LightningElement, api } from 'lwc';
import './spinner.scss';

export default class Spinner extends LightningElement {
    img = require('./../../icons/spinner.svg');
    @api text;
}
