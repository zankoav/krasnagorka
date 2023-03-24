jQuery(document).on('ready', function () {
    const $ = jQuery
    window.CMB2 = (function (window, document, $, undefined) {
        'use strict'

        $('.js-package-link').on('click', function () {
            const packageId = $(this).attr('data-id')
            navigator.clipboard
                .writeText(`https://krasnagorka.by/booking-form/?package=${packageId}`)
                .then(() => {
                    console.log('copied')
                })
                .catch((err) => {
                    console.log('Something went wrong', err)
                })
        })
    })(window, document, jQuery)
})
