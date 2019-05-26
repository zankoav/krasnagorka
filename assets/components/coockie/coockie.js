import './coockie.scss';
import $ from 'jquery';


// $(document).ready(function () {
//     let height = $('.coockie').show().height() + 40;
//     $('.coockie').hide().slideDown(600);
//     $(".app").css({marginTop: height});
//     $(".menu__burger").css({top: height});
//
// });
$('.coockie__close').on('click', function (event) {
    event.preventDefault();
    $('.coockie').slideUp(600, function () {
        $('.coockie').remove();
    });
    // $(".menu__burger").removeAttr('style');
    // $(".app").removeAttr('style');
});