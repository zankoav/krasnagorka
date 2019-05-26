import './header.scss';
import $ from 'jquery';

$('.burger').on('click', burgerPressed);

function burgerPressed(event) {
    event.preventDefault();
    $(this).toggleClass('burger_active');
    $('.menu').toggleClass('menu_active');
}