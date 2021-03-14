/* eslint-disable @lwc/lwc/no-async-operation */
/* eslint-disable no-await-in-loop */
import { LightningElement, track, api } from "lwc";
import { getCookie, setCookie } from "../utils/utils";
import Inputmask from "inputmask";
import Pikaday from "pikaday";
import "./bookingForm.scss";

const MAX_AGE = 3600 * 24 * 100;
const ERROR_FIO_EMPTY = "Поле ФИО не заполнено";
const ERROR_PHONE_EMPTY = "Поле Телефон не заполнено";
const ERROR_EMAIL_EMPTY = "Поле Email не заполнено";
const ERROR_DATE_START_EMPTY = "Поле Дата заезда не заполнено";
const ERROR_DATE_END_EMPTY = "Поле Дата выезда не заполнено";
const ERROR_EMAIL_INVALID = "Поле Email не валидно";
const ERROR_CONTRACT_UNCHECKED = "Вы не согласились с договором присоединения";
const ERROR_DATE_END_INVALID = "Дата выезда должны быть позже даты заезда";
const ERROR_HOUSE_EMPTY = "Поле Домик/Мероприятие не заполнено";
const ERROR_DATE_START_LATE =
	"Поле Дата заезда должно быть не раньше сегоднешнего дня";

const i118 = {
	previousMonth: "Предыдущий",
	nextMonth: "Следующий",
	months: [
		"Январь",
		"Февраль",
		"Март",
		"Апрель",
		"Май",
		"Июнь",
		"Июль",
		"Август",
		"Сентябрь",
		"Октябрь",
		"Ноябрь",
		"Декабрь",
	],
	weekdays: [
		"Воскресенье",
		"Понедельник",
		"Вторник",
		"Среда",
		"Четверг",
		"Пятница",
		"Суббота",
	],
	weekdaysShort: ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
};

export default class BookingForm extends LightningElement {
	@api objectType;
	@api objectTitle;
	@api contractOffer;
	@api dateFrom;
	@api dateTo;
	@api objId;
	@api maxCount;
	@api eventTabId;
	@api pay;
	@api price;
	@api model;

	@track formMessageSuccess;
	@track formMessageError;
	@track isLoading;
	@track deprecateEditableDates;

	async skip() {
		await new Promise((resolve) => setImmediate(resolve));
	}

	async connectedCallback() {

        console.log('model', this.model);
        this.deprecateEditableDates = !!this.dateFrom;
		this.countItems = Array.from(Array(this.maxCount), (_, i) => i + 1);
		this.dateTo = this.dateTo || "";
		this.dateFrom = this.dateFrom || "";
		this.eventTabId = this.eventTabId || "";
		this.objId = this.objId === "undefined" ? null : this.objId;
		const cid = getCookie("_ga");
		if (cid) {
			this.cid = cid.replace(/GA1.2./g, "");
		}

		this.fioValue = getCookie("kg_name");
		this.phoneValue = getCookie("kg_phone");
		this.emailValue = getCookie("kg_email");

		if (this.fioValue && this.phoneValue && this.emailValue) {
			this.isContactsExistsInCookies = true;
		}
		await this.skip();
		this.dateStart = this.template.querySelector('[name="date-start"]');
        this.dateEnd = this.template.querySelector('[name="date-end"]');
        if(this.deprecateEditableDates){
            this.dateStart.setAttribute('disabled', 'disabled');
            this.dateEnd.setAttribute('disabled', 'disabled');
        }else{
            this.pikStart = new Pikaday({
                i18n: i118,
                field: this.dateStart,
                format: "YYYY-MM-DD",
                onSelect: (date) => {
                    let day = date.getDate();
                    day = day > 9 ? day : `0${day}`;
                    let month = date.getMonth() + 1;
                    month = month > 9 ? month : `0${month}`;
                    const year = date.getFullYear();
                    this.dateFrom = `${year}-${month}-${day}`;
                },
            });
            this.pikEnd = new Pikaday({
                i18n: i118,
                field: this.dateEnd,
                format: "YYYY-MM-DD",
                onSelect: (date) => {
                    let day = date.getDate();
                    day = day > 9 ? day : `0${day}`;
                    let month = date.getMonth() + 1;
                    month = month > 9 ? month : `0${month}`;
                    const year = date.getFullYear();
                    this.dateTo = `${year}-${month}-${day}`;
                },
            });
            
        }
		

		this.order = this.template.querySelector('[name="order"]');
		if (this.order) {
			Inputmask({ regex: "^[a-zA-Zа-яА-Я0-9\\s]*$" }).mask(this.order);
		}
		this.fio = this.template.querySelector('[name="fio"]');
		Inputmask({ regex: "^[a-zA-Zа-яА-Я\\s]*$" }).mask(this.fio);
		this.phone = this.template.querySelector('[name="phone"]');
		Inputmask({ regex: "^\\+[0-9]*$" }).mask(this.phone);
		this.email = this.template.querySelector('[name="email"]');
		this.count = this.template.querySelector('[name="count"]');
		this.comment = this.template.querySelector('[name="comment"]');
		this.contract = this.template.querySelector('[name="contract"]');
		this.passport = this.template.querySelector('[name="passport"]');
		this.spam = this.template.querySelector('[name="message"]');

		if (this.isContactsExistsInCookies) {
			this.isContactsExistsInCookies = false;
			this.fio.value = this.fioValue;
			this.phone.value = this.phoneValue;
			this.email.value = this.emailValue;
        }
        
        const url =  window.location.href
            .split('&')
            .filter(it => it.indexOf('clear=') === -1)
            .join('&');

        window.history.pushState({
            id: this.objId
        }, document.title, url);
    }

