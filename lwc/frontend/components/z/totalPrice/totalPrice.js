import BaseBookingElement from 'base/baseBookingElement'
import './totalPrice.scss'

export default class TotalPrice extends BaseBookingElement {
    isOpenTotalPrice

    get totalPrice() {
        return this.currencyModel(this.settings.total.total_price)
    }

    get classNameMore() {
        return this.isOpenTotalPrice
            ? 'total-price__more total-price__more_active'
            : 'total-price__more'
    }

    get decodingPriceClass() {
        return this.isOpenTotalPrice
            ? 'total-price__decoding-price-wrapper total-price__decoding-price-wrapper_open'
            : 'total-price__decoding-price-wrapper'
    }

    get decodingPriceHidden() {
        return !this.isOpenTotalPrice
    }

    get prepaidPrice() {
        return !this.settings.payment || this.settings.prepaidType == 100
            ? null
            : this.currencyModel(
                  (this.settings.total.total_price * this.settings.prepaidType) / 100
              )
    }

    get onlyBookingEnabled() {
        return this.settings.total.only_booking_order?.enabled
    }

    tooglePrice() {
        this.isOpenTotalPrice = !this.isOpenTotalPrice
    }
}
