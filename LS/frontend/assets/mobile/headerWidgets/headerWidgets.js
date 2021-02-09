import './headerWidgets.scss';

const menuButton = document.querySelector('.header-widgets__menu-button-icon');
const contactsButton = document.querySelector('.header-widgets__contacts-button-icon');

menuButton.onclick = () => {
	console.log('menu toggle');
};

contactsButton.onclick = () => {
	console.log('contactsButton toggle');
};