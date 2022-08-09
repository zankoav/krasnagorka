import { LightningElement, api, track } from 'lwc'
import { getCookie, setCookie } from 'z/utils'
import './booking.scss'

const MAX_AGE = 3600 * 24 * 100
import OK from './../../../icons/checkon.svg'
import ERROR from './../../../icons/error.svg'

const SUCCESS = {
    BASE: {
        title: 'Бронирование выполнено успешно!',
        description: 'Наш сотрудник скоро свяжется с вами для уточнения деталей',
        redirect: false
    },
    PAID: {
        title: 'Перенаправление на оплату...',
        description: 'После оплаты, Вам на почту придет письмо с заказом и инструкцией',
        redirect: true
    },
    LAITER: {
        title: 'Бронирование выполнено успешно!',
        description: 'На Вашу почту отправлено письмо с инструкцией по оплате.',
        redirect: false
    },
    OFFICE: {
        title: 'Бронирование выполнено успешно!',
        description: 'На Вашу почту отправлено письмо с координатами нашего офиса',
        redirect: false
    }
}

export default class BookingForm extends LightningElement {
    @api model
    @api settings
    @track loading
    @track okImage = OK
    @track errorImage = ERROR

    get isHouseStep() {
        return this.settings.menu[0].active
    }

    get isFoodStep() {
        return this.settings.menu[1].active
    }

    get isAdditionalServicesStep() {
        return this.settings.menu[2].active
    }

    get isContactStep() {
        return this.settings.menu[3].active
    }

    get isCheckoutStep() {
        return this.settings.menu[4].active
    }

    get orderedSuccessData() {
        let result = SUCCESS.BASE
        if (this.settings.payment) {
            if (this.settings.paymentMethod === 'card') {
                result = SUCCESS.PAID
            } else if (this.settings.paymentMethod === 'card_layter') {
                result = SUCCESS.LAITER
            } else if (this.settings.paymentMethod === 'office') {
                result = SUCCESS.OFFICE
            }
        }
        return result
    }

    getChildsCount() {
        const childCountsSeectedItem = this.settings.childCounts.find((c) => c.selected)
        return childCountsSeectedItem ? childCountsSeectedItem.name : 0
    }

    isPayment() {
        return this.settings.payment && !this.settings.total.only_booking_order.enabled
    }

    async bookingOrder() {
        this.loading = true

        const requestData = {
            contact: {
                fio: this.settings.fio,
                phone: this.settings.phone,
                email: this.settings.email,
                passport: this.settings.passport
            },
            calendarId: this.settings.calendars.find((c) => c.selected).id,
            count: this.settings.counts.find((c) => c.selected).name,
            dateStart: new moment(this.settings.dateStart, 'DD-MM-YYYY').format('YYYY-MM-DD'),
            dateEnd: new moment(this.settings.dateEnd, 'DD-MM-YYYY').format('YYYY-MM-DD'),
            houseId: this.settings.house.id,
            childCount: this.getChildsCount(),
            comment: this.settings.comment,
            paymentMethod: this.isPayment() ? this.settings.paymentMethod : null,
            prepaidType: this.isPayment() ? this.settings.prepaidType : null,
            babyBed: !!this.settings.babyBed,
            bathHouseWhite: this.settings.bathHouseWhite || 0,
            bathHouseBlack: this.settings.bathHouseBlack || 0,
            smallAnimalCount: this.settings.smallAnimalCount || 0,
            bigAnimalCount: this.settings.bigAnimalCount || 0,
            foodBreakfast: this.settings.foodBreakfast || 0,
            foodLunch: this.settings.foodLunch || 0,
            foodDinner: this.settings.foodDinner || 0,
            eventTabId: this.settings.eventTabId
        }

        const response = await fetch('https://krasnagorka.by/wp-json/amocrm/v4/create-order/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify(requestData)
        }).then((data) => data.json())

        if (response) {
            if (response.error) {
                if (response.error.code === 212) {
                    this.dispatchEvent(
                        new CustomEvent('update', {
                            detail: {
                                bookingErrorMessage:
                                    'Извините! Выбранные даты заняты. Выберите свободный интервал.'
                            },
                            bubbles: true,
                            composed: true
                        })
                    )
                } else {
                    this.showError()
                }
            } else if (response.data) {
                setCookie('kg_name', this.settings.fio, { 'max-age': MAX_AGE })
                setCookie('kg_phone', this.settings.phone, { 'max-age': MAX_AGE })
                setCookie('kg_email', this.settings.email, { 'max-age': MAX_AGE })
                gtag('event', 'create_lead')

                if (response.data.template) {
                    this.dispatchEvent(
                        new CustomEvent('update', {
                            detail: {
                                tmpl: response.data.template,
                                orderedSuccess: true
                            },
                            bubbles: true,
                            composed: true
                        })
                    )
                } else if (response.data.redirect) {
                    response.data.redirect.values.wsb_storeid =
                        this.settings.webpaySandbox.wsb_storeid
                    response.data.redirect.values.wsb_test = this.settings.webpaySandbox.wsb_test

                    generateAndSubmitForm(
                        this.settings.webpaySandbox.url,
                        response.data.redirect.values,
                        response.data.redirect.names
                    )

                    this.dispatchEvent(
                        new CustomEvent('update', {
                            detail: {
                                orderedSuccess: true
                            },
                            bubbles: true,
                            composed: true
                        })
                    )
                } else if (response.data.ordered_only) {
                    this.dispatchEvent(
                        new CustomEvent('update', {
                            detail: {
                                orderedSuccess: true
                            },
                            bubbles: true,
                            composed: true
                        })
                    )
                } else {
                    this.showError()
                }
            }
        } else {
            this.showError()
        }
        this.loading = false
    }

    async sendOrder() {
        await this.bookingOrder()
    }

    showError() {
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    orderedError: true
                },
                bubbles: true,
                composed: true
            })
        )
    }

    renderedCallback() {
        const template = this.template.querySelector('.booking__template')
        if (template) {
            template.innerHTML = this.finishTemplate
        }
    }

    get finishTemplate() {
        return this.settings.tmpl
            ?.replace('600px', '100%')
            .replace('600', '100')
            .replace('w80', 'width=100')
    }

    get cssCardTemplate() {
        return this.settings.tmpl ? 'booking__card booking__card_template' : 'booking__card'
    }

    get cssCardTemplateContainer() {
        return this.settings.tmpl ? 'container container_template' : 'container'
    }
}

function generateAndSubmitForm(action, paramsWithValue, paramsWithNames, method = 'POST') {
    const form = document.createElement('form')
    form.action = action
    form.method = method

    paramsWithValue.wsb_cancel_return_url = `${location.href}&clear=${paramsWithValue.wsb_order_num}`

    // eslint-disable-next-line guard-for-in
    for (const key in paramsWithValue) {
        const element = document.createElement('input')
        element.type = 'hidden'
        element.name = key
        element.value = paramsWithValue[key]
        form.appendChild(element)
    }

    for (const key of paramsWithNames) {
        const element = document.createElement('input')
        element.type = 'hidden'
        element.name = key
        form.appendChild(element)
    }

    document.body.appendChild(form)
    form.submit()
}
