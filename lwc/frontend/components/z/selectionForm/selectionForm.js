import { LightningElement, track, api } from 'lwc';
import './selectionForm.scss';

export default class SelectionForm extends LightningElement {

	@api season;


	get cssClasses() {
		return this.season.current ? "selection-form selection-form_active" : "selection-form";
	}

	itemPressed() {
		if (!this.season.current) {
			this.dispatchEvent(
				new CustomEvent('changeseason', {
					detail: this.season.id,
					bubbles: true,
					composed: true
				})
			);
		}
	}

}