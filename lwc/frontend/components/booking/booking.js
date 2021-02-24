import { LightningElement, api, track } from "lwc";
import "./booking.scss";

export default class BookingForm extends LightningElement {

	@api settings;

    get isHouseStep(){
        return this.settings.menu[0].active;
    }

    get isDateStep(){
        return this.settings.menu[1].active;
    }

    get isContactStep(){
        return this.settings.menu[2].active;
    }

    get isCheckoutStep(){
        return this.settings.menu[3].active;
    }
}