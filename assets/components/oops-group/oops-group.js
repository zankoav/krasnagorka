import './oops-group.scss';
import $ from 'jquery';
import {$message} from "../button/button";


$('.oops-group__text, .oops-group__textarea')
    .on('focus', function () {
        let $label = $(this).parent().find('.oops-group__label');
        $label.addClass('oops-group__label_active');
    }).on('blur', function () {

    if ($(this).val() === '') {
        $(this).parent().find('.oops-group__label').removeClass('oops-group__label_active');
    }
}).on('input', function () {
    $message.slideUp();
});
