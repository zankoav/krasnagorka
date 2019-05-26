import './menu-left.scss';
import $ from 'jquery';


let $menu = $('.menu-left__list');

$('.menu-left__active-item').on('click', function () {
    let $button = $(this);
    $(this).toggleClass('menu-left__active-item_active');
    $menu.slideToggle(function () {
        if (!$button.hasClass('menu-left__active-item_active')) {
            $(this).removeAttr('style');
        }
    });
});