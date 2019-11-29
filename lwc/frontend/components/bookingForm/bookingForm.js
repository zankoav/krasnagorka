/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import {LightningElement, track, api} from 'lwc'
import {getCookie, setCookie} from "../utils/utils";
import Inputmask from "inputmask";
import './bookingForm.scss';

const MAX_AGE = 3600 * 24 * 100;
const ERROR_FIO_EMPTY = 'Поле ФИО не заполнено';
const ERROR_PHONE_EMPTY = 'Поле Телефон не заполнено';
const ERROR_EMAIL_EMPTY = 'Поле Email не заполнено';
const ERROR_DATE_START_EMPTY = 'Поле Дата заезда не заполнено';
const ERROR_DATE_END_EMPTY = 'Поле Дата выезда не заполнено';
const ERROR_COUNT_EMPTY = 'Поле Количество человек не заполнено';
const ERROR_EMAIL_INVALID = 'Поле Email не валидно';
const ERROR_CONTRACT_UNCHECKED = 'Вы не согласились с договором присоединения';
const ERROR_DATE_END_INVALID = 'Дата выезда должны быть позже даты заезда';

export default class BookingForm extends LightningElement {

    @api objectType;
    @api objectTitle;
    @api contractOffer;

    @track formMessageSuccess;
    @track formMessageError;
    @track isLoading;

    connectedCallback() {
        const cid = getCookie("_ga");
        if(cid){
            this.cid = cid.replace(/GA1.2./g, '');
        }

        this.fioValue =  getCookie('kg_name');
        this.phoneValue =  getCookie('kg_phone');
        this.emailValue =  getCookie('kg_email');

        if( this.fioValue && this.phoneValue && this.emailValue){
            this.isContactsExistsInCookies = true;
        }
    }

    renderedCallback() {
        this.fio = this.template.querySelector('[name="fio"]');
        Inputmask({regex: "^[a-zA-Zа-яА-Я\\s]*$"}).mask(this.fio);
        this.phone = this.template.querySelector('[name="phone"]');
        Inputmask({regex: "^[0-9]*$"}).mask(this.phone);
        this.email = this.template.querySelector('[name="email"]');
        this.dateStart = this.template.querySelector('[name="date-start"]');
        this.dateEnd = this.template.querySelector('[name="date-end"]');
        this.count = this.template.querySelector('[name="count"]');
        Inputmask({regex: "^[1-9][0-9]*$", "placeholder": ""}).mask(this.count);
        this.comment = this.template.querySelector('[name="comment"]');
        this.contract = this.template.querySelector('[name="contract"]');
        this.passport = this.template.querySelector('[name="passport"]');
        this.spam = this.template.querySelector('[name="message"]');


        if(this.isContactsExistsInCookies){
            this.isContactsExistsInCookies = false;
            this.fio.value =  this.fioValue;
            this.phone.value =  this.phoneValue;
            this.email.value =  this.emailValue;
        }
    }

    clearError() {
        this.formMessageError = null;
        this.formMessageSuccess = null;
    }

    sendOrder() {

        const spam = this.spam.value;

        if (spam) {
            return;
        }

        const fio = this.fio.value;

        if (!fio) {
            this.showError(ERROR_FIO_EMPTY);
            return;
        }

        const phone = this.phone.value;

        if (!phone) {
            this.showError(ERROR_PHONE_EMPTY);
            return;
        }

        const email = this.email.value;

        if (!email) {
            this.showError(ERROR_EMAIL_EMPTY);
            return;
        }

        if (!this.emailValidator(email)) {
            this.showError(ERROR_EMAIL_INVALID);
            return;
        }

        const dateStart = this.dateStart.value;

        if (!dateStart) {
            this.showError(ERROR_DATE_START_EMPTY);
            return;
        }
        const dateEnd = this.dateEnd.value;

        if (!dateEnd) {
            this.showError(ERROR_DATE_END_EMPTY);
            return;
        }

        if (dateEnd < dateStart) {
            this.showError(ERROR_DATE_END_INVALID);
            return;
        }

        const count = this.count.value;

        if (!count) {
            this.showError(ERROR_COUNT_EMPTY);
            return;
        }

        const passport = this.passport.value;
        const comment = this.comment.value;
        const contract = this.contract.checked;

        if (!contract) {
            this.showError(ERROR_CONTRACT_UNCHECKED);
            return;
        }

        this.formMessageError = null;
        this.isLoading = true;

        fetch('/wp-json/krasnagorka/v1/order/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8',
            },
            body: JSON.stringify({
                data: `fio=${fio}&phone=${phone}&email=${email}&dateStart=${dateStart}&dateEnd=${dateEnd}&count=${count}&contract=${contract}&comment=${comment}&bookingTitle=${this.objectTitle}&bookingType=${this.objectType}&cid=${this.cid}&passportId=${passport}`,
                message: spam
            })
        })
            .then(response => {
                return response.json();
            })
            .then(() => {
                this.isLoading = false;
                this.formMessageSuccess = 'Поздравляем! Вы успешно выполнили бронь. Наш сотрудник скоро свяжется с вами для уточнения деталей';
                this.dateStart.value = null;
                this.dateEnd.value = null;
                this.count.value = null;
                this.passport.value = null;
                this.comment.value = null;
                setCookie('kg_name', fio, {'max-age': MAX_AGE});
                setCookie('kg_phone', phone, {'max-age': MAX_AGE});
                setCookie('kg_email', email, {'max-age': MAX_AGE});
            })
            .catch(() => {
                this.isLoading = false;
                this.showError('Соединение с сервером прервано, попробуйте позже');
            });
    }

    showError(message) {
        this.formMessageSuccess = null;
        this.formMessageError = `Ошибка! ${message}`
    }

    emailValidator(email) {
        let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
}
