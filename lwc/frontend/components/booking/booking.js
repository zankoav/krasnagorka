import { LightningElement, api } from "lwc";
import "./booking.scss";

export default class BookingForm extends LightningElement {

	@api model;

	async skip() {
		await new Promise((resolve) => setImmediate(resolve));
	}

	async connectedCallback() {
        console.log('model', this.model);
    }
}