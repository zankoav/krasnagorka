/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, api } from 'lwc'
import './alert.scss'

export default class Alert extends LightningElement {
    @api message
}
