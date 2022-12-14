jQuery(document).on('ready', function () {
    const $ = jQuery
    $('#cmb2-metabox-mastak_event_tab_type_10')
        .find('.postbox')
        .each(function (index) {
            const state = orderedIds[index]
            const id = `#mastak_event_tab_type_10_items_${index}_calendar`
            const $calendar = $(this).find(id)
            if (state && $calendar[0] && $calendar[0].value == state.calendar) {
                $(this).addClass(`bgc-${state.status}`)
                $(this).find('.cmb-group-title').addClass(`bgc-${state.status}`)
            }
        })

    window.CMB2 = (function (window, document, $, undefined) {
        'use strict'

        $('.cmb-add-group-row').on('click', function () {
            setTimeout(() => {
                $('#mastak_event_tab_type_10 .js-calculate').off('click')
                initCalculations()
                // initInputHandler()
            }, 500)
        })

        initCalculations()

        function initCalculations() {
            $('#mastak_event_tab_type_10 .js-calculate').on('click', function () {
                const $parent = $(this).parents('.cmb-row.cmb-repeatable-grouping')
                const $currentPrice = $parent.find("[name$='[old_price]']")
                const $message = $(this).parent().parent().find('.cmb2-metabox-description')
                const $spinner = $(this).parent().find('.spinner')

                const intervallId = $('#mastak_event_tab_type_10_interval').val()
                const calendarId = $parent.find("[name$='[calendar]']").val()

                const result = {
                    is_admin_event: true,
                    peopleCount: 1,
                    intervallId: intervallId,
                    calendarId: calendarId
                }

                $message.css({ color: '' }).empty()

                if (!$spinner.hasClass('spinner_show')) {
                    console.log('result', result)
                    // calculate(result)
                }

                async function calculate(data) {
                    $spinner.addClass('spinner_show')
                    const response = await fetch(
                        'https://krasnagorka.by/wp-json/krasnagorka/v1/ls/calculate/',
                        {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json; charset=utf-8'
                            },
                            body: JSON.stringify(data)
                        }
                    )
                    const responseData = await response.json()
                    if (responseData) {
                        $currentPrice.val(responseData.total_price)
                        $spinner.removeClass('spinner_show')
                    }
                }
            })
        }

        // initInputHandler()

        function initInputHandler() {
            $('#mastak_event_tab_type_10_items_repeat')
                .find('.cmb-repeatable-grouping')
                .each(function (index) {
                    const $oldPrice = $(this).find(
                        `#mastak_event_tab_type_10_items_${index}_old_price`
                    )
                    const $newPrice = $(this).find(
                        `#mastak_event_tab_type_10_items_${index}_new_price`
                    )
                    const $calculatePercent = $(this).find(`.calculate-percent`)

                    $newPrice.on('input', setSale)
                    $oldPrice.on('input', setSale)

                    function setSale() {
                        const newPrice = parseInt($newPrice.val())
                        const oldPrice = parseInt($oldPrice.val())
                        if (!isNaN(oldPrice) && !isNaN(newPrice)) {
                            $calculatePercent.html(
                                parseInt(100 - (newPrice * 100) / oldPrice) + ' %'
                            )
                        } else {
                            $calculatePercent.empty()
                        }
                    }

                    setSale()
                })
        }
    })(window, document, jQuery)
})
