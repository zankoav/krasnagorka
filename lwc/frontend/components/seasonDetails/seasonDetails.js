import { LightningElement, track, api } from 'lwc';
import './seasonDetails.scss';

export default class SeasonDetails extends LightningElement {
	@api season;
	@api house;

	get targetHouse() {
		return this.season.houses.find(house => house.id == this.house.id);
	}

	get price() {
		return this.targetHouse ? this.targetHouse.price : '';
	}

	get minPricePerDay() {
		const result = parseInt(this.price) * parseInt(this.targetHouse.minPeople);
		return result;
	}

	connectedCallback() {
		console.log('house', this.house);
		console.log('season', this.season);
	}
}