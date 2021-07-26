import { LightningElement, track, api } from 'lwc';
import './numberValue.scss';

export default class NumberValue extends LightningElement {
	@api num;
	@api value;
}