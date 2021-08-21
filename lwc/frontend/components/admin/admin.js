import { LightningElement, api, track } from 'lwc';
import { getCookie } from 'z/utils';
import './admin.scss';

let calculatorHash;
export default class Admin extends LightningElement {

    @api model;
    @track settings;



    connectedCallback() {

        this.settings = {
            admin: this.model.admin,
            seasons: this.model.seasons,
            orderedSuccess: false,
            bookingErrorMessage: null,
            house: null,
            fio: getCookie("kg_name") || '',
            phone: getCookie("kg_phone") || '',
            email: getCookie("kg_email") || '',
            counts: null,
            childCounts: null,
            dateStart: this.model.dateFrom ?
                new moment(this.model.dateFrom, "YYYY-MM-DD").format("DD-MM-YYYY") :
                null
            ,
            dateEnd: this.model.dateTo ?
                new moment(this.model.dateTo, "YYYY-MM-DD").format("DD-MM-YYYY") :
                null
            ,
            comment: null,
            passport: null,
            agreement: false,
            linkAgreement: this.model.mainContent.contractOffer,
            calendars: [...this.model.calendars],
            menu: [
                {
                    label: 'Выбор Домика',
                    value: 'house',
                    available: true,
                    active: true
                },
                {
                    label: 'Контакты',
                    value: 'contacts',
                    available: false,
                    active: false
                },
                {
                    label: 'Заказ',
                    value: 'checkout',
                    available: false,
                    active: false
                }
            ]
        };

        this.updateSettings();
    }

    updateSettings(event) {
        if (event) {
            this.settings = { ...this.settings, ...event.detail };
        }
        this.updateAvailableSteps();
        this.checkTotalPrice();
    }

    updateAvailableSteps() {

        const availableSteps = ['house'];

        if (
            this.settings.house &&
            this.settings.counts.find(c => c.selected) &&
            this.settings.dateStart &&
            this.settings.dateEnd
        ) {
            availableSteps.push('contacts');
        }

        if (
            availableSteps.includes('contacts') &&
            this.settings.fio &&
            this.settings.phone &&
            this.settings.email &&
            this.settings.passport &&
            this.settings.agreement
        ) {
            availableSteps.push('checkout');
        }

        this.settings.menu = this.settings.menu.map(item => {
            return { ...item, available: availableSteps.includes(item.value) };
        });
    }

    async checkTotalPrice() {
        const peopleCount = this.settings.counts?.find(c => c.selected)?.name;

        if(!peopleCount || !this.settings.dateStart || !this.settings.dateEnd){
            this.updateSettingsOnly({total: null});
            return;
        }
        const house = this.settings.house.id;
        const dateStart = new moment(this.settings.dateStart, "DD-MM-YYYY").add(1, 'days').format("YYYY-MM-DD");
        const dateEnd = new moment(this.settings.dateEnd, "DD-MM-YYYY").format("YYYY-MM-DD");
        const calendarId = this.settings.house.calendarId;
        const isTerem = this.settings.house.isTerem;
        const hash = JSON.stringify({ house, dateStart, dateEnd, peopleCount, calendarId, isTerem });

        if (house && dateStart && dateEnd && peopleCount && hash != calculatorHash) {
            calculatorHash = hash;
            
            this.updateSettingsOnly({totalPriceLoading: true});

            const response = await fetch("https://krasnagorka.by/wp-json/krasnagorka/v1/ls/calculate/", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: calculatorHash
            });
            const data = await response.json();

            this.updateSettingsOnly({totalPriceLoading: false});

            if(data){
                this.updateSettingsOnly({total: data});
            }
        }
    }

    updateSettingsOnly(obj){
        this.settings = {...this.settings, ...obj};
    }
}
