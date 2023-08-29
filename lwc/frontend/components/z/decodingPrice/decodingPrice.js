import BaseBookingElement from 'base/baseBookingElement'
import './decodingPrice.scss'

export default class DecodingPrice extends BaseBookingElement {
    get priceChild() {
        return this.currencyModel(this.settings.eventModel.price_child)
    }

    get pricePeople() {
        return this.currencyModel(this.settings.eventModel.price_people)
    }

    get babyBedPrice() {
        return this.currencyModel(this.settings.total.baby_bed.price)
    }

    get babyBedTotalPrice() {
        return this.currencyModel(this.settings.total.baby_bed.total_price)
    }

    get bathHouseBlackPrice() {
        return this.currencyModel(this.settings.total.bath_house_black.price)
    }

    get bathHouseBlackTotalPrice() {
        return this.currencyModel(this.settings.total.bath_house_black.total_price)
    }

    get bathHouseWhitePrice() {
        return this.currencyModel(this.settings.total.bath_house_white.price)
    }

    get bathHouseWhiteTotalPrice() {
        return this.currencyModel(this.settings.total.bath_house_white.total_price)
    }

    get foodBreakfastPrice() {
        return this.currencyModel(this.settings.total.food.breakfast.price)
    }

    get foodBreakfastTotalPrice() {
        return this.currencyModel(this.settings.total.food.breakfast.total_price)
    }

    get foodLunchPrice() {
        return this.currencyModel(this.settings.total.food.lunch.price)
    }

    get foodLunchTotalPrice() {
        return this.currencyModel(this.settings.total.food.lunch.total_price)
    }

    get foodLunchTotalPrice() {
        return this.currencyModel(this.settings.total.food.lunch.total_price)
    }

    get foodDinnerPrice() {
        return this.currencyModel(this.settings.total.food.dinner.price)
    }

    get foodDinnerTotalPrice() {
        return this.currencyModel(this.settings.total.food.dinner.total_price)
    }

    get foodTotalPrice() {
        return this.currencyModel(this.settings.total.food.total_price)
    }

    get foodSale() {
        return this.currencyModel(this.settings.total.food.sale)
    }

    get showSeasonsDecoding() {
        return !this.settings.eventTabId && !this.isPackage
    }

    get totalPrice() {
        return this.currencyModel(this.settings.total.total_price)
    }

    get showEventChilds() {
        return this.settings.eventModel.childs
    }

    get subTitle() {
        let result = 'Проживание'
        if (this.isPackage) {
            result = 'Проживание по пакетному туру'
        } else if (this.isEvent) {
            result = 'Мероприятие'
        } else if (this.isFier) {
            result = 'Проживание по горящему туру'
        }
        return result
    }

    get otherScenarios() {
        return !this.isPackage && !this.isEvent
    }

    get displayServices() {
        return (
            this.settings.total.baby_bed ||
            this.settings.total.bath_house_black ||
            this.settings.total.bath_house_white
        )
    }

    get displayFood() {
        return (
            this.settings.total.food?.breakfast?.total_price ||
            this.settings.total.food?.dinner?.total_price ||
            this.settings.total.food?.lunch?.total_price
        )
    }

    get needBreakets() {
        return (
            this.season.price_block.min_percent ||
            this.season.price_block.people_sale ||
            this.season.price_block.days_sale
        )
    }

    get price() {
        return this.season.price_block.min_percent
            ? this.season.price_block.base_price_without_upper
            : this.season.price_block.base_price
    }

    get seasons() {
        return Object.values(this.settings.total.seasons_group)
    }

    get addedServicesTotalPrice() {
        let total = 0
        if (this.settings.total.baby_bed?.total_price) {
            total += this.settings.total.baby_bed?.total_price
        }
        if (this.settings.total.bath_house_black?.total_price) {
            total += this.settings.total.bath_house_black?.total_price
        }
        if (this.settings.total.bath_house_white?.total_price) {
            total += this.settings.total.bath_house_white?.total_price
        }
        return this.currencyModel(total)
    }

    get houseTotalPrice() {
        let total = 0
        if (this.settings.total?.accommodation) {
            total = this.settings.total.accommodation
        } else {
            for (let key in this.settings.total.seasons_group) {
                total += this.settings.total.seasons_group[key].price_block.total
                const small_animals_total =
                    this.settings.total.seasons_group[key].price_block.small_animals_total
                const big_animals_total =
                    this.settings.total.seasons_group[key].price_block.big_animals_total

                if (small_animals_total) {
                    total += small_animals_total
                }
                if (big_animals_total) {
                    total += big_animals_total
                }
            }
        }

        return this.currencyModel(total)
    }
}
