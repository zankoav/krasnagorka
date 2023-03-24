jQuery(document).on('ready', function () {
    const $ = jQuery
    window.CMB2 = (function (window, document, $, undefined) {
        'use strict'

        $('.js-package-link').on('click', function () {
            console.log('123', 123);
        })
    })(window, document, jQuery)
})
