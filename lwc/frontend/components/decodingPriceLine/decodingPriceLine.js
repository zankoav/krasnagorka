import { LightningElement, api } from 'lwc';
import './decodingPriceLine.scss';

export default class DecodingPrice extends LightningElement {
	@api season;

	get needBreakets(){
		return (
			this.season.price_block.base_price_without_upper || 
			this.season.price_block.people_sale || 
			this.season.price_block.days_sale
		);
	}
	
	get price(){
		return this.season.price_block.base_price_without_upper ? this.season.price_block.base_price_without_upper : this.season.price_block.base_price;
	}
}