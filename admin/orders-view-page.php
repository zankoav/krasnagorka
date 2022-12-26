<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

<div class="wrap">
    <h1 class="wp-heading"><?= get_admin_page_title() ?></h1>
    <div class="mt-4 d-flex g-2 g-lg-3 flex-wrap flex-md-nowrap">
        <div class="flex-grow-1">
            <p class="my-0">Даты: <b id="date-from"></b> - <b id="date-to"></b></p>
            <p class="my-0 mb-4">Количество заказов: <b id="order-count"></b></p>
        </div>
        <div class="container-filter">
            <style>
                .filter-button{
                    height: 30px;
                }
                .filter-row.row{
                    border-bottom: 0;
                    width: initial;
                    padding-bottom: initial;
                    float: initial;
                    margin-bottom: 0;
                }

            </style>
            <form class="filter-row row g-2 g-lg-3 row-cols-auto needs-validation flex-wrap flex-md-nowrap mb-4" novalidate>
                <div class="col-12 col-md">
                    <input type="date" placeholder="С" class="form-control form-control-sm" id="from" aria-describedby="validationServerFrom" required>
                    <div id="validationServerFrom" class="invalid-feedback">
                        Укажите корректную дату
                    </div>
                </div>
                <div class="col-12 col-md">
                    <input type="date" placeholder="По" class="form-control form-control-sm" id="to" aria-describedby="validationServerTo" required>
                    <div id="validationServerTo" class="invalid-feedback">
                        Укажите корректную дату
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary btn-sm filter-button">Найти</button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-outline-secondary btn-sm filter-button filter-button__default">По умолчанию</button>
                </div>
                
            </form>
            <div id="liveAlertPlaceholder"></div>
            
            
        </div>
    </div>
    <div id="orders" class="orders"></div>
    <style>
        .fw-bold {
            font-weight: 700;
        }
        #orders {
            color: #212E35;
        }
        .order{
            position: relative;
            overflow: hidden;
            font-size: 12px;
            border-radius: .5rem;
            margin: 1rem 0;
            padding: .5rem .75rem 1.25rem;
            box-shadow: 2px 4px 4px #999;
        }
        @media (min-width:1280px) {
            .order{
                margin: 1.5rem 0;
                font-size: 14px;
                padding: .75rem 1.5rem 1.25rem;
            }
        }
        .order__title{
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        .order__star{
            width: 24px;
            margin-right: 0.5rem;
        }
        @media (min-width:1280px) {
            .order__block-wrapper{
                display: flex;
                max-width:initial;
                margin-left: -0.75rem;
                margin-right: -0.75rem;
            }
            .order__block-wrapper-main{
                padding: 0 .75rem;
                max-width: 75%;
                flex: 1 0 75%;
                display:flex;
                max-width: initial;
                margin-left: -0.75rem;
                margin-right: -0.75rem;
                flex-wrap: wrap;
            }
            .order__block-wrapper-added{
                padding: 0 .75rem;
                max-width: 25%;
                flex: 1 0 25%;
            }
        }
        .order__line{
            border-bottom: 1px dashed #A7ACAF;
            margin-top: 20px;
        }
        @media (min-width:1280px) {
            .order__line{
                display: none;
            }
        }
        .order__block{
            margin-top: 20px;
        }
        @media (min-width:1280px) {
            .order__block_main{
                flex: 1 0 33.333%;
                max-width: 33.333%;
                padding-left:.75rem;
                padding-right:.75rem;
            }
            .order__block_contacts{
                padding-left:.75rem;
                padding-right:.75rem;
            }
        }
        .order-item__title{
            text-align: center;
        }
        @media (min-width:1280px) {
            .order-item__title{
                margin-bottom: .5rem;
            }
        }
        .order-item__list-item{
            display: flex;
            margin-top: .5rem;
            justify-content: space-between;
            border-bottom: 1px dashed #A7ACAF;
        }
        @media (min-width:1280px) {
            .order-item__list-item{
                display: flex;
                margin-top: .25rem;
            }
        }
        .order-contact-line__label,.order-item__list-item-label{
            color: #4D575C;
        }

        .order-item__list-item-label{
            margin-right: 0.25rem;
        }

        @media (min-width:1280px) {
            .order-contact-line__label{
                margin-right: .5rem;
            }
        }
        @media (min-width:1280px) {
            .order-contact-line{
                display: flex;
            }
        }
        .order-contact-line:last-child{
            margin-top: .75rem;
        }
        .loader{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 240px;
            width: 100%;
        }
        .loader__spinner{
            display: inline-block;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-width: 3px;
            border-style: solid;
            border-color: #A7ACAF transparent #A7ACAF #A7ACAF;
            animation: rotate .8s linear infinite;
        }
        @media (min-width:1280px) {
            .loader__spinner{
                width: 48px;
                height: 48px;
                border-width: 4px;
            }
        }
        @keyframes rotate{
            0%{transform: rotate(0);}
            100%{transform: rotate(360deg);}
        }
    </style>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (($) => {
            'use strict'

            let model;

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const form = document.querySelector('.needs-validation');
            form.addEventListener('submit', event => {
                clearAlert();
                const houndriedDayes = 1000 * 60 * 60 * 24 * 100;
                if (form.checkValidity()) {
                    const dateOneValue = document.querySelector('#from').value;
                    const dateTwoValue = document.querySelector('#to').value;
                    const dateOne = new Date(dateOneValue)
                    const dateTwo = new Date(dateTwoValue)
                    if(dateOne.getTime() >= dateTwo.getTime()){
                        alert('Вторая дата должна быть позже первой', 'danger')
                    }else if(dateTwo.getTime() - dateOne.getTime() > houndriedDayes) { //
                        alert('Интервал не может превышать 100 дней', 'danger')
                    }else {
                        sendRequest({from: dateOneValue, to: dateTwoValue});
                    }
                }
                event.preventDefault()
                event.stopPropagation()
                form.classList.add('was-validated')
            }, false)

            document.querySelector('.filter-button__default').addEventListener('click', event => {
                form.reset();
                clearAlert();
                form.classList.remove('was-validated');
                sendRequest({default: true});
            })


            const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
            const clearAlert = () => {
                alertPlaceholder.innerHTML = '';
            }
            const alert = (message, type) => {
                const wrapper = document.createElement('div')
                wrapper.innerHTML = [
                    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                    `   <div>${message}</div>`,
                    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                    '</div>'
                ].join('')

                alertPlaceholder.append(wrapper)
            }

            const startSpinner = ()=>{
                $('#orders').html(`
                    <div class="loader">
                        <div class="loader__spinner"></div>
                    </div>
                `);
            }

            const stopSpinner = ()=>{
                $('#orders').empty();
            }

            const sendRequest = (requestData) => {
                console.log('requestData', requestData);
                startSpinner();
                requestData.action = 'load_orders',
                $.ajax(ajaxurl, {
                    data: requestData,
                    dataType: "json",
                    method: 'post',
                    success: function(response) {
                        model = response;
                        stopSpinner();
                        render();
                    },
                    error: function(x, y, z) {
                        stopSpinner();
                        alert(x,'danger');
                    }
                });
            }

            function render(){
                $('#date-from').html(model.from)
                $('#date-to').html(model.to)
                $('#order-count').html(model.orders.length)
                $('#orders').html(ordersView());
            }

            function ordersView(){
                return model.orders.map((order, index) => {
                    const isTodayOrTomorrow = [model.today, model.tomorrow].indexOf(order.start) > -1 ? '<img src="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/star.svg" alt="star" class="order__star">' : '';
                    const comment = order.comment || '-'; 
                    let foodSectionOrEvent;
                    if(order.eventTitle){
                        foodSectionOrEvent = `
                            <div class="order-item">
                                <div class="order-item__title fw-bold">Мероприятие</div>
                                <div class="order-item__list">
                                    <div class="order-item__list-item">
                                        <div class="order-item__list-item-label">Название:</div>
                                        <div class="order-item__list-item-value">${order.eventTitle}</div>
                                    </div>
                                    <div class="order-item__list-item">
                                        <div class="order-item__list-item-label">Пакет:</div>
                                        <div class="order-item__list-item-value">${order.variantTitle}</div>
                                    </div>
                                    <div class="order-item__list-item">
                                        <div class="order-item__list-item-label">Описание пакета:</div>
                                        <div class="order-item__list-item-value">${order.variantDescription}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }else{
                        foodSectionOrEvent = `
                            <div class="order-item">
                                <div class="order-item__title fw-bold">Питание</div>
                                <div class="order-item__list">
                                    <div class="order-item__list-item">
                                        <div class="order-item__list-item-label">Завтраки:</div>
                                        <div class="order-item__list-item-value">${order.foodBreakfast}</div>
                                    </div>
                                    <div class="order-item__list-item">
                                        <div class="order-item__list-item-label">Обеды</div>
                                        <div class="order-item__list-item-value">${order.foodLunch}</div>
                                    </div>
                                    <div class="order-item__list-item">
                                        <div class="order-item__list-item-label">Ужины:</div>
                                        <div class="order-item__list-item-value">${order.foodDinner}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    return `
                        <div class="order" style="border:5px solid ${order.background};">
                            <div class="order__title">
                                ${isTodayOrTomorrow}
                                <span class="fw-bold">№${index + 1}. ${order.calendars}</span>
                            </div>
                            <div class="order__block-wrapper">
                                <div class="order__block-wrapper-main">
                                    <div class="order__block order__block_main">
                                        <div class="order-item">
                                            <div class="order-item__title fw-bold">Бронь</div>
                                            <div class="order-item__list">
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Заезд:</div>
                                                    <div class="order-item__list-item-value">${order.start}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Выезд:</div>
                                                    <div class="order-item__list-item-value">${order.end}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Человек:</div>
                                                    <div class="order-item__list-item-value">${order.people}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Детей без спального места:</div>
                                                    <div class="order-item__list-item-value">${order.childrenCount}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Статус:</div>
                                                    <div class="order-item__list-item-value">${order.status}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order__block order__block_main">
                                        <div class="order-item">
                                            <div class="order-item__title fw-bold">Оплата</div>
                                            <div class="order-item__list">
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Общая сумма:</div>
                                                    <div class="order-item__list-item-value">${order.total_price} руб.</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Питание:</div>
                                                    <div class="order-item__list-item-value">${order.food} руб.</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Проживание:</div>
                                                    <div class="order-item__list-item-value">${order.accommodationPrice} руб.</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Оплачено:</div>
                                                    <div class="order-item__list-item-value">${order.prepaid} руб.</div>
                                                </div>
                                                <div class="order-item__list-item fw-bold">
                                                    <div class="order-item__list-item-label">Остаток:</div>
                                                    <div class="order-item__list-item-value">${order.total_price - order.prepaid} руб.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order__block order__block_main">
                                        ${foodSectionOrEvent}
                                    </div>
                                    <div class="order__block order__block_contacts">
                                        <div class="order-contact-line">
                                            <div class="order-contact-line__label fw-bold">Контакт:</div>
                                            <div class="order-contact-line__value">${order.contact}</div>
                                        </div>
                                        <div class="order-contact-line">
                                            <div class="order-contact-line__label fw-bold">Комментарий:</div>
                                            <div class="order-contact-line__value">${comment}</div>
                                        </div>
                                    </div>
                                    <div class="order__line"></div>
                                </div>
                                <div class="order__block-wrapper-added">
                                    <div class="order__block">
                                        <div class="order-item">
                                            <div class="order-item__title fw-bold">Дополнительные услуги</div>
                                            <div class="order-item__list">
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Бани по белому:</div>
                                                    <div class="order-item__list-item-value">${order.services.bath_house_white}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Бани по черному:</div>
                                                    <div class="order-item__list-item-value">${order.services.bath_house_black}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Мелкие животные:</div>
                                                    <div class="order-item__list-item-value">${order.services.small_animlas_count}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Крупные животные:</div>
                                                    <div class="order-item__list-item-value">${order.services.big_animlas_count}</div>
                                                </div>
                                                <div class="order-item__list-item">
                                                    <div class="order-item__list-item-label">Детская кроватка:</div>
                                                    <div class="order-item__list-item-value">${order.services.baby_bed}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }

            startSpinner();
            sendRequest({default: true});

        })(jQuery)
    </script>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
