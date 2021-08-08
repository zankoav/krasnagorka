import { LightningElement, track, api } from 'lwc';
import './decodingPrice.scss';

export default class DecodingPrice extends LightningElement {
	@api settings;

	get seasons (){
		return Object.values(this.settings.total.seasons_group);
	}
}