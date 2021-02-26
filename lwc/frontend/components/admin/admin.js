import { LightningElement, api, track} from 'lwc';
import './admin.scss';
export default class Admin extends LightningElement {
    
    @api model;
    @track settings;

    connectedCallback(){
        this.settings = {
            house: null,
            fio: null,
            phone: null,
            email: null,
            counts: null,
            dateStart: null,
            dateEnd: null,
            comment: null,
            passport: null,
            agreement: null,
            linkAgreement: 'http://tut.by',
            calendars: [...this.model.calendars],
            menu:[
                {
                    label: 'Выбор Домика',
                    value: 'house',
                    available: false,
                    active: true
                },
                {
                    label: 'Даты Бронирования',
                    value: 'date',
                    available: false,
                    active: false
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
        console.log('settings', this.settings);
    }

    updateAvailableSteps(){

        const availableSteps = ['house'];

        if(
            this.settings.house && 
            this.settings.counts.find(c=>c.selected)
        ){
            availableSteps.push('date');
        }

        if(
            availableSteps.includes('date') && 
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
            this.settings.agreement
        ){
            availableSteps.push('checkout');
        }

        this.settings.menu = this.settings.menu.map(item => {
            return {...item, available: availableSteps.includes(item.value)};
        });
    }
}
