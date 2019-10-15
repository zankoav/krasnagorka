import { LightningElement, track } from 'lwc';
import './booking.scss';

export default class Booking extends LightningElement {
    connectedCallback(){
        console.log('Hello Bookings');
    }
}
