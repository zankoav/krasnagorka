import { LightningElement, api } from 'lwc'
import { CONSTANTS } from 'core/constants'

export default class BaseElement extends LightningElement {
    @api settings

    CONSTANTS = CONSTANTS

    get isBasic() {
        return this.settings.scenario === this.CONSTANTS.SCENARIOS.BASIC
    }

    get isPackage() {
        return this.settings.scenario === this.CONSTANTS.SCENARIOS.PACKAGE
    }

    get isEvent() {
        return this.settings.scenario === this.CONSTANTS.SCENARIOS.EVENT
    }

    get isFier() {
        return this.settings.scenario === this.CONSTANTS.SCENARIOS.FIER
    }
}
