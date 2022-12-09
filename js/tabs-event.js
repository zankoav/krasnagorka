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
                initCalculations()
                initInputHandler()
            }, 500)
        })

        initCalculations()

        function initCalculations() {
            $('#mastak_event_tab_type_10')
                .$('.js-calculate')
                .on('click', function () {
                    const empty_calendar = 'Выберите календарь'
                    const empty_date_from = 'Выберите дату заезда'
                    const empty_date_to = 'Выберите дату выезда'

                    const $parent = $(this).parents('.inside.cmb-field-list')
                    const $message = $(this).parent().parent().find('.cmb2-metabox-description')
                    const $spinner = $(this).parent().find('.spinner')

                    const from = $('#mastak_event_tab_type_10_from').val()
                    const to = $('#mastak_event_tab_type_10_to').val()

                    let $currentPrice
                    const result = {
                        is_admin_event: true,
                        dateFrom: from,
                        dateTo: to
                    }
                    $message.css({ color: '' }).empty()
                    $parent.find('input, select').each(function (index) {
                        const name = $(this).attr('name')

                        if (name) {
                            const calendarId = name.indexOf('[calendar]') > -1
                            const oldPrice = name.indexOf('[old_price]') > -1

                            const peopleCount = 1
                            const food_breakfast = name.indexOf('[food_breakfast]') > -1
                            const food_lunch = name.indexOf('[food_lunch]') > -1
                            const food_dinner = name.indexOf('[food_dinner]') > -1
                            const food_full = name.indexOf('[food_full]') > -1

                            const bath_house_black = name.indexOf('[bath_house_black]') > -1
                            const bath_house_white = name.indexOf('[bath_house_white]') > -1

                            if (oldPrice) {
                                $currentPrice = $(this)
                            }

                            let key
                            if (calendarId) {
                                key = 'calendarId'
                                result[key] = $(this).val()
                            }

                            if (peopleCount) {
                                key = 'peopleCount'
                                result[key] = 1
                            }
                            if (food_breakfast && $(this).is(':checked')) {
                                key = 'foodBreakfast'
                                result[key] = 1
                            }
                            if (food_lunch && $(this).is(':checked')) {
                                key = 'foodLunch'
                                result[key] = 1
                            }
                            if (food_dinner && $(this).is(':checked')) {
                                key = 'foodDinner'
                                result[key] = 1
                            }
                            if (food_full && $(this).is(':checked')) {
                                key = 'foodFull'
                                result['foodBreakfast'] = 1
                                result['foodLunch'] = 1
                                result['foodDinner'] = 1
                            }
                            if (bath_house_black) {
                                key = 'bathHouseBlack'
                                result[key] = $(this).val()
                            }
                            if (bath_house_white) {
                                key = 'bathHouseWhite'
                                result[key] = $(this).val()
                            }
                        }
                    })

                    let error

                    if (!result.calendarId) {
                        error = empty_calendar
                    } else if (!result.dateFrom) {
                        error = empty_date_from
                    } else if (!result.dateTo) {
                        error = empty_date_to
                    }

                    if (error) {
                        $message.css({ color: '#b32d2e;' }).html(error)
                    } else {
                        if (!$spinner.hasClass('spinner_show')) {
                            calculate(result)
                        }
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

        initInputHandler()

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
