import { api } from 'lwc'
import BaseElement from 'base/baseElement'

export default class BaseBookingElement extends BaseElement {
    @api settings

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
