import { LightningElement, track, api } from 'lwc'
import './houseInfo.scss'

export default class HouseInfo extends LightningElement {
    @api settings

    get seasons() {
        return this.settings.seasons
            .map((season) => {
                return { ...season }
            })
            .sort((s1, s2) => {
                if (s1.order > s2.order) return -1
                else if (s1.order < s2.order) return 1
                else return 0
            })
    }
}
