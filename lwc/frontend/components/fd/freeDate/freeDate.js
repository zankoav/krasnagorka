import { LightningElement } from 'lwc'
import './freeDate.scss'

export default class FreeDate extends LightningElement {
    static renderMode = 'light'

    loading = false
    errorMessage
    content
    calendarsSetuped

    dateInfo = {
        free_date_from: null,
        free_date_to: null
    }

    handleChange(event) {
        this.errorMessage = null
        this.dateInfo[event.target.name] = event.target.value
    }

    async renderedCallback() {
        if (this.content && !this.calendarsSetuped) {
            await window.initCalendars(window.jQuery)
            this.calendarsSetuped = true
            this.openCalendars()
        }
    }

    async openCalendars() {
        await new Promise((resolve) => {
            setTimeout(resolve, 2000)
        })
        let cButtons = document.querySelectorAll('.booking-houses__calendars-button')
        for (let button of cButtons) {
            window.jQuery(button)?.trigger('click')
            await new Promise((resolve) => {
                setTimeout(resolve, 2000)
            })
        }
    }

    async handleFind() {
        this.loading = true
        this.content = null
        this.calendarsSetuped = null
        const from = this.dateInfo.free_date_from
        const to = this.dateInfo.free_date_to
        this.errorMessage = null
        const response = await fetch('https://krasnagorka.by/wp-json/krasnagorka/v1/ls/freeDate/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify(this.dateInfo)
        })
        const responseData = await response.json()
        if (responseData?.status == 200) {
            this.content = responseData
            this.content.calendars = this.content.calendars.map((calendar) => {
                let link = `/booking-form/?booking=${calendar.houseId}&calendarId=${calendar.id}`
                if (calendar.isTerem) {
                    link += `&terem=${calendar.name}`
                }
                return {
                    ...calendar,
                    dataShortCode: `[sbc_calendar id="${calendar.id}" slug="${calendar.slug}"]`,
                    dataBookingLink: `/booking-form/?booking=${calendar.houseId}&calendarId=${calendar.id}`
                }
            })
        } else if (responseData?.status == 400) {
            this.errorMessage = responseData.errorMessage
        } else {
            console.log('error', responseData)
        }
        this.loading = false
    }
}
