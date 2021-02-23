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

    nextStep(){
        // let targetIndex = 0;
        // this.menuItems.forEach((element, index) => {
        //     if(element.value === this.menuCurrentItem){
        //         targetIndex = index + 1;
        //     }
        // });
        // targetIndex = targetIndex >= this.menuItems.length ? 
        //             this.menuItems.length - 1 : 
        //             targetIndex;

        // this.menuCurrentItem = this.menuItems[targetIndex].value;
    }

    backStep(){
        // let targetIndex = this.menuItems.length - 1;
        // this.menuItems.forEach((element, index) => {
        //     if(element.value === this.menuCurrentItem){
        //         targetIndex = index;
        //     }
        // });
        // targetIndex = targetIndex === 0 ? 
        //             0 : 
        //             targetIndex - 1;

        // this.menuCurrentItem = this.menuItems[targetIndex].value;
    }

}