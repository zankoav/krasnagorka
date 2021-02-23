import { LightningElement, api, track} from 'lwc';
import './admin.scss';
export default class Admin extends LightningElement {
    
    @api model;
    @track settings;

    connectedCallback(){
        this.settings = {
            calendars: [...this.model.calendars],
            house: null,
            fio: null,
            phone: null,
            email: null,
            counts: null,
            dateStart: null,
            dateEnd: null,
            comment: null,
            passport: null,
            menu:[
                {
                    label: 'Выбор Домика',
                    value: 'house',
                    available: true,
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
        }
    }

    updateSettings(event){
        this.settings = {...this.settings, ...event.detail};
        console.log('settings', this.settings);
    }
}
