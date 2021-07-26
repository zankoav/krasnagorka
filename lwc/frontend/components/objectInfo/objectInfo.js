import { LightningElement, track, api } from 'lwc';
import './objectInfo.scss';

export default class ObjectInfo extends LightningElement {
    @api settings;

    connectedCallback(){
        console.log('settings', this.settings);
    }
}