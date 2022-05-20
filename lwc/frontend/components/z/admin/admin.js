import { LightningElement, api, track } from 'lwc'
import { getCookie } from 'z/utils'
import './admin.scss'

export default class Admin extends LightningElement {
    @api model
    @track settings

    connectedCallback() {
        // this.settings = {
        //     id: '13',
        //     admin: true,
        //     webpaySandbox: {
        //         url: 'https://payment.webpay.by',
        //         wsb_storeid: '320460709',
        //         wsb_test: '0'
        //     },
        //     payment: true,
        //     paymentMethod: 'card',
        //     prepaidType: 100,
        //     textFullCard:
        //         '*\u041e\u043f\u043b\u0430\u0442\u0430 \u0441 \u043f\u043e\u043c\u043e\u0449\u044c\u044e \u043a\u0430\u0440\u0442 Visa/MasterCard \u043e\u043d\u043b\u0430\u0439\u043d \u0441\u0435\u0439\u0447\u0430\u0441\r\n(\u0412\u044b \u0431\u0443\u0434\u0435\u0442\u0435 \u043f\u0435\u0440\u0435\u043d\u0430\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u044b \u043d\u0430 \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0443 \u043f\u043b\u0430\u0442\u0451\u0436\u043d\u043e\u0439 \u0441\u0438\u0441\u0442\u0435\u043c\u044b Webpay)',
        //     textPartCard:
        //         '*\u041f\u0440\u0435\u0434\u043e\u043f\u043b\u0430\u0442\u0430 50% \u0441 \u043f\u043e\u043c\u043e\u0449\u044c\u044e \u043a\u0430\u0440\u0442 Visa/MasterCard \u043e\u043d\u043b\u0430\u0439\u043d \u0441\u0435\u0439\u0447\u0430\u0441\r\n(\u0412\u044b \u0431\u0443\u0434\u0435\u0442\u0435 \u043f\u0435\u0440\u0435\u043d\u0430\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u044b \u043d\u0430 \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0443 \u043f\u043b\u0430\u0442\u0451\u0436\u043d\u043e\u0439 \u0441\u0438\u0441\u0442\u0435\u043c\u044b Webpay)',
        //     textFullLaterCard:
        //         '*\u041e\u043f\u043b\u0430\u0442\u0430 \u0441 \u043f\u043e\u043c\u043e\u0449\u044c\u044e \u043a\u0430\u0440\u0442 Visa/MasterCard \u043e\u043d\u043b\u0430\u0439\u043d \u043f\u043e\u0437\u0436\u0435\r\n(\u041d\u0430 \u0443\u043a\u0430\u0437\u0430\u043d\u043d\u044b\u0439 \u0432\u0430\u043c\u0438 e-mail \u043f\u0440\u0438\u0434\u0451\u0442 \u0441\u0441\u044b\u043b\u043a\u0430 \u0434\u043b\u044f \u043e\u043f\u043b\u0430\u0442\u044b, \u043a\u043e\u0442\u043e\u0440\u0430\u044f \u0431\u0443\u0434\u0435\u0442 \u0434\u0435\u0439\u0441\u0442\u0432\u0438\u0442\u0435\u043b\u044c\u043d\u0430 \u0432 \u0442\u0435\u0447\u0435\u043d\u0438\u0435 2-\u0443\u0445 \u043a\u0430\u043b\u0435\u043d\u0434\u0430\u0440\u043d\u044b\u0445 \u0434\u043d\u0435\u0439)',
        //     textPartLaterCard:
        //         '*\u041f\u0440\u0435\u0434\u043e\u043f\u043b\u0430\u0442\u0430 50% \u0441 \u043f\u043e\u043c\u043e\u0449\u044c\u044e \u043a\u0430\u0440\u0442 Visa/MasterCard \u043e\u043d\u043b\u0430\u0439\u043d \u043f\u043e\u0437\u0436\u0435\r\n(\u041d\u0430 \u0443\u043a\u0430\u0437\u0430\u043d\u043d\u044b\u0439 \u0432\u0430\u043c\u0438 e-mail \u043f\u0440\u0438\u0434\u0451\u0442 \u0441\u0441\u044b\u043b\u043a\u0430 \u0434\u043b\u044f \u043e\u043f\u043b\u0430\u0442\u044b, \u043a\u043e\u0442\u043e\u0440\u0430\u044f \u0431\u0443\u0434\u0435\u0442 \u0434\u0435\u0439\u0441\u0442\u0432\u0438\u0442\u0435\u043b\u044c\u043d\u0430 \u0432 \u0442\u0435\u0447\u0435\u043d\u0438\u0435 2-\u0443\u0445 \u043a\u0430\u043b\u0435\u043d\u0434\u0430\u0440\u043d\u044b\u0445 \u0434\u043d\u0435\u0439)',
        //     textFullOffice:
        //         '*\u041e\u043f\u043b\u0430\u0442\u0430 \u043d\u0430\u043b\u0438\u0447\u043d\u044b\u043c\u0438 \u0432 \u043d\u0430\u0448\u0435\u043c \u043e\u0444\u0438\u0441\u0435 \u0432 \u041c\u0438\u043d\u0441\u043a\u0435 \u043f\u043e\u0437\u0436\u0435 (\u0432 \u0442\u0435\u0447\u0435\u043d\u0438\u0435 2-\u0443\u0445 \u043a\u0430\u043b\u0435\u043d\u0434\u0430\u0440\u043d\u044b\u0445 \u0434\u043d\u0435\u0439, 1-\u044b\u0439 \u0422\u0432\u0451\u0440\u0434\u044b\u0439 \u043f\u0435\u0440., \u0434. 15, \u0432\u0440\u0435\u043c\u044f \u0441\u043e\u0433\u043b\u0430\u0441\u043e\u0432\u044b\u0432\u0430\u0435\u0442\u0441\u044f \u043f\u043e \u0437\u0432\u043e\u043d\u043a\u0443)',
        //     textPartOffice:
        //         '*\u041f\u0440\u0435\u0434\u043e\u043f\u043b\u0430\u0442\u0430 50% \u043d\u0430\u043b\u0438\u0447\u043d\u044b\u043c\u0438 \u0432 \u043d\u0430\u0448\u0435\u043c \u043e\u0444\u0438\u0441\u0435 \u0432 \u041c\u0438\u043d\u0441\u043a\u0435 \u043f\u043e\u0437\u0436\u0435 (\u0432 \u0442\u0435\u0447\u0435\u043d\u0438\u0435 2-\u0443\u0445 \u043a\u0430\u043b\u0435\u043d\u0434\u0430\u0440\u043d\u044b\u0445 \u0434\u043d\u0435\u0439, 1-\u044b\u0439 \u0422\u0432\u0451\u0440\u0434\u044b\u0439 \u043f\u0435\u0440., \u0434. 15, \u0432\u0440\u0435\u043c\u044f \u0441\u043e\u0433\u043b\u0430\u0441\u043e\u0432\u044b\u0432\u0430\u0435\u0442\u0441\u044f \u043f\u043e \u0437\u0432\u043e\u043d\u043a\u0443)',
        //     minPrice: 500,
        //     prepaidOptions: [
        //         {
        //             label: '100%',
        //             value: 100
        //         },
        //         {
        //             label: '50%',
        //             value: 50
        //         }
        //     ],
        //     maxCount: 10,
        //     houses: [
        //         {
        //             id: 12979,
        //             name: '\u041f\u0438\u043b\u0438\u0433\u0440\u0438\u043c'
        //         },
        //         {
        //             id: 9486,
        //             name: '\u0422\u0435\u0440\u0435\u043c'
        //         },
        //         {
        //             id: 8838,
        //             name: '\u0411\u043e\u0436\u044c\u044f  \u043a\u043e\u0440\u043e\u0432\u043a\u0430'
        //         },
        //         {
        //             id: 8836,
        //             name: '\u0411\u0443\u043d\u0433\u0430\u043b\u043e'
        //         },
        //         {
        //             id: 8783,
        //             name: '\u0414\u0430\u0442\u0441\u043a\u0438\u0439'
        //         },
        //         {
        //             id: 8780,
        //             name: '\u0420\u044b\u0431\u0430\u0446\u043a\u0438\u0439'
        //         },
        //         {
        //             id: 8733,
        //             name: '\u0411\u0430\u0431\u043e\u0447\u043a\u0430'
        //         },
        //         {
        //             id: 8643,
        //             name: '\u0414\u043e\u043c\u0438\u043a \u0443 \u043f\u0440\u0438\u0447\u0430\u043b\u0430'
        //         }
        //     ],
        //     calendars: [
        //         {
        //             id: 14,
        //             name: '\u0411\u0430\u0431\u043e\u0447\u043a\u0430',
        //             slug: 'babochka',
        //             isTerem: '',
        //             selected: false
        //         },
        //         {
        //             id: 16,
        //             name: '\u0411\u043e\u0436\u044c\u044f \u041a\u043e\u0440\u043e\u0432\u043a\u0430',
        //             slug: 'bozhya-korovka',
        //             isTerem: '',
        //             selected: false
        //         },
        //         {
        //             id: 37,
        //             name: '\u0411\u0443\u043d\u0433\u0430\u043b\u043e',
        //             slug: 'kepningovyj-domik',
        //             isTerem: '',
        //             selected: false
        //         },
        //         {
        //             id: 9,
        //             name: '\u0414\u0430\u0442\u0441\u043a\u0438\u0439',
        //             slug: 'datskij',
        //             isTerem: '',
        //             selected: false
        //         },
        //         {
        //             id: 43,
        //             name: '\u041f\u0438\u043b\u0438\u0433\u0440\u0438\u043c',
        //             slug: 'piligrim',
        //             isTerem: '',
        //             selected: false
        //         },
        //         {
        //             id: 13,
        //             name: '\u0420\u044b\u0431\u0430\u0446\u043a\u0438\u0439',
        //             slug: 'rybatskij',
        //             isTerem: '',
        //             isDeprecatedBabyBed: false,
        //             isDeprecatedAnimals: false,
        //             maxChild: 1,
        //             selected: true
        //         },
        //         {
        //             id: 18,
        //             name: '\u0422\u0435\u0440\u0435\u043c 1',
        //             slug: 'terem-1',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 27,
        //             name: '\u0422\u0435\u0440\u0435\u043c 10',
        //             slug: 'terem-10',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 28,
        //             name: '\u0422\u0435\u0440\u0435\u043c 11',
        //             slug: 'terem-11',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 29,
        //             name: '\u0422\u0435\u0440\u0435\u043c 12',
        //             slug: 'terem-12',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 19,
        //             name: '\u0422\u0435\u0440\u0435\u043c 2',
        //             slug: 'terem-2',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 20,
        //             name: '\u0422\u0435\u0440\u0435\u043c 3',
        //             slug: 'terem-3',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 21,
        //             name: '\u0422\u0435\u0440\u0435\u043c 4',
        //             slug: 'terem-4',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 22,
        //             name: '\u0422\u0435\u0440\u0435\u043c 5',
        //             slug: 'terem-5',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 23,
        //             name: '\u0422\u0435\u0440\u0435\u043c 6',
        //             slug: 'terem-6',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 24,
        //             name: '\u0422\u0435\u0440\u0435\u043c 7',
        //             slug: 'terem-7',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 25,
        //             name: '\u0422\u0435\u0440\u0435\u043c 8',
        //             slug: 'terem-8',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 26,
        //             name: '\u0422\u0435\u0440\u0435\u043c 9',
        //             slug: 'terem-9',
        //             isTerem: 'on',
        //             selected: false
        //         },
        //         {
        //             id: 15,
        //             name: '\u0423 \u043f\u0440\u0438\u0447\u0430\u043b\u0430',
        //             slug: 'u-prichala',
        //             isTerem: '',
        //             selected: false
        //         }
        //     ],
        //     mainMenu: [
        //         {
        //             key: 10588,
        //             label: '\u0413\u043b\u0430\u0432\u043d\u0430\u044f',
        //             href: 'https://krasnagorka.by/'
        //         },
        //         {
        //             key: 10567,
        //             label: '\u041d\u0430\u0448\u0438 \u0434\u043e\u043c\u0430',
        //             href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/',
        //             subItems: [
        //                 {
        //                     key: 10561,
        //                     label: '\u0411\u0443\u043d\u0433\u0430\u043b\u043e',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/bungalo/',
        //                     parent: '10567'
        //                 },
        //                 {
        //                     key: 10562,
        //                     label: '\u0414\u043e\u043c\u0438\u043a \u0443 \u043f\u0440\u0438\u0447\u0430\u043b\u0430',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/domik-u-prichala/',
        //                     parent: '10567'
        //                 },
        //                 {
        //                     key: 10563,
        //                     label: '\u0420\u044b\u0431\u0430\u0446\u043a\u0438\u0439',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/rybatskij/',
        //                     parent: '10567'
        //                 },
        //                 {
        //                     key: 10559,
        //                     label: '\u0414\u0430\u0442\u0441\u043a\u0438\u0439',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/datskij/',
        //                     parent: '10567'
        //                 },
        //                 {
        //                     key: 10560,
        //                     label: '\u0422\u0435\u0440\u0435\u043c',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/terem/',
        //                     parent: '10567'
        //                 },
        //                 {
        //                     key: 10564,
        //                     label: '\u0411\u0430\u0431\u043e\u0447\u043a\u0430',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/babochka/',
        //                     parent: '10567'
        //                 },
        //                 {
        //                     key: 10565,
        //                     label: '\u0411\u043e\u0436\u044c\u044f  \u043a\u043e\u0440\u043e\u0432\u043a\u0430',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/bozhya-korovka/',
        //                     parent: '10567'
        //                 },
        //                 {
        //                     key: 13093,
        //                     label: '\u041f\u0438\u043b\u0438\u0433\u0440\u0438\u043c',
        //                     href: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/piligrim/',
        //                     parent: '10567'
        //                 }
        //             ]
        //         },
        //         {
        //             key: 10591,
        //             label: '\u0423\u0441\u043b\u0443\u0433\u0438 \u0438 \u0440\u0430\u0437\u0432\u043b\u0435\u0447\u0435\u043d\u0438\u044f',
        //             href: 'https://krasnagorka.by/otdyh-na-braslavah/'
        //         },
        //         {
        //             key: 10592,
        //             label: '\u0410\u043a\u0446\u0438\u0438',
        //             href: 'https://krasnagorka.by/stocks/'
        //         },
        //         {
        //             key: 10593,
        //             label: '\u0426\u0435\u043d\u044b',
        //             href: 'https://krasnagorka.by/tseny/'
        //         },
        //         {
        //             key: 10594,
        //             label: '\u041c\u0435\u0441\u0442\u043e\u0440\u0430\u0441\u043f\u043e\u043b\u043e\u0436\u0435\u043d\u0438\u0435',
        //             href: 'https://krasnagorka.by/shema-proezda/'
        //         },
        //         {
        //             key: 10590,
        //             label: '\u041a\u0430\u043b\u0435\u043d\u0434\u0430\u0440\u044c \u0431\u0440\u043e\u043d\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u044f',
        //             href: 'https://krasnagorka.by/kalendar-bronirovaniya/'
        //         },
        //         {
        //             key: 17825,
        //             label: '\u041e\u0442\u0437\u044b\u0432\u044b',
        //             href: 'https://krasnagorka.by/otzyvy/'
        //         }
        //     ],
        //     seasons: [
        //         {
        //             id: 19415,
        //             name: '\u0412\u0441\u0442\u0440\u0435\u0447\u0430\u0435\u043c \u041d\u043e\u0432\u044b\u0439 \u0433\u043e\u0434 (30.12 - 02.01, \u0441\u043f\u0435\u0446\u0438\u0430\u043b\u044c\u043d\u043e\u0435 \u043f\u0440\u0435\u0434\u043b\u043e\u0436\u0435\u043d\u0438\u0435, \u0431\u0440\u043e\u043d\u0438\u0440\u0443\u0435\u0442\u0441\u044f \u043c\u0438\u043d\u0438\u043c\u0443\u043c \u043d\u0430 3 \u043d\u043e\u0447\u0438)',
        //             current: false,
        //             houses: [
        //                 {
        //                     id: 18,
        //                     price: '133,00',
        //                     minPeople: '4',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 19,
        //                     price: '133,00',
        //                     minPeople: '4',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 20,
        //                     price: '133,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 21,
        //                     price: '133,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 22,
        //                     price: '133,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 23,
        //                     price: '133,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 24,
        //                     price: '133,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 25,
        //                     price: '133,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 26,
        //                     price: '133,00',
        //                     minPeople: '2',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 27,
        //                     price: '133,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 28,
        //                     price: '133,00',
        //                     minPeople: '2',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 29,
        //                     price: '133,00',
        //                     minPeople: '2',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 12979,
        //                     price: '166,30',
        //                     minPeople: '',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 9486,
        //                     price: '133,00',
        //                     minPeople: '',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8838,
        //                     price: '149,60',
        //                     minPeople: '5',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8836,
        //                     price: '149,60',
        //                     minPeople: '2',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8783,
        //                     price: '166,30',
        //                     minPeople: '8',
        //                     minDays: '3',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8780,
        //                     price: '149,60',
        //                     minPeople: '8',
        //                     minDays: '3',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8733,
        //                     price: '149,60',
        //                     minPeople: '5',
        //                     minDays: '3',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8643,
        //                     price: '149,60',
        //                     minPeople: '8',
        //                     minDays: '3',
        //                     minPercent: '30',
        //                     peoplesForSales: []
        //                 }
        //             ]
        //         },
        //         {
        //             id: 9898,
        //             name: '\u0412\u044b\u0445\u043e\u0434\u043d\u044b\u0435 \u0434\u043d\u0438  (29.04 - 24.06)',
        //             current: false,
        //             houses: [
        //                 {
        //                     id: 18,
        //                     price: '35,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 19,
        //                     price: '35,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 20,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 21,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 22,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 23,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 24,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 25,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '2',
        //                     minPercent: '50',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 26,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 27,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 28,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 29,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 12979,
        //                     price: '45,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 9486,
        //                     price: '35,00',
        //                     minPeople: '',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8838,
        //                     price: '40,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8836,
        //                     price: '40,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8783,
        //                     price: '45,00',
        //                     minPeople: '6',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8780,
        //                     price: '40,00',
        //                     minPeople: '6',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8733,
        //                     price: '40,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8643,
        //                     price: '40,00',
        //                     minPeople: '5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 }
        //             ]
        //         },
        //         {
        //             id: 9897,
        //             name: '\u0426\u0435\u043d\u044b \u043d\u0430 \u043e\u0442\u0434\u044b\u0445 \u043d\u0430 \u043f\u0440\u0435\u0434\u0441\u0435\u0437\u043e\u043d\u043d\u044b\u0439 \u043f\u0435\u0440\u0438\u043e\u0434 (10.06 - 24.06)',
        //             current: false,
        //             houses: [
        //                 {
        //                     id: 18,
        //                     price: '30,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 19,
        //                     price: '30,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 20,
        //                     price: '30,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 21,
        //                     price: '30,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 22,
        //                     price: '30,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 23,
        //                     price: '30,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 24,
        //                     price: '30,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 25,
        //                     price: '30,00',
        //                     minPeople: '2,5',
        //                     minDays: '2',
        //                     minPercent: '50',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 26,
        //                     price: '30,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 27,
        //                     price: '30,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 28,
        //                     price: '30,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 29,
        //                     price: '30,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 12979,
        //                     price: '40,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 9486,
        //                     price: '30,00',
        //                     minPeople: '',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8838,
        //                     price: '30,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8836,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8783,
        //                     price: '40,00',
        //                     minPeople: '6',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8780,
        //                     price: '30,00',
        //                     minPeople: '6',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8733,
        //                     price: '30,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8643,
        //                     price: '35,00',
        //                     minPeople: '5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 }
        //             ]
        //         },
        //         {
        //             id: 9619,
        //             name: '\u0426\u0435\u043d\u044b \u043d\u0430 \u043e\u0442\u0434\u044b\u0445 \u043d\u0430 \u0432\u043d\u0435\u0441\u0435\u0437\u043e\u043d\u043d\u044b\u0439 \u043f\u0435\u0440\u0438\u043e\u0434 \u043d\u0430 \u0411\u0440\u0430\u0441\u043b\u0430\u0432\u0441\u043a\u0438\u0445 \u043e\u0437\u0435\u0440\u0430\u0445',
        //             current: true,
        //             houses: [
        //                 {
        //                     id: 18,
        //                     price: '25,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 19,
        //                     price: '25,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 20,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 21,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 22,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 23,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 24,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 25,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 26,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 27,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 28,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 29,
        //                     price: '25,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 12979,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 9486,
        //                     price: '25,00',
        //                     minPeople: '',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8838,
        //                     price: '30,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8836,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8783,
        //                     price: '35,00',
        //                     minPeople: '6',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8780,
        //                     price: '30,00',
        //                     minPeople: '5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8733,
        //                     price: '30,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8643,
        //                     price: '35,00',
        //                     minPeople: '5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     smallAnimalPrice: 2,
        //                     bigAnimalPrice: 5,
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 }
        //             ]
        //         },
        //         {
        //             id: 9618,
        //             name: '\u041b\u0435\u0442\u043d\u0438\u0439 \u0441\u0435\u0437\u043e\u043d (24.06 - 04.09)',
        //             current: false,
        //             houses: [
        //                 {
        //                     id: 18,
        //                     price: '45,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 19,
        //                     price: '45,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '5',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 20,
        //                     price: '45,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 21,
        //                     price: '45,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 22,
        //                     price: '45,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 23,
        //                     price: '45,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 24,
        //                     price: '45,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 25,
        //                     price: '45,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 26,
        //                     price: '45,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 27,
        //                     price: '45,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 28,
        //                     price: '45,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 29,
        //                     price: '45,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 12979,
        //                     price: '55,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 9486,
        //                     price: '45,00',
        //                     minPeople: '',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8838,
        //                     price: '45,00',
        //                     minPeople: '5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '6',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8836,
        //                     price: '50,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8783,
        //                     price: '50,00',
        //                     minPeople: '8',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '9',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8780,
        //                     price: '45,00',
        //                     minPeople: '6',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8733,
        //                     price: '45,00',
        //                     minPeople: '5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '6',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 },
        //                 {
        //                     id: 8643,
        //                     price: '45,00',
        //                     minPeople: '6',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: [
        //                         {
        //                             people: '8',
        //                             percent: '5'
        //                         }
        //                     ]
        //                 }
        //             ]
        //         },
        //         {
        //             id: 9617,
        //             name: '\u041d\u043e\u0432\u043e\u0433\u043e\u0434\u043d\u0438\u0439 \u0441\u0435\u0437\u043e\u043d (24.12 - 30.12 / 02.01 - 09.01)',
        //             current: false,
        //             houses: [
        //                 {
        //                     id: 18,
        //                     price: '35,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 19,
        //                     price: '35,00',
        //                     minPeople: '4',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 20,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 21,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 22,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 23,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 24,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 25,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 26,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 27,
        //                     price: '35,00',
        //                     minPeople: '2,5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 28,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 29,
        //                     price: '35,00',
        //                     minPeople: '2',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 12979,
        //                     price: '40,00',
        //                     minPeople: '3',
        //                     minDays: '3',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 9486,
        //                     price: '35,00',
        //                     minPeople: '',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8838,
        //                     price: '35,00',
        //                     minPeople: '5',
        //                     minDays: '3',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8836,
        //                     price: '40,00',
        //                     minPeople: '2',
        //                     minDays: '3',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8783,
        //                     price: '40,00',
        //                     minPeople: '8',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8780,
        //                     price: '35,00',
        //                     minPeople: '8',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8733,
        //                     price: '35,00',
        //                     minPeople: '5',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 },
        //                 {
        //                     id: 8643,
        //                     price: '35,00',
        //                     minPeople: '8',
        //                     minDays: '',
        //                     minPercent: '',
        //                     peoplesForSales: []
        //                 }
        //             ]
        //         }
        //     ],
        //     weather: {
        //         day: '0',
        //         temperature: 3,
        //         icon: 'https://darksky.net/images/weather-icons/clear-day.png',
        //         description:
        //             '\u042f\u0441\u043d\u043e \u0432 \u0442\u0435\u0447\u0435\u043d\u0438\u0435 \u0432\u0441\u0435\u0433\u043e \u0434\u043d\u044f.',
        //         firstDay: {
        //             day: '\u043f\u043d',
        //             icon: 'https://darksky.net/images/weather-icons/clear-day.png'
        //         },
        //         secondDay: {
        //             day: '\u0432\u0442',
        //             icon: 'https://darksky.net/images/weather-icons/clear-day.png'
        //         },
        //         thirdDay: {
        //             day: '\u0441\u0440',
        //             icon: 'https://darksky.net/images/weather-icons/cloudy.png'
        //         }
        //     },
        //     currencies: {
        //         byn: 1,
        //         rur: '3.4495',
        //         usd: '2.5552',
        //         eur: '3.0223'
        //     },
        //     pageTitle: '\u0411\u0440\u043e\u043d\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0435',
        //     pageBannerSrc: 'https://krasnagorka.by/wp-content/uploads/2018/07/banner-1920x498.jpg',
        //     popupContacts: {
        //         a1: '+375 29 320 19 19',
        //         mts: '+375 29 701 19 19',
        //         life: null,
        //         email: 'info@krasnagorka.by',
        //         time: '9:00 - 20:00 \u043f\u043d-\u043f\u0442',
        //         weekend: '11:00 - 20:00 \u0441\u0431,\u0432\u0441'
        //     },
        //     mainContent: {
        //         title: '\u0420\u044b\u0431\u0430\u0446\u043a\u0438\u0439',
        //         type: '\u0414\u043e\u043c\u0438\u043a:',
        //         contractOffer: 'https://krasnagorka.by/dogovor-prisoedineniya/'
        //     },
        //     footerBottom: {
        //         logo: 'https://krasnagorka.by/wp-content/uploads/2019/05/footer-logo-160x160.png',
        //         unp: '<p>\u0418\u041f \u0422\u0435\u0440\u0435\u0449\u0435\u043d\u043a\u043e \u0418\u0432\u0430\u043d \u0418\u0433\u043e\u0440\u0435\u0432\u0438\u0447</p><p>\u0423\u041d\u041f 192706366</p><p>\u0420\u0435\u0441\u043f\u0443\u0431\u043b\u0438\u043a\u0430 \u0411\u0435\u043b\u0430\u0440\u0443\u0441\u044c, \u0411\u0440\u0430\u0441\u043b\u0430\u0432\u0441\u043a\u0438\u0439 </p><p>\u0440-\u043d., \u0434. \u041a\u0440\u0430\u0441\u043d\u043e\u0433\u043e\u0440\u043a\u0430</p>',
        //         socials: [
        //             {
        //                 value: 'insta',
        //                 url: 'https://www.instagram.com/krasnogorka.by/'
        //             },
        //             {
        //                 value: 'fb',
        //                 url: 'https://www.facebook.com/krasnagorka.by/'
        //             },
        //             {
        //                 value: 'ok',
        //                 url: 'https://m.ok.ru/profile/576548326340'
        //             },
        //             {
        //                 value: 'vk',
        //                 url: 'https://vk.com/krasnogorka_by'
        //             },
        //             {
        //                 value: 'youtube',
        //                 url: 'https://www.youtube.com/channel/UCT-5WXCDQ8_667Kq-rOWzIQ?pbjreload=10'
        //             },
        //             {
        //                 value: 'telegram',
        //                 url: 'https://t.me/Krasnogorkabot'
        //             }
        //         ]
        //     },
        //     fio: 'Zanko',
        //     phone: '+375295558386',
        //     email: 'zankoav@gmail.com',
        //     passport: 'TTSSAA',
        //     agreement: true,
        //     comment: null,
        //     linkAgreement: '#',
        //     menu: [
        //         {
        //             label: 'Выбор Домика',
        //             value: 'house',
        //             available: true,
        //             active: true
        //         },
        //         {
        //             label: 'Питание',
        //             value: 'food',
        //             available: false,
        //             active: false
        //         },
        //         {
        //             label: 'Доп. услуги',
        //             value: 'additional_services',
        //             available: false,
        //             active: false
        //         },
        //         {
        //             label: 'Контакты',
        //             value: 'contacts',
        //             available: false,
        //             active: false
        //         },
        //         {
        //             label: 'Заказ',
        //             value: 'checkout',
        //             available: false,
        //             active: false
        //         }
        //     ],
        //     dateStart: '2022-06-06'
        //         ? new moment('2022-06-06', 'YYYY-MM-DD').format('DD-MM-YYYY')
        //         : null,
        //     dateEnd: '2022-06-08'
        //         ? new moment('2022-06-08', 'YYYY-MM-DD').format('DD-MM-YYYY')
        //         : null,
        //     dateFrom: '2022-06-06',
        //     dateTo: '2022-06-08',
        //     babyBed: false,
        //     babyBedPrice: 5,
        //     bathHouseWhitePrice: 50,
        //     bathHouseBlackPrice: 50,
        //     foodBreakfastPrice: 15,
        //     foodLunchPrice: 20,
        //     foodDinnerPrice: 10,
        //     foodAvailable: true,
        //     foodNotAvailableText: 'На данный момент заказать питание невозможно',
        //     childCounts: null,
        //     foodTripleSalePrice: 10
        // }

