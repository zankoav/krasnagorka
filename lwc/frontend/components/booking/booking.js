import { LightningElement, api, track } from "lwc";
import { getCookie, setCookie } from 'z/utils';
import "./booking.scss";

const MAX_AGE = 3600 * 24 * 100;
import OK from './../../icons/checkon.svg';

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

    async bookingOrder() {

        this.loading = true;

        const calendar = this.settings.calendars.find(c => c.selected);
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
            dateStart: dateStart,
            dateEnd: dateEnd,
            count: peopleCount,
            childs: childCounts,
            contract: false,
            comment: this.settings.comment,
            orderTitle: calendar.name,
            orderType: 'Домик:',
            cid: cid,
            passport: this.settings.passport,
            data: `fio=${this.settings.fio}&phone=${this.settings.phone}&email=${this.settings.email}&dateStart=${dateStart}&dateEnd=${dateEnd}&count=${peopleCount}&childs=${childCounts}&contract=${true}&comment=${this.settings.comment || ''}&bookingTitle=${calendar.name}&bookingType=${'Домик:'}&cid=${cid}&passportId=${this.settings.passport || ''}&id=${calendar.id}`
        }

        console.log(requestData);

        const response = await fetch("/wp-json/krasnagorka/v1/order/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(requestData)
        }).then(data => data.json());

        if (response) {
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
                body: JSON.stringify({ data: response })
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
}