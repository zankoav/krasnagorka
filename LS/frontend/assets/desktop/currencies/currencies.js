import './currencies.scss';
import {setCookie} from './../utils/utils';

const current = document.querySelector('.currencies__current'),
	list = document.querySelector('.currencies__list');

current.onclick = () =>{
	list.classList.toggle('currencies__list_active');
}

list.querySelectorAll('.currencies__item').forEach(item => {
	item.addEventListener('click', changeCurrency.bind(item));
});

function changeCurrency(){
	const currency = this.dataset.currency;
	const newFlag = this.querySelector('img').cloneNode(true);
	const oldFlag = current.querySelector('img');
	current.replaceChild(newFlag,oldFlag);
	current.dataset.currency = currency;
	setCookie('currency', currency);
	current.click();
	document.location.reload();
}