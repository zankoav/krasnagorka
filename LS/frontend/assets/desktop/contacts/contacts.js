import './contacts.scss';

const 	button = document.querySelector('.contacts__link'),
		popup = document.querySelector('.contacts__popup');

button.onclick = () =>{
	popup.classList.toggle('contacts__popup_active');
};