import { LightningElement, api, track } from "lwc";
import { getCookie, setCookie } from 'z/utils';
import "./booking.scss";

const MAX_AGE = 3600 * 24 * 100;
import OK from './../../icons/checkon.svg';

const SUCCESS = {
    BASE: {
        title: 'Бронирование выполнено успешно!',
        description: 'Наш сотрудник скоро свяжется с вами для уточнения деталей',
        redirect: false
    },
    PAID:{
        title: 'Перенаправление на оплату...',
        description: 'После оплаты, Вам на почту придет письмо с заказом и инструкцией',
        redirect: true
    },
    LAITER:{
        title: 'Бронирование выполнено успешно!',
        description: 'На Вашу почту отправлено письмо с инструкцией по оплате.',
        redirect: false
    },
    OFFICE:{
        title: 'Бронирование выполнено успешно!',
        description: 'На Вашу почту отправлено письмо с координатами нашего офиса',
        redirect: false
    }
};

export default class BookingForm extends LightningElement {

    @api settings;
    @track loading;
    @track okImage = OK;

    get isHouseStep() {
        return this.settings.menu[0].active;
    }

    get isContactStep() {
        return this.settings.menu[1].active;
    }

    get isCheckoutStep() {
        return this.settings.menu[2].active;
    }

    get orderedSuccessData(){
        let result = SUCCESS.BASE;
        if(this.settings.payment){
            if(this.settings.paymentMethod === 'card'){
                result = SUCCESS.PAID;
            }else if(this.settings.paymentMethod === 'card_layter'){
                result = SUCCESS.LAITER;
            }else if(this.settings.paymentMethod === 'office'){
                result = SUCCESS.OFFICE;
            }
        }
        return result;
    }

    async bookingOrder() {

        this.loading = true;

        const calendar = this.settings.calendars.find(c => c.selected);
        const houseId = this.settings.house.id;
        const isTerem = this.settings.house.isTerem || '';
        const peopleCount = this.settings.counts.find(c => c.selected).name;

        const childCountsSeectedItem = this.settings.childCounts.find(c => c.selected);
        const childCounts = childCountsSeectedItem ? childCountsSeectedItem.name : 0;
        const cid = getCookie("_ga") ? getCookie("_ga").replace(/GA1.2./g, "") : null;
        const dateStart = new moment(this.settings.dateStart, "DD-MM-YYYY").format("YYYY-MM-DD");
        const dateEnd = new moment(this.settings.dateEnd, "DD-MM-YYYY").format("YYYY-MM-DD");
        const requestData = {
            id: calendar.id,
            fio: this.settings.fio,
            phone: this.settings.phone,
            email: this.settings.email,
            isTerem: isTerem,
            dateStart: dateStart,
            dateEnd: dateEnd,
            count: peopleCount,
            houseId: houseId,
            childs: childCounts,
            contract: false,
            comment: this.settings.comment,
            orderTitle: calendar.name,
            orderType: 'Домик:',
            cid: cid,
            passport: this.settings.passport,
            data: `fio=${this.settings.fio}&phone=${this.settings.phone}&email=${this.settings.email}&dateStart=${dateStart}&dateEnd=${dateEnd}&count=${peopleCount}&childs=${childCounts}&contract=${true}&comment=${this.settings.comment || ''}&bookingTitle=${calendar.name}&bookingType=${'Домик:'}&cid=${cid}&passportId=${this.settings.passport || ''}&id=${calendar.id}&isTerem=${isTerem}&spetial=no`
        }

        const response = await fetch("/wp-json/krasnagorka/v1/order/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(requestData)
        }).then(data => data.json());

