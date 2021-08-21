import { LightningElement, api } from 'lwc';
import './seasonDetails.scss';

export default class SeasonDetails extends LightningElement {
	@api season;
	@api house;

	connectedCallback(){
		console.log('targetHouse',this.targetHouse);
	}

	get targetHouse() {
		return this.season.houses.find(house => {
			let result = house.id == this.house.id;
			if(house.isTerem){
				result = house.id == this.house.calendarId;
			}
			return result;
		});
	}

	get price() {
		const price = parseInt(this.targetHouse.price);
		return isNaN(price) ? null : price;
	}

	get minPricePerDay() {
		const result = parseInt(this.price) * parseInt(this.targetHouse.minPeople);
		return isNaN(result) ? null : result;
	}

	get minDays() {
		return this.targetHouse.minDays;
	}
}