import { LightningElement, api, track } from 'lwc';
import { getCookie } from 'z/utils';
import './admin.scss';

let calculatorHash;
export default class Admin extends LightningElement {

    @api model;
    @track settings;



    connectedCallback() {

        // this.settings = {
        //     "admin": true,
        //     "payment": true,
        //     "paymentMethod":null,
        //     "prepaidType": "FULL",
        //     "minPrice": 350, //need to admin
        //     "prepaidOptions" :[   //need to admin
        //         {
        //             "label": "100%",
        //             "value": "FULL"
        //         },
        //         {
        //             "label": "50%",
        //             "value": "678"
        //         }
        //     ],
            

            
        //     "seasons": [
        //         {
        //             "id": 9898,
        //             "name": "Выходные дни  (05.09 - 03.10)",
        //             "current": false,
        //             "houses": [
        //                 {
        //                     "id": 12979,
        //                     "price": "45,00",
        //                     "minPeople": "2,5",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 9486,
        //                     "price": "35,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8838,
        //                     "price": "40,00",
        //                     "minPeople": "4",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8836,
        //                     "price": "40,00",
        //                     "minPeople": "2",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8783,
        //                     "price": "45,00",
        //                     "minPeople": "6",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8780,
        //                     "price": "40,00",
        //                     "minPeople": "6",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8733,
        //                     "price": "40,00",
        //                     "minPeople": "4",
        //                     "minDays": "2",
        //                     "minPercent": "15",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8643,
        //                     "price": "40,00",
        //                     "minPeople": "5",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 }
        //             ]
        //         },
        //         {
        //             "id": 9897,
        //             "name": "Цены на отдых на предсезонный период (09.06-25.06/05.09-01.10)",
        //             "current": false,
        //             "houses": [
        //                 {
        //                     "id": 12979,
        //                     "price": "40,00",
        //                     "minPeople": "2,5",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 9486,
        //                     "price": "30,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8838,
        //                     "price": "30,00",
        //                     "minPeople": "4",
        //                     "minDays": "3",
        //                     "minPercent": "5",
        //                     "peoplesForSales": [
        //                         {
        //                             "people": "5",
        //                             "percent": "20"
        //                         },
        //                         {
        //                             "people": "6",
        //                             "percent": "30"
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     "id": 8836,
        //                     "price": "35,00",
        //                     "minPeople": "2",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8783,
        //                     "price": "40,00",
        //                     "minPeople": "6",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8780,
        //                     "price": "30,00",
        //                     "minPeople": "6",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8733,
        //                     "price": "30,00",
        //                     "minPeople": "4",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8643,
        //                     "price": "35,00",
        //                     "minPeople": "5",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 }
        //             ]
        //         },
        //         {
        //             "id": 9619,
        //             "name": "Цены на отдых на внесезонный период на Браславских озерах",
        //             "current": false,
        //             "houses": [
        //                 {
        //                     "id": 12979,
        //                     "price": "30,00",
        //                     "minPeople": "-",
        //                     "minDays": "-",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 9486,
        //                     "price": "25,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8838,
        //                     "price": "25,00",
        //                     "minPeople": "4",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8836,
        //                     "price": "30,00",
        //                     "minPeople": "2",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8783,
        //                     "price": "35,00",
        //                     "minPeople": "6",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8780,
        //                     "price": "25,00",
        //                     "minPeople": "5",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8733,
        //                     "price": "25,00",
        //                     "minPeople": "4",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8643,
        //                     "price": "30,00",
        //                     "minPeople": "5",
        //                     "minDays": "2",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 }
        //             ]
        //         },
        //         {
        //             "id": 9618,
        //             "name": "Летний сезон (25.06 - 05.09)",
        //             "current": true,
        //             "houses": [
        //                 {
        //                     "id": 12979,
        //                     "price": "50,00",
        //                     "minPeople": "2,5",
        //                     "minDays": "4",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 9486,
        //                     "price": "40,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8838,
        //                     "price": "40,00",
        //                     "minPeople": "5",
        //                     "minDays": "4",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8836,
        //                     "price": "45,00",
        //                     "minPeople": "2",
        //                     "minDays": "4",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8783,
        //                     "price": "45,00",
        //                     "minPeople": "6",
        //                     "minDays": "4",
        //                     "minPercent": "8",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8780,
        //                     "price": "40,00",
        //                     "minPeople": "6",
        //                     "minDays": "4",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8733,
        //                     "price": "40,00",
        //                     "minPeople": "5",
        //                     "minDays": "4",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8643,
        //                     "price": "40,00",
        //                     "minPeople": "6",
        //                     "minDays": "4",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 }
        //             ]
        //         },
        //         {
        //             "id": 9617,
        //             "name": "Новогодний сезон",
        //             "current": false,
        //             "houses": [
        //                 {
        //                     "id": 12979,
        //                     "price": "",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 9486,
        //                     "price": "35,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8838,
        //                     "price": "35,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8836,
        //                     "price": "",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8783,
        //                     "price": "40,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8780,
        //                     "price": "35,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8733,
        //                     "price": "35,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 },
        //                 {
        //                     "id": 8643,
        //                     "price": "35,00",
        //                     "minPeople": "",
        //                     "minDays": "",
        //                     "minPercent": "",
        //                     "peoplesForSales": []
        //                 }
        //             ]
        //         }
        //     ],
        //     "orderedSuccess": false,
        //     "bookingErrorMessage": null,
        //     "house": {
        //         "id": 8733,
        //         "peopleMaxCount": "7",
        //         "picture": "https://krasnagorka.by/wp-content/uploads/2015/04/DSC02354-e1466071039697-240x160.jpg",
        //         "daysSales": [
        //             {
        //                 "sale": "10",
        //                 "dayes": "7"
        //             }
        //         ],
        //         "link": "https://krasnagorka.by/dom-na-braslavskih-ozyorah/babochka/",
        //         "title": "Бабочка"
        //     },
        //     "fio": "dsvvdvds",
        //     "phone": "+44456789754567",
        //     "email": "sdbsdbsdb@gfbg.ri",
        //     "counts": [
        //         {
        //             "id": 1,
        //             "selected": false,
        //             "name": 1
        //         },
        //         {
        //             "id": 2,
        //             "selected": true,
        //             "name": 2
        //         },
        //         {
        //             "id": 3,
        //             "selected": false,
        //             "name": 3
        //         },
        //         {
        //             "id": 4,
        //             "selected": false,
        //             "name": 4
        //         },
        //         {
        //             "id": 5,
        //             "selected": false,
        //             "name": 5
        //         },
        //         {
        //             "id": 6,
        //             "selected": false,
        //             "name": 6
        //         },
        //         {
        //             "id": 7,
        //             "selected": false,
        //             "name": 7
        //         }
        //     ],
        //     "childCounts": [
        //         {
        //             "id": 0,
        //             "selected": false,
        //             "name": 0
        //         },
        //         {
        //             "id": 1,
        //             "selected": false,
        //             "name": 1
        //         },
        //         {
        //             "id": 2,
        //             "selected": false,
        //             "name": 2
        //         },
        //         {
        //             "id": 3,
        //             "selected": true,
        //             "name": 3
        //         },
        //         {
        //             "id": 4,
        //             "selected": false,
        //             "name": 4
        //         },
        //         {
        //             "id": 5,
        //             "selected": false,
        //             "name": 5
        //         },
        //         {
        //             "id": 6,
        //             "selected": false,
        //             "name": 6
        //         },
        //         {
        //             "id": 7,
        //             "selected": false,
        //             "name": 7
        //         }
        //     ],
        //     "dateStart": "05-10-2021",
        //     "dateEnd": "08-10-2021",
        //     "comment": "sdvbfdgt",
        //     "passport": "DSVBFTR",
        //     "agreement": true,
        //     "linkAgreement": "https://krasnagorka.by/dogovor-prisoedineniya/",
        //     "calendars": [
        //         {
        //             "id": 14,
        //             "name": "Бабочка",
        //             "slug": "babochka",
        //             "isTerem": "",
        //             "selected": true
        //         },
        //         {
        //             "id": 16,
        //             "name": "Божья Коровка",
        //             "slug": "bozhya-korovka",
        //             "isTerem": "",
        //             "selected": false
        //         },
        //         {
        //             "id": 37,
        //             "name": "Бунгало",
        //             "slug": "kepningovyj-domik",
        //             "isTerem": "",
        //             "selected": false
        //         },
        //         {
        //             "id": 9,
        //             "name": "Датский",
        //             "slug": "datskij",
        //             "isTerem": "",
        //             "selected": false
        //         },
        //         {
        //             "id": 43,
        //             "name": "Пилигрим",
        //             "slug": "piligrim",
        //             "isTerem": "",
        //             "selected": false
        //         },
        //         {
        //             "id": 13,
        //             "name": "Рыбацкий",
        //             "slug": "rybatskij",
        //             "isTerem": "",
        //             "selected": false
        //         },
        //         {
        //             "id": 18,
        //             "name": "Терем 1",
        //             "slug": "terem-1",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 27,
        //             "name": "Терем 10",
        //             "slug": "terem-10",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 28,
        //             "name": "Терем 11",
        //             "slug": "terem-11",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 29,
        //             "name": "Терем 12",
        //             "slug": "terem-12",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 19,
        //             "name": "Терем 2",
        //             "slug": "terem-2",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 20,
        //             "name": "Терем 3",
        //             "slug": "terem-3",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 21,
        //             "name": "Терем 4",
        //             "slug": "terem-4",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 22,
        //             "name": "Терем 5",
        //             "slug": "terem-5",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 23,
        //             "name": "Терем 6",
        //             "slug": "terem-6",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 24,
        //             "name": "Терем 7",
        //             "slug": "terem-7",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 25,
        //             "name": "Терем 8",
        //             "slug": "terem-8",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 26,
        //             "name": "Терем 9",
        //             "slug": "terem-9",
        //             "isTerem": "on",
        //             "selected": false
        //         },
        //         {
        //             "id": 15,
        //             "name": "У причала",
        //             "slug": "u-prichala",
        //             "isTerem": "",
        //             "selected": false
        //         }
        //     ],
        //     "menu": [
        //         {
        //             "label": "Выбор Домика",
        //             "value": "house",
        //             "available": true,
        //             "active": false
        //         },
        //         {
        //             "label": "Контакты",
        //             "value": "contacts",
        //             "available": true,
        //             "active": false
        //         },
        //         {
        //             "label": "Заказ",
        //             "value": "checkout",
        //             "available": true,
        //             "active": true
        //         }
        //     ],
        //     "total": {
        //         "total_price": 360,
        //         "days_count": 3,
        //         "day_sale_next": {
        //             "sale": "10",
        //             "dayesNumber": 7
        //         },
        //         "seasons_group": {
        //             "9619": {
        //                 "season_id": "9619",
        //                 "days": [
        //                     "2021-10-06",
        //                     "2021-10-07",
        //                     "2021-10-08"
        //                 ],
        //                 "house_price": 30,
        //                 "house_min_people": 4,
        //                 "house_min_days": 2,
        //                 "house_min_percent": 0,
        //                 "price_block": {
        //                     "title": "Цены на отдых на внесезонный период на Браславских озерах",
        //                     "season_id": 9619,
        //                     "base_price": 120,
        //                     "days_count": 3,
        //                     "base_people_count": null,
        //                     "days_sale": 0,
        //                     "people_sale": null,
        //                     "people_sale_next": {
        //                         "sale": "5",
        //                         "people": 5
        //                     },
        //                     "total": 360
        //                 }
        //             }
        //         }
        //     },
        //     "totalPriceLoading": false
        // };

        this.settings = {
            admin: this.model.admin,
            payment: this.model.payment,
            prepaidType: this.model.prepaidType,
            paymentMethod: this.model.paymentMethod,
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
