import { LightningElement, api } from 'lwc'
import './select.scss'

export default class Select extends LightningElement {
    static renderMode = 'light'

    @api required
    @api label
    @api options
    @api disabled
    @api error

    isOpen

    @api showError() {
        this.error = true
    }

    get currentOption() {
        return this.options.find((option) => option.selected)
    }

    get value() {
        return this.currentOption?.name
    }

    get selectBlockCss() {
        let result = 'select__value-block'
        if (this.value != 0 && !this.value) {
            result += ' select__value-block_empty'
        }
        if (this.error) {
            result += ' select__value-block_error'
        }

        if (this.isOpen) {
            result += ' select__value-block_open'
        }

        if (this.disabled) {
            result += ' select__value-block_disabled'
        }

        return result
    }

    toggleHandler() {
        this.isOpen = !this.isOpen
    }

    closeHandler() {
        this.isOpen = false
    }

    chooseOption(event) {
        const value = event.currentTarget.dataset.value
        if (this.currentOption?.id != value) {
            this.closeHandler()
            this.error = false
            this.dispatchEvent(new CustomEvent('change', { detail: value }))
        }
    }
}
