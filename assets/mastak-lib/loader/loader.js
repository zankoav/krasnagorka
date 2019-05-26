import $ from 'jquery';

const JS_IMG_CLASS = 'js-img';

let $loader = $('.loader');
let $body = $('body');

let loadingImages = document.getElementsByClassName(JS_IMG_CLASS);
let count = loadingImages.length;
$(document).ready(showContent);


for (let i = 0; i < loadingImages.length; i++) {
    loadingImages[i].onload = imageLoaded;
    loadingImages[i].src = $(loadingImages[i]).data('src');
}

function imageLoaded() {
    count--;
    showContent();

}

function showContent() {
    if (count === 0) {
        stopLoading();
    }
}

export function stopLoading(event) {
    $body.removeClass('body_overflow_hidden');
    $loader.fadeOut(function () {
        $(this).remove();
        if(typeof event === 'function'){
            event();
        }
    });
}

export function startLoading() {
    $body.addClass('body_overflow_hidden');
    $body.prepend($loader);
    $loader.fadeIn();
}