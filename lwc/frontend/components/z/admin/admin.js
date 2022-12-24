import { LightningElement, api, track } from 'lwc'
import { getCookie } from 'z/utils'
import './admin.scss'

const BASE_MENU = [
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
]

export default class Admin extends LightningElement {
    @api model
    @track settings

    connectedCallback() {
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
            calendars: this.model.calendars ? [...this.model.calendars] : null,
            menu: BASE_MENU,
            babyBed: false,
            babyBedPrice: this.model.babyBedPrice,
            bathHouseBlackPrice: this.model.bathHouseBlackPrice,
            bathHouseWhitePrice: this.model.bathHouseWhitePrice,
            foodBreakfastPrice: this.model.foodBreakfastPrice,
            foodLunchPrice: this.model.foodLunchPrice,
            foodDinnerPrice: this.model.foodDinnerPrice,
            foodAvailable: this.model.foodAvailable,
            foodNotAvailableText: this.model.foodNotAvailableText,
            foodTripleSalePrice: this.model.foodTripleSalePrice,
            baby_bed_available: this.model.baby_bed_available,
            total: this.model.total
        }

        if (this.model.eventTabId) {
            this.settings.eventTabId = this.model.eventTabId
            this.settings.eventTabMessageInfo = this.model.eventTabMessageInfo
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

            if (this.settings.eventTabId) {
                if ('counts' in event.detail) {
                    return
                }
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
        const calendarId = this.settings.calendars.find((item) => item.selected).id
        const isTerem = this.settings.house.isTerem
        const babyBed = this.settings.babyBed
        const bathHouseWhite = this.settings.bathHouseWhite
        const bathHouseBlack = this.settings.bathHouseBlack
        const smallAnimalCount = parseInt(this.settings.smallAnimalCount || 0)
        const bigAnimalCount = parseInt(this.settings.bigAnimalCount || 0)
        const foodBreakfast = parseInt(this.settings.foodBreakfast || 0)
        const foodLunch = parseInt(this.settings.foodLunch || 0)
        const foodDinner = parseInt(this.settings.foodDinner || 0)
        const eventTabId = this.settings.eventTabId

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
            foodDinner,
            eventTabId
        })

        const activeStep = this.settings.menu.find((step) => step.active).value

        if (
            house &&
            dateStart &&
            dateEnd &&
            peopleCount &&
            (activeStep === 'house' ||
                activeStep === 'food' ||
                activeStep === 'additional_services')
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
