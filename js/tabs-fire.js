jQuery(document).on('ready', function () {
    const $ = jQuery
    window.CMB2 = (function (window, document, $, undefined) {
        'use strict'

        // Set background color for events
        $('#cmb2-metabox-mastak_event_tab_type_8')
            .find('.postbox')
            .each(function (index) {
                const state = orderedIds[index]
                const id = `#mastak_event_tab_type_8_items_${index}_calendar`
                const $calendar = $(this).find(id)
                const title = $($calendar[0]).find('option:selected').text()
                if (title) {
                    $(this).find('.cmb-group-title').text(title)
                }
                if (state && $calendar[0] && $calendar[0].value == state.calendar) {
                    $(this).addClass(`bgc-${state.status}`)
                    $(this).find('.cmb-group-title').addClass(`bgc-${state.status}`)
                }
            })

        // START calculate process
        $('.cmb-add-group-row').on('click', function () {
            setTimeout(() => {
                $('#mastak_event_tab_type_8 .js-calculate').off('click')
                $('#mastak_event_tab_type_8 .js-telegram').off('click')
                $('#mastak_event_tab_type_8 .js-telegram-copy').off('click')
                initCalculations()
                initTelegram()
            }, 500)
        })

        initCalculations()

        function initCalculations() {
            $('#mastak_event_tab_type_8 .js-calculate').on('click', function () {
                const empty_calendar = 'Выберите календарь'
                const empty_date_from = 'Выберите дату заезда'
                const empty_date_to = 'Выберите дату выезда'

                const $parent = $(this).parents('.inside.cmb-field-list')
                const $message = $(this).parent().parent().find('.cmb2-metabox-description')
                const $spinner = $(this).parent().find('.spinner')
                let $currentPrice
                const result = { is_admin_event: true }
                $message.css({ color: '' }).empty()
                $parent.find('input, select').each(function (index) {
                    const name = $(this).attr('name')

                    if (name) {
                        const dateFrom = name.indexOf('[from]') > -1
                        const dateTo = name.indexOf('[to]') > -1
                        const calendarId = name.indexOf('[calendar]') > -1
                        const oldPrice = name.indexOf('[old_price]') > -1

                        if (oldPrice) {
                            $currentPrice = $(this)
                        }

                        let key
                        if (calendarId) {
                            key = 'calendarId'
                        }
                        if (dateFrom) {
                            key = 'dateFrom'
                        }
                        if (dateTo) {
                            key = 'dateTo'
                        }

                        if (key) {
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
                        $currentPrice.val(responseData.accommodation_price)
                        $spinner.removeClass('spinner_show')
                    }
                }
            })
            $('#mastak_event_tab_type_8 .js-telegram-copy').on('click', function () {
                const $parent = $(this).parents('.inside.cmb-field-list')
                const iframe = $parent.find('iframe')[0]
                let text = getIframeBodyContent(iframe)
                console.log('text ===', text)
                // text = text.replace(/<\/p>/g, '\n').replace(/<p>/g, '').trim()
                const $targetPlace = $parent.find('textarea')
                $targetPlace.val(text)
            })
        }

        function getIframeBodyContent(iframe) {
            // Check for same-origin policy limitations
            if (iframe.contentWindow.document) {
                const iframeDocument = iframe.contentWindow.document
                const iframeBodyHTML = iframeDocument.body.innerText
                return iframeBodyHTML
            } else {
                console.error('Cannot access iframe content due to same-origin policy.')
                return null
            }
        }

        initInputHandler()

        function initInputHandler() {
            $('#mastak_event_tab_type_8_items_repeat')
                .find('.cmb-repeatable-grouping')
                .each(function (index) {
                    const $oldPrice = $(this).find(
                        `#mastak_event_tab_type_8_items_${index}_old_price`
                    )
                    const $newPrice = $(this).find(
                        `#mastak_event_tab_type_8_items_${index}_new_price`
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
        // END calculate process

        // START Telegram
        initTelegram()

        function initTelegram() {
            $('#mastak_event_tab_type_8 .js-telegram').on('click', async function () {
                const empty_calendar = 'Выберите календарь'
                const empty_date_from = 'Выберите дату заезда'
                const empty_date_to = 'Выберите дату выезда'
                const empty_tg_description = 'Заполните текст для Телеграма'

                const $parent = $(this).parents('.inside.cmb-field-list')
                const $message = $(this).parent().parent().find('.cmb2-metabox-description')
                const $spinner = $(this).parent().find('.spinner')

                const result = { postId: postId }
                $message.css({ color: '' }).empty()
                $parent.find('input, select, textarea').each(function (index) {
                    const name = $(this).attr('name')
                    const className = $(this).attr('class')

                    if (name) {
                        const dateFrom = name.indexOf('[from]') > -1
                        const dateTo = name.indexOf('[to]') > -1
                        const calendarId = name.indexOf('[calendar]') > -1
                        const oldPrice = name.indexOf('[old_price]') > -1
                        const newPrice = name.indexOf('[new_price]') > -1
                        const tgDescription = name.indexOf('[tg_description]') > -1

                        let key
                        if (calendarId) {
                            key = 'calendarId'
                        }
                        if (dateFrom) {
                            key = 'dateFrom'
                        }
                        if (dateTo) {
                            key = 'dateTo'
                        }
                        if (oldPrice) {
                            key = 'oldPrice'
                        }
                        if (newPrice) {
                            key = 'newPrice'
                        }
                        if (tgDescription) {
                            key = 'tg_description'
                        }
                        if (key) {
                            result[key] = $(this).val()
                        }
                    }

                    if (className == 'TG') {
                        result.index = $(this).val()
                    }
                })

                let error

                if (!result.calendarId) {
                    error = empty_calendar
                } else if (!result.dateFrom) {
                    error = empty_date_from
                } else if (!result.dateTo) {
                    error = empty_date_to
                } else if (!result.tg_description) {
                    error = empty_tg_description
                }

                if (error) {
                    $message.css({ color: '#b32d2e;' }).html(error)
                } else {
                    if (!$spinner.hasClass('spinner_show')) {
                        const data = await getData(result)
                        sendMessage(data)
                    }
                }

                async function getData(tabItem) {
                    $spinner.addClass('spinner_show')
                    const response = await fetch(
                        'https://krasnagorka.by/wp-json/krasnagorka/v1/ls/telegram/',
                        {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json; charset=utf-8'
                            },
                            body: JSON.stringify(tabItem)
                        }
                    )
                    return await response.json()
                }

                function tgTemplate(data) {
                    return encodeURIComponent(`
⚡️ <b>Горящее предложение</b> ⚡️ <a href="${data.house.link}"><b>${data.house.calendar}</b></a> ⚡️\n
📌 ${data.description}\n
👨‍👩‍👧‍👦 Вместимость: <b>${data.house.sale_text}</b>\n
📆 Даты: <b>${data.date.from}</b> - <b>${data.date.to}</b>\n
❤️ Скидка: <b>${data.sale}%</b>\n
💰 Общая стоимость: <b>${data.price.new} руб.</b> <s>${data.price.old} руб.</s>\n
💰 Стоимость за ночь: <b>${data.price.per_night_new} руб.</b> <s>${data.price.per_night_old} руб.</s>\n
👉🏻 <a href="${data.order_link}"><b>ЗАБРОНИРОВАТЬ</b></a>`)
                }

                function sendMessage(data) {
                    if (data.house.is_terem) {
                        data.house.calendar = data.house.calendar.replace(' ', ' №')
                    }
                    const text = tgTemplate(data)
                    let url = `https://api.telegram.org/bot${data.tg.token}/sendPhoto?chat_id=-${data.tg.chat_id}&photo=${data.photo}&caption=${text}&parse_mode=HTML`
                    let xhr = new XMLHttpRequest()
                    xhr.open('GET', url)
                    xhr.send()
                    $spinner.removeClass('spinner_show')
                    if (xhr.status != 200) {
                        $spinner.removeClass('spinner_show')
                    }
                }
            })
        }
        // END Telegram
    })(window, document, jQuery)
})