        if (response && response.data) {
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        orderedSuccess: true
                    },
                    bubbles: true,
                    composed: true
                })
            );
            setCookie("kg_name", this.settings.fio, { "max-age": MAX_AGE });
            setCookie("kg_phone", this.settings.phone, { "max-age": MAX_AGE });
            setCookie("kg_email", this.settings.email, { "max-age": MAX_AGE });
           
            await fetch("/wp-json/krasnagorka/v1/create-amocrm-lead/", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify({ data: response.data })
            });
            gtag('event', 'create_lead');
        } else {
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        bookingErrorMessage: 'Извините! Выбранные даты заняты. Выберите свободный интервал.'
                    },
                    bubbles: true,
                    composed: true
                })
            );
        }
        this.loading = false;
    }

    async sendOrder(){
        this.loading = true;
        const calendar = this.settings.calendars.find(c => c.selected);
        const houseId = this.settings.house.id;
        const isTerem = this.settings.house.isTerem || '';
        const peopleCount = this.settings.counts.find(c => c.selected).name;

        const childCountsSeectedItem = this.settings.childCounts.find(c => c.selected);
        const childCounts = childCountsSeectedItem ? childCountsSeectedItem.name : 0;
        const cid = getCookie("_ga") ? getCookie("_ga").replace(/GA1.2./g, "") : null;
        const dateStart = new moment(this.settings.dateStart, "DD-MM-YYYY").format("YYYY-MM-DD");
        const dateEnd = new moment(this.settings.dateEnd, "DD-MM-YYYY").format("YYYY-MM-DD");
        
        const requestData = {
            id: calendar.id,
            fio: this.settings.fio,
            phone: this.settings.phone,
            email: this.settings.email,
            paymentMethod: this.settings.paymentMethod,
            prepaidType: this.settings.prepaidType,
            isTerem: isTerem,
            dateStart: dateStart,
            dateEnd: dateEnd,
            count: peopleCount,
            houseId: houseId,
            childs: childCounts,
            contract: false,
            comment: this.settings.comment,
            orderTitle: calendar.name,
            orderType: 'Домик:',
            cid: cid,
            passport: this.settings.passport,
            wsb_test: this.settings.webpaySandbox.wsb_test,
            data: `prepaidType=${this.settings.prepaidType}&paymentMethod=${this.settings.paymentMethod}&fio=${this.settings.fio}&phone=${this.settings.phone}&email=${this.settings.email}&dateStart=${dateStart}&dateEnd=${dateEnd}&count=${peopleCount}&childs=${childCounts}&contract=${true}&comment=${this.settings.comment || ''}&bookingTitle=${calendar.name}&bookingType=${'Домик:'}&cid=${cid}&passportId=${this.settings.passport || ''}&id=${calendar.id}&isTerem=${isTerem}&spetial=no`
        };
        
        const responseOrder = await fetch("/wp-json/krasnagorka/v1/order/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(requestData)
        }).then(data => data.json());

        if(responseOrder.status && responseOrder.data){
            setCookie("kg_name", this.settings.fio, { "max-age": MAX_AGE });
            setCookie("kg_phone", this.settings.phone, { "max-age": MAX_AGE });
            setCookie("kg_email", this.settings.email, { "max-age": MAX_AGE });

            const leadResponse = await fetch("/wp-json/krasnagorka/v1/create-amocrm-lead/", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify({ 
                    data: responseOrder.data ,
                    orderId: responseOrder.orderId,
                    email:  this.settings.email,
                    paymentMethod: this.settings.paymentMethod,
                    prepaidType: this.settings.prepaidType,

                })
            }).then(data => data.json());

            if(leadResponse){
                gtag('event', 'create_lead');
                console.log(leadResponse.template);
                this.dispatchEvent(
                    new CustomEvent('update', {
                        detail: {
                            tmpl: leadResponse.template,
                            orderedSuccess: true
                        },
                        bubbles: true,
                        composed: true
                    })
                );

                responseOrder.redirect.values.wsb_storeid = this.settings.webpaySandbox.wsb_storeid;
                responseOrder.redirect.values.wsb_test= this.settings.webpaySandbox.wsb_test;

                if(responseOrder.redirect){
                    generateAndSubmitForm(
                        this.settings.webpaySandbox.url,
                        responseOrder.redirect.values,
                        responseOrder.redirect.names
                    );
                }
            }            
        }else {
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        bookingErrorMessage: 'Извините! Выбранные даты заняты. Выберите свободный интервал.'
                    },
                    bubbles: true,
                    composed: true
                })
            );
        }
        this.loading = false;
    }

    renderedCallback(){
        const template = this.template.querySelector('.booking__template');
        if(template){
            template.innerHTML = this.finishTemplate;
        }
    }

    get finishTemplate(){
        return this.settings.tmpl?.replace('600px', '100%')
            .replace('600', '100')
            .replace('w80', 'width=80');
    }

    get cssCardTemplate(){
        return this.settings.tmpl ? "booking__card booking__card_template" : "booking__card";
    }

    get cssCardTemplateContainer(){
        return this.settings.tmpl ? "container container_template" : "container";
    }
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