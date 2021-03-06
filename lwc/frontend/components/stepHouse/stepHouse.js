import { LightningElement, track, api } from 'lwc';
import './stepHouse.scss';

export default class StepHouse extends LightningElement {

    @api settings;
    @track loading;
    @track error;

    connectedCallback() {
        const calendar = this.settings.calendars.find(c => c.selected);
        if (calendar && !this.settings.house) {
            this.initHouse(calendar.id, calendar.isTerem);
        }
    }

    async initHouse(calendarId, isTeremCalendar) {
        const id = parseInt(calendarId);
        this.error = false;
        this.loading = true;
        const house = await fetch(`https://krasnagorka.by/wp-json/krasnagorka/v1/ls/house/?calendarId=${id}&isTeremCalendar=${isTeremCalendar}`)
            .catch(error => {
                console.log('error', error);
            }).then(data => data.json());

        this.loading = false;
        const newCalendars = this.settings.calendars.map(c => {
            return { ...c, selected: c.id === id };
        });

        const count = parseInt(house.peopleMaxCount);
        const counts = Array.from(Array(count), (_, i) => i + 1).map(it => {
            return {
                id: it,
                selected: false,
                name: it,
            };
        });

        const childCounts = Array.from(Array(count + 1), (_, i) => i).map(it => {
            return {
                id: it,
                selected: false,
                name: it,
            };
        });

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
        );
    }

    calendarChange(event) {
        const calendar = this.settings.calendars.find(c => c.id == event.detail);
        this.initHouse(calendar.id, calendar.isTerem);
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    dateStart: null,
                    dateEnd: null
                },
                bubbles: true,
                composed: true
            })
        );
    }

    countChange(event) {
        const id = parseInt(event.detail);
        const newCounts = this.settings.counts.map(c => {
            return { ...c, selected: c.id === id };
        });

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    counts: newCounts,
                },
                bubbles: true,
                composed: true
            })
        );
        this.error = false;
    }

    childCountChange(event) {
        const id = parseInt(event.detail);
        const newChildCounts = this.settings.childCounts.map(c => {
            return { ...c, selected: c.id === id };
        });

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    childCounts: newChildCounts,
                },
                bubbles: true,
                composed: true
            })
        );
        this.error = false;
    }

    nextButtonHandler() {
        if (!this.settings.calendars.find(op => op.selected)) {
            const selectorCalendars = this.template.querySelector('.step-house__calendars');
            if (selectorCalendars) {
                selectorCalendars.showError();
                this.error = 'Выберите домик';
            }
        } else if (!this.settings.counts.find(op => op.selected)) {
            const selectorCounts = this.template.querySelector('.step-house__counts');
            if (selectorCounts) {
                selectorCounts.showError();
                this.error = 'Выберите количество отдыхающих';
            }
        } else {
            const newMenu = this.settings.menu.map(it => {
                return { ...it, active: it.value === 'date' };
            });
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        menu: newMenu
                    },
                    bubbles: true,
                    composed: true
                })
            );
        }
    }
}