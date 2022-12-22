import { LightningElement, api } from 'lwc'
import { eventAppByTabId } from 'core/rest'
import './eventApp.scss'

export default class EventApp extends LightningElement {
    static renderMode = 'light'

    @api tabId
    groups = []

    async connectedCallback() {
        const response = await eventAppByTabId(this.tabId)

        if (response) {
            const tempGroups = {
                other: {
                    id: 'other',
                    items: []
                }
            }

            for (const calendar of response.calendars) {
                if (calendar.group) {
                    if (tempGroups[calendar.group]) {
                        tempGroups[calendar.group].items.push(calendar)
                    } else {
                        tempGroups[calendar.group] = {
                            id: calendar.group,
                            items: [calendar],
                            variants: response.variants,
                            variant_default: response.variant_default,
                            days: response.interval
                        }
                    }
                } else {
                    tempGroups.other.items.push(calendar)
                    tempGroups.other.variants = response.variants
                    tempGroups.other.variant_default = response.variant_default
                    tempGroups.other.days = response.interval
                }
            }

            this.groups = Object.values(tempGroups).sort((a, b) => {
                if (a.items.length > b.items.length) {
                    return -1
                } else {
                    return 1
                }
            })

            this.groups.forEach((group) => {
                group.items.forEach((item, index) => {
                    item.selected = !index
                })
                group.variants.forEach((variant, index) => {
                    variant.selected = variant.id == group.variant_default
                })
                group.eventId = this.tabId
            })
        }
    }
}