        this.settings = {
            webpaySandbox: this.model.webpaySandbox,
            admin: this.model.admin,
            payment: this.model.payment,
            prepaidType: this.model.prepaidType,
            paymentMethod: this.model.paymentMethod,
            prepaidOptions: this.model.prepaidOptions,
            textFullCard: this.model.textFullCard,
            textPartCard: this.model.textPartCard,
            textFullLaterCard: this.model.textFullLaterCard,
            textPartLaterCard: this.model.textPartLaterCard,
            textFullOffice: this.model.textFullOffice,
            textPartOffice: this.model.textPartOffice,
            minPrice: this.model.minPrice,
            seasons: this.model.seasons,
            orderedSuccess: false,
            bookingErrorMessage: null,
            house: null,
            fio: getCookie('kg_name') || '',
            phone: getCookie('kg_phone') || '',
            email: getCookie('kg_email') || '',
            counts: null,
            childCounts: null,
            dateStart: this.model.dateFrom
                ? new moment(this.model.dateFrom, 'YYYY-MM-DD').format('DD-MM-YYYY')
                : null,
            dateEnd: this.model.dateTo
                ? new moment(this.model.dateTo, 'YYYY-MM-DD').format('DD-MM-YYYY')
                : null,
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
                    label: 'Питание',
                    value: 'food',
                    available: false,
                    active: false
                },
                {
                    label: 'Доп. услуги',
                    value: 'additional_services',
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
            ],
            babyBed: false,
            babyBedPrice: this.model.babyBedPrice,
            bathHouseBlackPrice: this.model.bathHouseBlackPrice,
            bathHouseWhitePrice: this.model.bathHouseWhitePrice,
            foodBreakfastPrice: this.model.foodBreakfastPrice,
            foodLunchPrice: this.model.foodLunchPrice,
            foodDinnerPrice: this.model.foodDinnerPrice,
            foodAvailable: this.model.foodAvailable,
            foodNotAvailableText: this.model.foodNotAvailableText,
            foodTripleSalePrice: this.model.foodTripleSalePrice
        }

        this.updateSettings({
            detail: this.settings,
            kgInit: true
        })
    }

    updateSettings(event) {
        console.log('event.detail', event.detail)

        if (!event.kgInit) {
            this.updateSeasons(event.detail.dateStart)
            this.settings = { ...this.settings, ...event.detail }
        }
        console.log('this.settings', this.settings)
        this.updateAvailableSteps()
        if (
            event.detail.dateStart ||
            event.detail.dateEnd ||
            event.detail.counts ||
            event.detail.house ||
            event.detail.babyBed !== undefined ||
            event.detail.smallAnimalCount !== undefined ||
            event.detail.bigAnimalCount !== undefined ||
            event.detail.bathHouseWhite !== undefined ||
            event.detail.bathHouseBlack !== undefined ||
            event.detail.foodBreakfast !== undefined ||          
            event.detail.foodLunch !== undefined ||        
            event.detail.foodDinner !== undefined            

        ) {
            if (event.detail.dateStart || event.detail.dateEnd) {
                this.updateSettingsOnly({ babyBed: false })
            }

            this.checkTotalPrice()
        }
    }

    async updateSeasons(dateStart) {
        if (dateStart && dateStart != this.settings.dateStart) {
            this.updateSettingsOnly({ seasonsLoading: true })
            const dateStartFormat = new moment(dateStart, 'DD-MM-YYYY').format('YYYY-MM-DD')

            const response = await fetch(
                'https://krasnagorka.by/wp-json/krasnagorka/v1/ls/current-season/',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    },
                    body: JSON.stringify({ dateStart: dateStartFormat })
                }
            )
            const data = await response.json()
            const result = { seasonsLoading: false }
            if (data.seasonId) {
                result.seasons = this.settings.seasons.map((season) => {
                    return {
                        ...season,
                        current: season.id == data.seasonId
                    }
                })
            }
            this.updateSettingsOnly(result)
        }
    }

    updateAvailableSteps() {
        const availableSteps = ['house']

        if (
            this.settings.house &&
            this.settings.counts.find((c) => c.selected) &&
            this.settings.dateStart &&
            this.settings.dateEnd
        ) {
            availableSteps.push('food')
            availableSteps.push('additional_services')
            availableSteps.push('contacts')
        }

        if (
            availableSteps.includes('contacts') &&
            this.settings.fio &&
            this.settings.phone &&
            this.settings.email &&
            this.settings.passport &&
            this.settings.agreement
        ) {
            availableSteps.push('checkout')
        }

        this.settings.menu = this.settings.menu.map((item) => {
            return { ...item, available: availableSteps.includes(item.value) }
        })
    }

    async checkTotalPrice() {
        const peopleCount = this.settings.counts?.find((c) => c.selected)?.name

        if (!peopleCount || !this.settings.dateStart || !this.settings.dateEnd) {
            this.updateSettingsOnly({ total: null })
            return
        }

        const house = this.settings.house.id
        const dateStart = new moment(this.settings.dateStart, 'DD-MM-YYYY')
            .add(1, 'days')
            .format('YYYY-MM-DD')
        const dateEnd = new moment(this.settings.dateEnd, 'DD-MM-YYYY').format('YYYY-MM-DD')
        const calendarId = this.settings.house.calendarId
        const isTerem = this.settings.house.isTerem
        const babyBed = this.settings.babyBed
        const bathHouseWhite = this.settings.bathHouseWhite
        const bathHouseBlack = this.settings.bathHouseBlack
        const smallAnimalCount = parseInt(this.settings.smallAnimalCount || 0)
        const bigAnimalCount = parseInt(this.settings.bigAnimalCount || 0)
        const foodBreakfast = parseInt(this.settings.foodBreakfast || 0)
        const foodLunch = parseInt(this.settings.foodLunch || 0)
        const foodDinner = parseInt(this.settings.foodDinner || 0)

        const hash = JSON.stringify({
            house,
            dateStart,
            dateEnd,
            peopleCount,
            calendarId,
            isTerem,
            babyBed,
            bathHouseWhite,
            bathHouseBlack,
            smallAnimalCount,
            bigAnimalCount,
            foodBreakfast,
            foodLunch,
            foodDinner
        })

        const activeStep = this.settings.menu.find((step) => step.active).value

        if (
            house &&
            dateStart &&
            dateEnd &&
            peopleCount &&
            (activeStep === 'house'|| activeStep === 'food' || activeStep === 'additional_services')
        ) {
            this.updateSettingsOnly({ totalPriceLoading: true })

            const response = await fetch(
                'https://krasnagorka.by/wp-json/krasnagorka/v1/ls/calculate/',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    },
                    body: hash
                }
            )
            const data = await response.json()

            this.updateSettingsOnly({ totalPriceLoading: false })

            if (data) {
                this.updateSettingsOnly({
                    total: data
                })
            }
        }
    }

    updateSettingsOnly(obj) {
        this.settings = { ...this.settings, ...obj }
    }
}
