import { LightningElement, api } from 'lwc';
import './priceView.scss';

export default class PriceView extends LightningElement {
	@api rub;
	@api penny;
	@api currency = 'руб';
}