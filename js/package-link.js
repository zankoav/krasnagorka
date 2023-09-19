jQuery(document).on('ready', function () {
    const $ = jQuery
    window.CMB2 = (function (window, document, $, undefined) {
        'use strict'

        $('.js-package-link').on('click', function () {
            const packageId = $(this).attr('data-id')
            navigator.clipboard
                .writeText(`https://krasnagorka.by/booking-form/?package-id=${packageId}`)
                .then(() => {
                    console.log('copied')
                })
                .catch((err) => {
                    console.log('Something went wrong', err)
                })
        })

        $('#package_services_repeat')
            .find('.postbox')
            .each(function (index) {
                const id = `#package_services_${index}_service`
                const serviceTitle = $(this).find(id).find('option:selected').text()

                if (serviceTitle) {
                    $(this).find('.cmb-group-title span').text(serviceTitle)
                }
            })

        $('#package_calendars_repeat')
            .find('.postbox')
            .each(function (index) {
                const id = `#package_calendars_${index}_calendar`
                const calendarTitle = $(this).find(id).find('option:selected').text()

                if (calendarTitle) {
                    $(this).find('.cmb-group-title span').text(calendarTitle)
                }
            })
    })(window, document, jQuery)
})