    renderedCallback(){
        if(!this.pay){
            const actionsWrapper = this.template.querySelector('.booking-form__send-button-wrapper');
            if(actionsWrapper){
                actionsWrapper.classList.add('booking-form__send-button-wrapper_single');
            }
        }
    }
    
    get sendButtonTitle(){
        return this.pay ? 'Оплатить' : 'Отправить';
    }

    get sendButtonTitleProcess(){
        return this.pay ? 'Перенаправление...' : 'Отправка...';
    }

    calendarChange(event){
        console.log('event', event.value);
    }

	clearError() {
		this.formMessageError = null;
		this.formMessageSuccess = null;
	}

	async showFromPiker() {
		await this.skip();
		this.pikStart.show();
	}

	async showToPiker() {
		await this.skip();
		this.pikEnd.show();
	}

	async sendOrder() {
		const spam = this.spam.value;

		if (spam) {
			return;
		}

		let bookingOrder;

		if (this.order) {
			const order = this.order.value;
			if (!order) {
				this.showError(ERROR_HOUSE_EMPTY);
				return;
			}
			bookingOrder = order;
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

		const today = getTodayDate();

		if (dateStart < today) {
			this.showError(ERROR_DATE_START_LATE);
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

		const count = this.count.options[this.count.selectedIndex].value;
		const passport = this.passport.value;
		const comment = this.comment.value;
		const contract = this.contract.checked;

		if (!contract) {
			this.showError(ERROR_CONTRACT_UNCHECKED);
			return;
		}

		this.formMessageError = null;
		this.isLoading = true;

		let orderTitle = this.objectTitle ? this.objectTitle : bookingOrder;
        let orderType = this.objectType ? this.objectType : "Домик/Мероприятие";
        

        if(this.pay){
            fetch("/wp-json/krasnagorka/v1/pay/",{
                method: "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify({
                    eventTabId: this.eventTabId,
                    id: this.objId,
                    fio: fio,
                    phone: phone,
                    email: email,
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                    count: count,
                    passport: passport,
                    comment: comment,
                    orderTitle: orderTitle,
                    message: spam
                })
            })
            .then(response => {
                return response.json();
            })
            .then(result => {
                console.log('result', result);
                if(result.status === 2){
                    /**
                     * https://payment.webpay.by
                     * https://securesandbox.webpay.by
                     */
                    generateAndSubmitForm(
                        email === 'zankoav@gmail.com' ? 
                        'https://securesandbox.webpay.by' : 
                        'https://payment.webpay.by',  
                        result.values,
                        result.names
                    );
                }else if(result.status === 1){
                    this.formMessageSuccess = null;
                    this.formMessageError = `Извините! Данное предложение уже забронировано.`;
                    this.isLoading = false;
                }else{
                    this.isLoading = false;
                    this.formMessageSuccess = null;
                    this.formMessageError = `Произошла системная ошибка, попробуйте позже`;
                }
            })
            .catch(e => {
                this.isLoading = false;
                this.showError(
                    "Соединение с сервером прервано, попробуйте позже"
                );
                console.log('Error:', e);
            });

            
        }else{

            fetch("/wp-json/krasnagorka/v1/order/", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify({
                    id: this.objId,
                    fio: fio,
                    phone: phone,
                    email: email,
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                    count: count,
                    contract: contract,
                    comment: comment,
                    orderTitle: orderTitle,
                    orderType: orderType,
                    cid: this.cid,
                    eventTabId: this.eventTabId,
                    passport: passport,
                    data: `fio=${fio}&phone=${phone}&email=${email}&dateStart=${dateStart}&dateEnd=${dateEnd}&count=${count}&contract=${contract}&comment=${comment}&bookingTitle=${orderTitle}&bookingType=${orderType}&cid=${this.cid}&passportId=${passport}&id=${this.objId}&eventTabId=${this.eventTabId}`,
                    message: spam,
                }),
            })
                .then((response) => {
                    return response.json();
                })
                .then((result) => {
                    this.isLoading = false;
                    if (result) {
                        this.formMessageSuccess =
                            "Поздравляем! Бронирование выполнено успешно. Наш сотрудник скоро свяжется с вами для уточнения деталей";
                        this.dateStart.value = null;
                        this.dateEnd.value = null;
                        this.passport.value = null;
                        this.comment.value = null;
                        if (this.order) {
                            this.order.value = null;
                        }
                        setCookie("kg_name", fio, { "max-age": MAX_AGE });
                        setCookie("kg_phone", phone, { "max-age": MAX_AGE });
                        setCookie("kg_email", email, { "max-age": MAX_AGE });

                        ga("send", {
                            hitType: "event",
                            eventCategory: "form_bronirovanie",
                            eventAction: "success_send",
                        });

                        fetch("/wp-json/krasnagorka/v1/create-amocrm-lead/", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json; charset=utf-8",
                            },
                            body: JSON.stringify({
                                data: result,
                            }),
                        })
                            .then((response) => {
                                return response.json();
                            })
                            .then((response) => {
                                console.log("amo response", response);
                            })
                            .catch((error) => {
                                console.log("amo response error", error);
                            });
                    } else {
                        this.formMessageSuccess = null;
                        this.formMessageError = `Извините! Выбранные даты заняты. Выберите свободный интервал.`;
                    }
                })
                .catch(() => {
                    this.isLoading = false;
                    this.showError(
                        "Соединение с сервером прервано, попробуйте позже"
                    );
                });
        }
	}

	showError(message) {
		this.formMessageSuccess = null;
		this.formMessageError = `Ошибка! ${message}`;
	}

	emailValidator(email) {
		let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
}

function getTodayDate() {
	let today = new Date();
	let dd = today.getDate();

	let mm = today.getMonth() + 1;
	const yyyy = today.getFullYear();
	if (dd < 10) {
		dd = `0${dd}`;
	}

	if (mm < 10) {
		mm = `0${mm}`;
	}
	return `${yyyy}-${mm}-${dd}`;
}

function generateAndSubmitForm(action, paramsWithValue, paramsWithNames, method = 'POST') {
    const form = document.createElement("form");
    form.action = action;
    form.method = method;

    paramsWithValue.wsb_cancel_return_url = `${location.href}&clear=${paramsWithValue.wsb_order_num}`;

    // eslint-disable-next-line guard-for-in
    for (const key in paramsWithValue) {
        const element = document.createElement("input");
        element.type = "hidden";
        element.name = key;
        element.value = paramsWithValue[key];
        form.appendChild(element);
    }

    for (const key of paramsWithNames) {
        const element = document.createElement("input");
        element.type = "hidden";
        element.name = key;
        form.appendChild(element);
    }

    document.body.appendChild(form);
    form.submit();
}
