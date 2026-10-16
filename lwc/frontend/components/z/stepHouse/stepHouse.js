import { LightningElement, track, api } from 'lwc'
import './stepHouse.scss'
import IMG_BOOKING from './../../../icons/date-clicking-selecting.png'

export default class StepHouse extends LightningElement {
    @api settings
    @track loading
    @track bookingImg = IMG_BOOKING
    @track error
    @track fieldsError
    @track priceInfoExpanded = false
    @track soonEventsLoading = false
    @track soonEventsWithPrice = []
    @track soonEventsUnavailable = false
    @track availableCalendars = []
    @track availableCalendarsError
    @track bigEvents = []
    @track bigEventsLoading = false

    happyEventsObj
    happyEventsObjRange
    soonEventsRequestId = 0
    soonEventsSignature
    soonEventsWithPriceSignature
    availableCalendarsRequestId = 0
    bigEventsRequestId = 0
    bigEventsSignature

    get showPriceInfo() {
        return !this.settings.eventId && !this.settings.package
    }

    get priceInfoContentClass() {
        return `step-house__info-content${this.priceInfoExpanded ? ' step-house__info-content_open' : ''}`
    }

    get priceInfoHidden() {
        return !this.priceInfoExpanded
    }

    get peopleCountLabel() {
        let result = 'Количество человек'
        return result
    }

    get eventChilds() {
        return [
            {
                id: this.settings.eventModel.childs,
                selected: true,
                name: this.settings.eventModel.childs
            }
        ]
    }

    get fireEvents() {
        const calendar = this.settings.calendars.find((c) => c.selected)
        return (
            this.settings.fier_events
                ?.filter((item) => item.calendar == calendar.id)
                .map((item) => {
                    const from = new moment(item.from, 'MM/DD/YYYY').format('YYYY-MM-DD')
                    const to = new moment(item.to, 'MM/DD/YYYY').format('YYYY-MM-DD')
                    const fromDisplay = new moment(item.from, 'MM/DD/YYYY').format('DD.MM.YYYY')
                    const toDisplay = new moment(item.to, 'MM/DD/YYYY').format('DD.MM.YYYY')
                    return {
                        id: `${item.tab_id}-${item.calendar}-${from}-${to}`,
                        params: {
                            eventTabId: item.tab_id,
                            booking: item.house,
                            calendarId: item.calendar,
                            from,
                            to,
                            ...(calendar.isTerem ? { terem: calendar.name } : {})
                        },
                        title: calendar.name,
                        description: item.sale_text?.replace(/[\t\n\r]+/g, ' '),
                        dates: `${fromDisplay} - ${toDisplay}`,
                        price: {
                            rub: item.new_price,
                            penny: '00'
                        },
                        image: this.settings.house.picture
                    }
                }) || []
        )
    }

    get availableSoonEvents() {
        const selectedDateStart = this.settings.dateStart
            ? moment(this.settings.dateStart, 'DD-MM-YYYY')
            : null
        const selectedDateEnd = this.settings.dateEnd
            ? moment(this.settings.dateEnd, 'DD-MM-YYYY')
            : null
        const selectedCalendarId = this.settings.calendars?.find((item) => item.selected)?.id

        const fromDisplay = new moment(selectedDateStart).format('DD.MM.YYYY')
        const toDisplay = new moment(selectedDateEnd).format('DD.MM.YYYY')

        return (this.settings.package_tour || [])
            .filter((item) => {
                if (!selectedDateStart || !selectedDateEnd || !selectedCalendarId) {
                    return false
                }

                const eventDateStart = moment.unix(item.date_start).startOf('day')
                const eventDateEnd = moment.unix(item.date_finish).endOf('day')

                return (
                    selectedDateStart.isSameOrAfter(eventDateStart, 'day') &&
                    selectedDateEnd.isSameOrBefore(eventDateEnd, 'day') &&
                    item.calendarIds?.some(
                        (calendarId) => String(calendarId) === String(selectedCalendarId)
                    )
                )
            })
            .map((item) => {
                const url = new URL(item.event_link, window.location.origin)

                return {
                    ...item,
                    dates: `${fromDisplay} - ${toDisplay}`,
                    params: Object.fromEntries(url.searchParams.entries())
                }
            })
    }

    get selectedPeople() {
        return this.settings.counts?.find((item) => item.selected)?.name
    }

