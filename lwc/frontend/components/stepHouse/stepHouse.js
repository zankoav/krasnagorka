import { LightningElement, track, api } from 'lwc'
import './stepHouse.scss'
import IMG_BOOKING from './../../icons/date-clicking-selecting.png'

export default class StepHouse extends LightningElement {
    @api settings
    @track loading
    @track bookingImg = IMG_BOOKING
    @track error

    get dateStart() {
        return this.settings.dateStart ? this.settings.dateStart.replace(/-/g, '.') : '—'
    }

    get dateEnd() {
        return this.settings.dateEnd ? this.settings.dateEnd.replace(/-/g, '.') : '—'
    }

    get currentSeason() {
        return this.settings.seasons.find((season) => season.current)
    }

    connectedCallback() {
        gtag('event', 'step_navigation', {
            step: 'house',
            type: 'view'
        })
        const calendar = this.settings.calendars.find((c) => c.selected)
        if (calendar && !this.settings.house) {
            this.initHouse(calendar.id, calendar.isTerem)
        }
    }

    async initHouse(calendarId, isTeremCalendar) {
        const id = parseInt(calendarId)
        this.error = false
        this.loading = true
        const house = await fetch(
            `https://krasnagorka.by/wp-json/krasnagorka/v1/ls/house/?calendarId=${id}&isTeremCalendar=${isTeremCalendar}`
        )
            .catch((error) => {
                console.log('error', error)
            })
            .then((data) => data.json())

        this.loading = false
        const newCalendars = this.settings.calendars.map((c) => {
            return { ...c, selected: c.id === id }
        })

        const count = parseInt(house.peopleMaxCount)
        const counts = Array.from(Array(count), (_, i) => i + 1).map((it) => {
            return {
                id: it,
                selected: false,
                name: it
            }
        })

        let maxChild = newCalendars.find((c) => c.selected).maxChild
        maxChild = maxChild > 0 ? maxChild + 1 : 1
        
        const childCounts = Array.from(Array(maxChild), (_, i) => i).map((it) => {
            return {
                id: it,
                selected: false,
                name: it
            }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    calendars: newCalendars,
                    house: house,
                    counts: counts,
                    childCounts: childCounts
                },
                bubbles: true,
                composed: true
            })
        )
    }

    calendarChange(event) {
        this.error = false
        const calendar = this.settings.calendars.find((c) => c.id == event.detail)
        this.initHouse(calendar.id, calendar.isTerem)
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    dateStart: null,
                    dateEnd: null
                },
                bubbles: true,
                composed: true
            })
        )
    }

    seasonsChange(event) {
        const seasons = this.settings.seasons.map((season) => {
            return {
                ...season,
                current: season.id == event.detail
            }
        })
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    seasons: seasons
                },
                bubbles: true,
                composed: true
            })
        )
    }

    countChange(event) {
        this.error = false
        const id = parseInt(event.detail)
        const newCounts = this.settings.counts.map((c) => {
            return { ...c, selected: c.id === id }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    counts: newCounts
                },
                bubbles: true,
                composed: true
            })
        )
        this.error = false
    }

    childCountChange(event) {
        const id = parseInt(event.detail)
        const newChildCounts = this.settings.childCounts.map((c) => {
            return { ...c, selected: c.id === id }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    childCounts: newChildCounts
                },
                bubbles: true,
                composed: true
            })
        )
        this.error = false
    }

    nextButtonHandler() {
        if (!this.settings.calendars.find((op) => op.selected)) {
            const selectorCalendars = this.template.querySelector('.step-house__calendars')
            if (selectorCalendars) {
                selectorCalendars.showError()
                this.error = 'Выберите домик'
            }
        } else if (!this.settings.counts.find((op) => op.selected)) {
            const selectorCounts = this.template.querySelector('.step-house__counts')
            if (selectorCounts) {
                selectorCounts.showError()
                this.error = 'Выберите количество отдыхающих'
            }
        } else if (!this.settings.dateStart) {
            this.error = 'Выберите дату заезда'
        } else if (!this.settings.dateEnd) {
            this.error = 'Выберите дату выезда'
        } else {
            const newMenu = this.settings.menu.map((it) => {
                return { ...it, active: it.value === 'food' }
            })
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        menu: newMenu
                    },
                    bubbles: true,
                    composed: true
                })
            )
        }
    }
}
