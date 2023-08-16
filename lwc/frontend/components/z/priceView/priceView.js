import { LightningElement, api } from 'lwc';
import './priceView.scss';

export default class PriceView extends LightningElement {
	@api price;
	@api currency = 'руб';
}