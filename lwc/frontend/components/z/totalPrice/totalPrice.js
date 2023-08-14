import BaseBookingElement from 'base/baseBookingElement'
import './totalPrice.scss'

export default class TotalPrice extends BaseBookingElement {
    isOpenTotalPrice

    get totalPrice() {
        return this.currencyModel(this.settings.total.total_price);
    }

    get classNameMore() {
        return this.isOpenTotalPrice
            ? 'total-price__more total-price__more_active'
            : 'total-price__more'
    }

    get prepaidPrice() {
        const prepaid = parseInt(
            (this.settings.total.total_price * this.settings.prepaidType) / 100
        )
        return prepaid == parseInt(this.settings.total.total_price) ? null : prepaid
    }

    get onlyBookingEnabled() {
        return this.settings.total.only_booking_order?.enabled
    }

    tooglePrice() {
        this.isOpenTotalPrice = !this.isOpenTotalPrice
    }
}
