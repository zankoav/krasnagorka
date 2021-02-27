import {LightningElement, track , api } from 'lwc';
import {getCookie, setCookie} from 'z/utils';
import './stepCheckout.scss';

const MAX_AGE = 3600 * 24 * 100;
export default class StepCheckout extends LightningElement {
    @api settings;

    get calendar(){
        return this.settings.calendars.find(c => c.selected);
    }

    get peopleCount(){
        return this.settings.counts.find(c => c.selected).name;
    }

    get dateStart(){
        return this.settings.dateStart.replaceAll('-', '.');
    }

    get dateEnd(){
        return this.settings.dateEnd.replaceAll('-', '.');
    }

    get comment(){
        return this.settings.commet || '—';
    }
    
    get passport(){
        return this.settings.passport || '—';
    }

    async bookingHandler(){

        const cid = getCookie("_ga") ? getCookie("_ga").replace(/GA1.2./g, "") : null;

        const requestData = {
            id: this.calendar.id,
            fio: this.settings.fio,
            phone: this.settings.phone,
            email: this.settings.email,
            dateStart: this.settings.dateStart,
            dateEnd: this.settings.dateEnd,
            count: this.peopleCount,
            contract: true,
            comment: this.settings.comment,
            orderTitle: this.calendar.name,
            orderType: 'Домик:',
            cid: cid,
            passport: this.settings.passport,
            data: `fio=${this.settings.fio}&phone=${this.settings.phone}&email=${this.settings.email}&dateStart=${this.settings.dateStart}&dateEnd=${this.settings.dateEnd}&count=${this.peopleCount}&contract=${true}&comment=${this.settings.comment}&bookingTitle=${this.calendar.name}&bookingType=${'Домик:'}&cid=${cid}&passportId=${this.settings.passport}&id=${this.calendar.id}`
        }
        console.log('booking', requestData);

        const response = await fetch("/wp-json/krasnagorka/v1/order/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(requestData)
        }).then(data => data.json());
        console.log('response', response);
        if(response){
            setCookie("kg_name", this.settings.fio, { "max-age": MAX_AGE });
            setCookie("kg_phone", this.settings.phone, { "max-age": MAX_AGE });
            setCookie("kg_email", this.settings.email, { "max-age": MAX_AGE });

            ga("send", {
                hitType: "event",
                eventCategory: "form_bronirovanie",
                eventAction: "success_send",
            });

            const amoResponse = await fetch("/wp-json/krasnagorka/v1/create-amocrm-lead/", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify({ data: response })
            }).then(data => data.json());
            console.log('amoResponse', amoResponse);
        }else{
            console.log(`Извините! Выбранные даты заняты. Выберите свободный интервал.`);
        }
    }

    backButtonHandler(){
        const newMenu = this.settings.menu.map(it => {
            return {...it, active:it.value === 'contacts'};
        });
        this.dispatchEvent(
            new CustomEvent('update', {
                 detail: {
                    menu: newMenu
                 }, 
                 bubbles:true, 
                 composed:true
             })
        );
    }
}