    get selectedCalendarId() {
        return this.settings.calendars?.find((item) => item.selected)?.id
    }

    get canCalculateSoonEvents() {
        const selectedCalendar = this.settings.calendars?.find((item) => item.selected)

        return Boolean(
            this.availableSoonEvents.length &&
                this.settings.house?.id &&
                selectedCalendar &&
                this.settings.dateStart &&
                this.settings.dateEnd &&
                this.selectedPeople
        )
    }

    get canLoadBigEvents() {
        return Boolean(
            this.settings.house?.id &&
                this.selectedCalendarId &&
                this.settings.dateStart &&
                this.settings.dateEnd &&
                this.selectedPeople
        )
    }

    get bigEventGroups() {
        const groups = []

        this.bigEvents.forEach((bigEvent) => {
            const eventGroups = {}
            const calendars = bigEvent.calendars || []

            calendars.forEach((calendar) => {
                const groupId = calendar.group || 'other'
                if (!eventGroups[groupId]) {
                    eventGroups[groupId] = {
                        id: `${bigEvent.id}-${groupId}`,
                        items: [],
                        variants: bigEvent.variants || [],
                        variant_default: bigEvent.variant_default,
                        days: bigEvent.interval,
                        eventTabId: bigEvent.id,
                        eventId: bigEvent.eventId,
                        eventTitle: bigEvent.eventTitle,
                        peopleCount: Number(this.selectedPeople),
                        childCount: Number(this.settings.child) || 0
                    }
                }

                eventGroups[groupId].items.push({
                    ...calendar,
                    image: bigEvent.eventImage || calendar.image,
                    selected: !eventGroups[groupId].items.length
                })
            })

            groups.push(...Object.values(eventGroups))
        })

        return groups
    }

    get showBigEvents() {
        return this.canLoadBigEvents && (this.bigEventsLoading || this.bigEventGroups.length)
    }

    get offersLoading() {
        return this.soonEventsLoading || this.bigEventsLoading
    }

    get showOffersSections() {
        return Boolean(
            this.offersLoading ||
                this.showSoonEvents ||
                this.fireEvents.length ||
                this.showBigEvents
        )
    }

    get showSoonOrFireEvents() {
        return this.showSoonEvents || this.fireEvents.length
    }

    get showSoonEvents() {
        const signature = this.getSoonEventsSignature()

        return Boolean(
            signature &&
                (this.soonEventsLoading ||
                    (this.soonEventsUnavailable && this.soonEventsWithPriceSignature === signature) ||
                    (this.soonEventsWithPrice.length && this.soonEventsWithPriceSignature === signature))
        )
    }

    get soonEvents() {
        return this.soonEventsWithPrice
    }

    get showChilds() {
        return this.settings.scenario === 'Event' && this.settings.eventModel.enabled_child
    }

    get showDaylySales() {
        return !this.settings.eventId && this.settings.scenario !== 'Package'
    }

    get showPackageDaylySales() {
        return this.settings.scenario == 'Package' && this.settings.package.daysSales.length
    }

    get showPackageInfo() {
        return this.settings.package
    }

    get happyEvents() {
        let result = []

        if (this.happyEventsObj && this.happyEventsObjRange) {
            const iconPath = this.happyEventsObj.icon_path
            const items = this.happyEventsObj.items.filter(
                (item) =>
                    item.date >= this.happyEventsObjRange.start &&
                    item.date <= this.happyEventsObjRange.end
            )

            for (const item of items) {
                const isNewItem = result.find((it) => it.icon === item.icon)
                if (!isNewItem && item.description) {
                    result.push({
                        index: `${item.date}`,
                        icon: item.icon,
                        img: `${iconPath}${item.icon}.svg`,
                        description: item.description
                    })
                }
            }
        }
        return result
    }

    get dateStart() {
        return this.settings.dateStart ? this.settings.dateStart.replace(/-/g, '.') : '—'
    }

    get dateEnd() {
        return this.settings.dateEnd ? this.settings.dateEnd.replace(/-/g, '.') : '—'
    }

    get dateStartPicker() {
        return this.toPickerDate(this.settings.dateStart)
    }

    get dateEndPicker() {
        return this.toPickerDate(this.settings.dateEnd)
    }

    get classForNextButton() {
        const baseClass = 'step-button-navigation__button'

        return this.fieldsAreValid ? `${baseClass} step-button-navigation__button_available` : baseClass
    }

