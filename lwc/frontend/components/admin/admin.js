import { LightningElement, api, track} from 'lwc';
import {getCookie} from 'z/utils';
import './admin.scss';
export default class Admin extends LightningElement {
    
    @api model;
    @track settings;

    connectedCallback(){

        this.settings = {
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
            menu:[
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

    updateSettings(event){
        if(event){
            this.settings = {...this.settings, ...event.detail};
        }
        this.updateAvailableSteps();
        console.log('updated settings', this.settings);
    }

    updateAvailableSteps(){

        const availableSteps = ['house'];

        if(
            this.settings.house && 
            this.settings.counts.find(c=>c.selected) && 
            this.settings.dateStart && 
            this.settings.dateEnd
        ){
            availableSteps.push('contacts');
        }

        if(
            availableSteps.includes('contacts') && 
            this.settings.fio && 
            this.settings.phone &&
            this.settings.email &&
            this.settings.passport &&
            this.settings.agreement
        ){
            availableSteps.push('checkout');
        }

        this.settings.menu = this.settings.menu.map(item => {
            return {...item, available: availableSteps.includes(item.value)};
        });
    }
}
