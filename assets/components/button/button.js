import './button.scss';
import $ from 'jquery';
import {Validator} from "../../utils/_validator";

let $button = $('.button');
let $title = $('.contact-form__title');
let $successIcon = $('.contact-form__success-icon');


let $contactForm = $($button.parent());
export const $message = $contactForm.find('.contact-form__message');
let $userName = $contactForm.find('[name=user-name]');
let $userEmail = $contactForm.find('[name=user-email]');
let $userMessage = $contactForm.find('[name=user-message]');
let $spamMessage = $contactForm.find('[name=message]');

let name = '',
    email = '',
    message = '';

$button.on('click', submitPressed);

function submitPressed() {

    name = $userName.val();
    email = $userEmail.val();
    message = $userMessage.val();

    if (name === '') {
        $userName.focus();
        $message.html('Please fill in your name.').slideDown();
        return;
    }

    if (!Validator.email(email)) {
        $userEmail.focus();
        $message.html('Please fill in your email.').slideDown();
        return;
    }

    if (message === '') {
        $userMessage.focus();
        $message.html('Please fill in your message.').slideDown();
        return;
    }

    sendData({
        name: name,
        email: email,
        message: message,
        spam: $spamMessage.val()
    });

};

function sendData(data) {
    try {
        data['action'] = 'contact_form';
        $.ajax(landing_ajax.url, {
            data: data,
            method: 'post',
            dataType: 'json',
            success: function (response) {
                if (response.status == 1) {
                    success();
                } else {
                    error();
                }
            },
            error: function () {
                error();
            }
        });
        $('.button').html('Sending...').off('click');
    } catch (error) {
        console.log(error);
        alert('Error! Variable landing_ajax is not defined');
    }


}

function showForm() {
    $('.contact-form__form').fadeOut(function () {
        $title.html('');
        $contactForm.removeClass('contact-form__form_success');
        $button.off('click', showForm).html('Send').on('click', submitPressed);
        $('.contact-form__form').fadeIn();
    });
}

function success() {
    $('.contact-form__form').fadeOut(function () {
        $successIcon.removeClass('fa-times-circle');
        $successIcon.addClass('fa-check-circle');
        $title.html('Everything is OK! Message send.');

        $contactForm.addClass('contact-form__form_success');
        $contactForm[0].reset();
        $contactForm.find('.oops-group__label').removeClass('oops-group__label_active');
        $contactForm.find('.oops-group__line')
            .css({
                '-webkit-transform': 'scaleX(0)',
                '-moz-transform': 'scaleX(0)',
                '-ms-transform': 'scaleX(0)',
                '-o-transform': 'scaleX(0)',
                'transform': 'scaleX(0)'
            });
        $button.html('Send again').on('click', showForm);
        $('.contact-form__form').fadeIn();
    });
}

function error() {
    $('.contact-form__form').fadeOut(function () {
        $successIcon.addClass('fa-times-circle');
        $successIcon.removeClass('fa-check-circle');
        $title.html('Error connection.<br> Please try again later.');
        $contactForm.addClass('contact-form__form_success');
        $contactForm[0].reset();
        $contactForm.find('.oops-group__label').removeClass('oops-group__label_active');
        $contactForm.find('.oops-group__line')
            .css({
                '-webkit-transform': 'scaleX(0)',
                '-moz-transform': 'scaleX(0)',
                '-ms-transform': 'scaleX(0)',
                '-o-transform': 'scaleX(0)',
                'transform': 'scaleX(0)'
            });
        $button.html('Try again').on('click', showForm);
        $('.contact-form__form').fadeIn();
    });
}