import { LightningElement, track, api } from 'lwc';
import './stepHouseCalendar.scss';

export default class StepHouseCalendar extends LightningElement {
    
    @api settings;
    @track loading;

    nextButtonHandler() {
        console.log('Pressed nextButtonHandler');
    }
}