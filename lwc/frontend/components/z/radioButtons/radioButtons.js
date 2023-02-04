import { LightningElement, api } from 'lwc'
import './radioButtons.scss'
import radioButtons from './radioButtons.html'
import radioButtonsColumn from './radioButtonsColumn.html'

export default class RadioButtons extends LightningElement {
    @api options
    @api view

    render() {
        let result = radioButtons
        if (this.view === 'column') {
            result = radioButtonsColumn
        }

        return result
    }
}
