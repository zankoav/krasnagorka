import { LightningElement, api } from 'lwc'
import './bookingEvent.scss'

export default class BookingEvent extends LightningElement {
    @api model

    connectedCallback() {
        console.log('Hello world')
    }
}
