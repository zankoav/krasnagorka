import { LightningElement, track, api } from 'lwc';
import './seasonDetails.scss';

export default class SeasonDetails extends LightningElement {
	@api season;
	@api house;

	get targetHouse() {
		return this.season.houses.find(house => house.id == this.house.id);
	}

	get price() {
		return parseInt(this.targetHouse.price);
	}

	get minPricePerDay() {
		const result = parseInt(this.price) * parseInt(this.targetHouse.minPeople);
		return result;
	}

	get minDays() {
		return this.targetHouse.minDays;
	}
}