// Version: 1.1

import { LightningElement, api } from 'lwc';
import './loader.scss';

export default class Loader extends LightningElement {
    @api message;
    @api hideShadow;
    @api variant;

    renderedCallback() {
        const a = this.template.querySelector('.loader');
        a.className = this.hideShadow ? 'loader' : 'loader ete-shadow';

        if (this.variant === 'inverse') {
            a.classList.add('loader_inverse');
        }
    }
}