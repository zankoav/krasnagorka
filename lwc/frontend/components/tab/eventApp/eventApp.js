import { LightningElement, api } from 'lwc'
import './eventApp.scss'

export default class EventApp extends LightningElement {
    static renderMode = 'light'

    @api eventId

    connectedCallback() {
        console.log('Event App ready to work', this.eventId)
    }
}