    get fieldsAreValid() {
        return !this.getFieldsValidationError()
    }

    get packageCalendarIds() {
        return Object.keys(this.settings.package?.calendars || {}).map(String)
    }

    get selectableCalendars() {
        const calendars = this.settings.calendars || []

        if (!this.settings.package || !this.packageCalendarIds.length) {
            return calendars
        }

        return calendars.filter((calendar) => this.packageCalendarIds.includes(String(calendar.id)))
    }

    get packageTitle() {
        const title = this.settings.package?.title || ''
        const textArea = document.createElement('textarea')

        textArea.innerHTML = title

        return textArea.value.replace(/^Тур\s+/i, '')
    }

    get packageUnavailableMessage() {
        return `На эти даты тур ${this.packageTitle} не доступен`
    }

    getFieldsValidationError() {
        const dateStart = moment(this.settings.dateStart, 'DD-MM-YYYY', true)
        const dateEnd = moment(this.settings.dateEnd, 'DD-MM-YYYY', true)
        const people = Number(this.settings.people)

        if (!this.settings.dateStart || !dateStart.isValid()) {
            return 'Выберите дату заезда'
        }

        if (!this.settings.dateEnd || !dateEnd.isValid()) {
            return 'Выберите дату выезда'
        }

        if (dateStart.isBefore(moment().startOf('day'), 'day')) {
            return 'Нельзя бронировать прошлые даты'
        }

        if (!dateEnd.isAfter(dateStart, 'day')) {
            return 'Дата выезда должна быть позже даты заезда'
        }

        if (!Number.isFinite(people) || people <= 0) {
            return 'Выберите количество отдыхающих'
        }

        if (this.settings.package) {
            const packageStart = moment(this.settings.package.start_date, 'MM/DD/YYYY', true)
            const packageEnd = moment(this.settings.package.end_date, 'MM/DD/YYYY', true)
            const minimumNights = Number(this.settings.package.min_night) || 0

            if (
                (packageStart.isValid() && dateStart.isBefore(packageStart, 'day')) ||
                (packageEnd.isValid() && dateEnd.isAfter(packageEnd, 'day'))
            ) {
                return this.packageUnavailableMessage
            }

            const isDeprecatedDay = (this.settings.package.depricatedDayes || []).some(
                (day) => dateStart.format('YYYY-MM-DD') <= day && dateEnd.format('YYYY-MM-DD') >= day
            )

            if (isDeprecatedDay) {
                return this.packageUnavailableMessage
            }

            if (minimumNights && dateEnd.diff(dateStart, 'days') < minimumNights) {
                return `Минимальное количество ночей: ${minimumNights}`
            }

            const hasAvailablePackageCalendar = this.selectableCalendars.some((calendar) => {
                const packageCalendar = this.settings.package.calendars?.[calendar.id]
                const minPeople = Number(packageCalendar?.min_people) || 0
                const maxPeople = Number(calendar.peopleMaxCount)

                return (
                    people >= minPeople &&
                    (!Number.isFinite(maxPeople) || maxPeople <= 0 || people <= maxPeople)
                )
            })

            if (!hasAvailablePackageCalendar) {
                return 'Для выбранного количества отдыхающих нет доступных объектов в пакетном туре'
            }
        }

        return null
    }

    get peopleOptions() {
        return this.getCountOptions(1, this.maxPeopleCount, this.settings.people)
    }

    get maxPeopleCount() {
        const peopleLimits = this.selectableCalendars
            .map((calendar) => Number(calendar.peopleMaxCount))
            .filter((limit) => Number.isFinite(limit) && limit > 0)
        const fallbackMaxCount = Number(this.settings.maxCount)

        if (peopleLimits.length) {
            return Math.max(...peopleLimits)
        }

        return Number.isFinite(fallbackMaxCount) && fallbackMaxCount > 0
            ? Math.floor(fallbackMaxCount)
            : 15
    }

    get childOptions() {
        return this.getCountOptions(0, this.maxChildCount, this.settings.child)
    }

    get showAvailableCalendars() {
        return Boolean(
            this.availableCalendarsError ||
                this.availableCalendars.length
        )
    }

    get maxChildCount() {
        const childLimits = this.selectableCalendars
            .map((calendar) => Number(calendar.maxChild))
            .filter((limit) => Number.isFinite(limit))

        return Math.max(0, ...childLimits)
    }

