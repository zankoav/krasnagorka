import { LightningElement } from 'lwc'
import './freeDate.scss'

export default class FreeDate extends LightningElement {
    static renderMode = 'light'

    loading = false
    link
    errorMessage
    dateInfo = {
        free_date_from: null,
        free_date_to: null
    }

    handleChange(event) {
        this.errorMessage = null
        this.dateInfo[event.target.name] = event.target.value
    }

    async handleFind() {
        this.loading = true
        const from = this.dateInfo.free_date_from
        const to = this.dateInfo.free_date_to
        this.link = null
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
            this.link = `https://krasnagorka.by/kalendar-bronirovaniya/?free_date_from=${from}&free_date_to=${to}`
        } else if (responseData?.status == 400) {
            this.errorMessage = responseData.errorMessage
        } else {
            console.log('error', responseData)
        }
        this.loading = false
    }
}