    get currentSeason() {
        return this.settings.seasons.find((season) => season.current)
    }

    get showEventMessageInfo() {
        return this.settings.eventTabId && this.settings.eventTabMessageInfo
    }

    get eventOpportunities() {
        return this.settings.eventModel.content.filter((item) => !!item).join(', ')
    }

    connectedCallback() {
        const calendar = this.settings.calendars.find((c) => c.selected)
        if (calendar && !this.settings.house) {
            this.initHouse(calendar.id, calendar.isTerem)
        }
    }

    getBigEventsSignature() {
        if (!this.canLoadBigEvents) {
            return null
        }

        return JSON.stringify({
            dateStart: this.settings.dateStart,
            dateEnd: this.settings.dateEnd,
            people: this.selectedPeople,
            child: Number(this.settings.child) || 0,
            houseId: this.settings.house.id,
            calendarId: this.selectedCalendarId
        })
    }

    refreshBigEvents() {
        const signature = this.getBigEventsSignature()
        if (signature === this.bigEventsSignature) {
            return
        }

        this.bigEventsSignature = signature

        if (!signature) {
            this.bigEventsRequestId += 1
            this.bigEventsLoading = false
            this.bigEvents = []
            return
        }

        this.loadBigEvents(signature)
    }

    async loadBigEvents(signature) {
        const requestId = ++this.bigEventsRequestId
        this.bigEventsLoading = true

        try {
            const response = await fetch('https://krasnagorka.by/wp-json/krasnagorka/v1/ls/big-events/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                },
                body: JSON.stringify({
                    house: this.settings.house.id,
                    calendarId: this.selectedCalendarId,
                    people: Number(this.selectedPeople),
                    child: Number(this.settings.child) || 0
                })
            })
            if (!response.ok) {
                throw new Error(`Unable to load big events: ${response.status}`)
            }

            const data = await response.json()
            if (requestId === this.bigEventsRequestId && signature === this.bigEventsSignature) {
                this.bigEvents = data.big_events || []
            }
        } catch (error) {
            if (requestId === this.bigEventsRequestId && signature === this.bigEventsSignature) {
                this.bigEvents = []
                console.error('Unable to load big events', error)
            }
        } finally {
            if (requestId === this.bigEventsRequestId) {
                this.bigEventsLoading = false
            }
        }
    }

    renderedCallback() {
        const title = this.template.querySelector('.step-house__subtitle')
        if (title && this.settings.package) {
            const packageStart = moment(this.settings.package.start_date, 'MM/DD/YYYY').format('DD.MM.YYYY')
            const packageEnd = moment(this.settings.package.end_date, 'MM/DD/YYYY').format('DD.MM.YYYY')

            title.innerHTML = `${this.settings.package.title} <div class="step-house__subtitle-small">${packageStart} - ${packageEnd}</div>`
        }

        this.refreshSoonEventsPrices()
        this.refreshBigEvents()
    }

    getSoonEventsSignature() {
        if (!this.canCalculateSoonEvents) {
            return null
        }

        const calendar = this.settings.calendars.find((item) => item.selected)

        return JSON.stringify({
            eventIds: this.availableSoonEvents.map((item) => item.id),
            calendarId: calendar.id,
            dateStart: this.settings.dateStart,
            dateEnd: this.settings.dateEnd,
            peopleCount: this.selectedPeople,
            houseId: this.settings.house.id
        })
    }

    refreshSoonEventsPrices() {
        const signature = this.getSoonEventsSignature()

        if (signature === this.soonEventsSignature) {
            return
        }

        this.soonEventsSignature = signature

        if (!signature) {
            this.soonEventsRequestId += 1
            this.soonEventsLoading = false
            this.soonEventsWithPrice = []
            this.soonEventsWithPriceSignature = null
            this.soonEventsUnavailable = false
            return
        }

        this.calculateSoonEventsPrices(signature, this.availableSoonEvents)
    }

    async calculateSoonEventsPrices(signature, events) {
        const requestId = ++this.soonEventsRequestId
        const calendar = this.settings.calendars.find((item) => item.selected)
        const dateStart = new moment(this.settings.dateStart, 'DD-MM-YYYY')
            .add(1, 'days')
            .format('YYYY-MM-DD')
        const dateEnd = new moment(this.settings.dateEnd, 'DD-MM-YYYY').format('YYYY-MM-DD')

        this.soonEventsLoading = true
        this.soonEventsWithPrice = []
        this.soonEventsWithPriceSignature = null
        this.soonEventsUnavailable = false

        try {
            const calculatedEvents = await Promise.all(
                events.map(async (event) => {
                    const response = await fetch('https://krasnagorka.by/wp-json/krasnagorka/v1/ls/calculate/', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json; charset=utf-8'
                        },
                        body: JSON.stringify({
                            scenario: 'Package',
                            packageId: event.params['package-id'],
                            calendarId: calendar.id,
                            dateStart,
                            dateEnd,
                            house: this.settings.house.id,
                            peopleCount: this.selectedPeople,
                            babyBed: false,
                            bathHouseWhite: false,
                            bathHouseBlack: false
                        })
                    })

                    if (!response.ok) {
                        throw new Error(`Unable to calculate package price: ${response.status}`)
                    }

                    const data = await response.json()
                    const totalPrice = Number(data.result?.total_price)

                    if (data.scenario !== 'Package' || !Number.isFinite(totalPrice)) {
                        return { unavailable: false }
                    }

                    if (data.result?.error) {
                        return {
                            unavailable: ['Минимальное количество человек', 'Минимальное количество ночей'].some(
                                (message) => data.result.error.includes(message)
                            )
                        }
                    }

                    const [rub, penny] = totalPrice.toFixed(2).split('.')

                    return {
                        event: {
                            ...event,
                            price: { rub, penny }
                        },
                        unavailable: false
                    }
                })
            )

            if (requestId === this.soonEventsRequestId && signature === this.soonEventsSignature) {
                this.soonEventsWithPrice = calculatedEvents
                    .filter((item) => item.event)
                    .map((item) => item.event)
                this.soonEventsWithPriceSignature = signature
                this.soonEventsUnavailable =
                    calculatedEvents.length > 0 &&
                    calculatedEvents.every((item) => item.unavailable)
            }
        } catch (error) {
            if (requestId === this.soonEventsRequestId) {
                this.soonEventsWithPrice = []
                this.soonEventsWithPriceSignature = null
                this.soonEventsUnavailable = false
                console.error('Unable to calculate package prices', error)
            }
        } finally {
            if (requestId === this.soonEventsRequestId) {
                this.soonEventsLoading = false
            }
        }
    }

    togglePriceInfo() {
        this.priceInfoExpanded = !this.priceInfoExpanded
    }

    loadFireEvent(event) {
        const fireEvent = this.fireEvents.find(
            (item) => String(item.id) === event.currentTarget.dataset.id
        )
        const selectedPeople = this.settings.counts?.find((item) => item.selected)?.name
        const selectedChild = this.settings.childCounts?.find((item) => item.selected)?.name

        if (!fireEvent) {
            return
        }

        this.loadBookingModel({
            ...fireEvent.params,
            ...(selectedPeople ? { people: selectedPeople } : {}),
            ...(selectedChild !== undefined ? { child: selectedChild } : {})
        })
    }

    loadSoonEvent(event) {
        const soonEvent = this.soonEvents.find(
            (item) => String(item.id) === event.currentTarget.dataset.id
        )
        const selectedCalendar = this.settings.calendars.find((item) => item.selected)
        const selectedPeople = this.settings.counts?.find((item) => item.selected)?.name
        const selectedChild = this.settings.childCounts?.find((item) => item.selected)?.name

        if (!soonEvent || !selectedCalendar) {
            return
        }

        this.loadBookingModel({
            ...soonEvent.params,
            promotionId: soonEvent.id,
            calendarId: selectedCalendar.id,
            from: moment(this.settings.dateStart, 'DD-MM-YYYY').format('YYYY-MM-DD'),
            to: moment(this.settings.dateEnd, 'DD-MM-YYYY').format('YYYY-MM-DD'),
            ...(selectedPeople ? { people: selectedPeople } : {}),
            ...(selectedChild !== undefined ? { child: selectedChild } : {}),
            ...(selectedCalendar.isTerem ? { terem: selectedCalendar.name } : {})
        })
    }

    loadBookingModel(params) {
        this.dispatchEvent(
            new CustomEvent('loadbookingmodel', {
                detail: params,
                bubbles: true,
                composed: true
            })
        )
    }

    handlePriceInfoKeydown(event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault()
            this.togglePriceInfo()
        }
    }

    async initHouse(calendarId, isTeremCalendar) {
        const id = parseInt(calendarId)
        this.error = false
        this.loading = true
        const house = await fetch(
            `https://krasnagorka.by/wp-json/krasnagorka/v1/ls/house/?calendarId=${id}&isTeremCalendar=${isTeremCalendar}`
        )
            .catch((error) => {
                console.log('error', error)
            })
            .then((data) => data.json())

        this.loading = false
        const newCalendars = this.settings.calendars.map((c) => {
            return { ...c, selected: c.id === id }
        })

        const count = parseInt(house.peopleMaxCount)

        let counts = Array.from(Array(count), (_, i) => i + 1).map((it) => {
            let selected = false
            if (this.settings.people && this.settings.people == it) {
                selected = true
            }
            return {
                id: it,
                selected: selected,
                name: it
            }
        })

        let minPeople = this.settings.package?.calendars[id].min_people || 0
        counts = counts.filter((item) => item.id >= minPeople)

        let maxChild = newCalendars.find((c) => c.selected).maxChild
        maxChild = maxChild > 0 ? maxChild + 1 : 1

        const childCounts = Array.from(Array(maxChild), (_, i) => i).map((it) => {
            return {
                id: it,
                selected: this.settings.child !== undefined && this.settings.child == it,
                name: it
            }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    calendars: newCalendars,
                    house: house,
                    counts: counts,
                    childCounts: childCounts
                },
                bubbles: true,
                composed: true
            })
        )
    }

    calendarChange(event) {
        this.error = false
        const calendar = this.settings.calendars.find((c) => c.id == event.detail)
        this.initHouse(calendar.id, calendar.isTerem)
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    dateStart: null,
                    dateEnd: null
                },
                bubbles: true,
                composed: true
            })
        )
    }

    seasonsChange(event) {
        const seasons = this.settings.seasons.map((season) => {
            return {
                ...season,
                current: season.id == event.detail
            }
        })
        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    seasons: seasons
                },
                bubbles: true,
                composed: true
            })
        )
    }

    countChange(event) {
        this.error = false
        const id = parseInt(event.detail)
        const newCounts = this.settings.counts.map((c) => {
            return { ...c, selected: c.id === id }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    counts: newCounts
                },
                bubbles: true,
                composed: true
            })
        )
        this.error = false
    }

    childCountChange(event) {
        const id = parseInt(event.detail)
        const newChildCounts = this.settings.childCounts.map((c) => {
            return { ...c, selected: c.id === id }
        })

        this.dispatchEvent(
            new CustomEvent('update', {
                detail: {
                    childCounts: newChildCounts,
                    child: id
                },
                bubbles: true,
                composed: true
            })
        )
        this.error = false
    }

    datePickerChange(event) {
        const date = moment(event.target.value, 'YYYY-MM-DD', true)
        const field = event.target.dataset.field

        this.clearFieldsError()
        this.updateSettings({
            [field]: date.isValid() ? date.format('DD-MM-YYYY') : null
        })
    }

    openNativeDatePicker(event) {
        const input = event.target

        if (typeof input.showPicker === 'function') {
            try {
                input.showPicker()
            } catch (error) {
                // Some browsers allow the native picker only after a direct click.
            }
        }
    }

    peopleChange(event) {
        this.clearFieldsError()
        this.updateSettings({ people: Number(event.detail) })
    }

    childChange(event) {
        this.clearFieldsError()
        this.updateSettings({ child: Number(event.detail) })
    }

    async fieldsNextButtonHandler() {
        const dateStart = moment(this.settings.dateStart, 'DD-MM-YYYY', true)
        const dateEnd = moment(this.settings.dateEnd, 'DD-MM-YYYY', true)
        const people = Number(this.settings.people)
        const error = this.getFieldsValidationError()

        this.fieldsError = error

        if (error || this.loading) {
            return
        }

        const requestId = ++this.availableCalendarsRequestId
        this.loading = true
        this.availableCalendars = []
        this.availableCalendarsError = null

        try {
            const response = await fetch('https://krasnagorka.by/wp-json/krasnagorka/v1/ls/available-calendars/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                },
                body: JSON.stringify({
                    dateStart: dateStart.format('YYYY-MM-DD'),
                    dateEnd: dateEnd.format('YYYY-MM-DD'),
                    people,
                    child: Number(this.settings.child) || 0,
                    packageId: this.settings.package?.id || null
                })
            })
            const data = await response.json()

            if (!response.ok) {
                throw new Error(data.errorMessage || 'Не удалось подобрать объект размещения')
            }

            if (requestId === this.availableCalendarsRequestId) {
                this.availableCalendars = this.filterAvailableCalendarsForPackage(data.calendars || []).map(
                    (calendar) => ({
                        ...calendar,
                        price: this.toPrice(calendar.price)
                    })
                )
                this.availableCalendarsError = this.availableCalendars.length
                    ? null
                    : 'К сожалению, по выбранным условиям ничего не найдено.'
            }
        } catch (requestError) {
            if (requestId === this.availableCalendarsRequestId) {
                this.availableCalendarsError = requestError.message || 'Не удалось подобрать объект размещения'
            }
        } finally {
            if (requestId === this.availableCalendarsRequestId) {
                this.loading = false
            }
        }
    }

    selectAvailableCalendar(event) {
        if (
            event.type === 'keydown' &&
            event.key !== 'Enter' &&
            event.key !== ' '
        ) {
            return
        }

        if (event.type === 'keydown') {
            event.preventDefault()
        }

        const calendar = this.availableCalendars.find(
            (item) => String(item.id) === event.currentTarget.dataset.id
        )

        if (calendar) {
            this.initHouse(calendar.id, calendar.isTerem)
        }
    }

    clearFieldsError() {
        this.fieldsError = null
        this.resetAvailableCalendars()
    }

    resetAvailableCalendars() {
        this.availableCalendarsRequestId += 1
        this.availableCalendars = []
        this.availableCalendarsError = null
    }

    getCountOptions(min, max, selectedValue) {
        const hasSelectedValue = selectedValue !== null && selectedValue !== undefined && selectedValue !== ''

        return Array.from({ length: max - min + 1 }, (_, index) => {
            const value = min + index

            return {
                id: value,
                name: value,
                selected: hasSelectedValue && value === Number(selectedValue)
            }
        })
    }

    toPickerDate(value) {
        return value ? moment(value, 'DD-MM-YYYY').format('YYYY-MM-DD') : null
    }

    toPrice(value) {
        const price = Number(value)

        if (!Number.isFinite(price)) {
            return null
        }

        const [rub, penny] = price.toFixed(2).split('.')

        return { rub, penny }
    }

    filterAvailableCalendarsForPackage(calendars) {
        if (!this.settings.package || !this.packageCalendarIds.length) {
            return calendars
        }

        return calendars.filter((calendar) => this.packageCalendarIds.includes(String(calendar.id)))
    }

    updateSettings(detail) {
        this.dispatchEvent(
            new CustomEvent('update', {
                detail,
                bubbles: true,
                composed: true
            })
        )
    }

    nextButtonHandler() {
        if (!this.settings.calendars.find((op) => op.selected)) {
            const selectorCalendars = this.template.querySelector('.step-house__calendars')
            if (selectorCalendars) {
                selectorCalendars.showError()
                this.error = 'Выберите домик'
            }
        } else if (!this.settings.counts.find((op) => op.selected)) {
            const selectorCounts = this.template.querySelector('.step-house__counts')
            if (selectorCounts) {
                selectorCounts.showError()
                this.error = 'Выберите количество отдыхающих'
            }
        } else if (!this.settings.dateStart) {
            this.error = 'Выберите дату заезда'
        } else if (!this.settings.dateEnd) {
            this.error = 'Выберите дату выезда'
        } else {
            let newMenu
            if (this.settings.eventId) {
                newMenu = this.settings.menu.map((it) => {
                    return { ...it, active: it.value === 'contacts' }
                })
            } else if (this.settings.package?.services?.find((item) => item == '1')) {
                newMenu = this.settings.menu.map((it) => {
                    return { ...it, active: it.value === 'additional_services' }
                })
            } else {
                newMenu = this.settings.menu.map((it) => {
                    return { ...it, active: it.value === 'food' }
                })
            }
            this.dispatchEvent(
                new CustomEvent('update', {
                    detail: {
                        menu: newMenu
                    },
                    bubbles: true,
                    composed: true
                })
            )
        }
    }

    handlerHappyEvents(event) {
        this.happyEventsObj = event.detail
    }

    handlerHappyEventsRange(event) {
        this.happyEventsObjRange = event.detail
    }
}
