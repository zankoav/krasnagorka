<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

<div class="wrap">
    <h1 class="wp-heading"><?= get_admin_page_title() ?></h1>
    <bitton class="button button-primary button-large button-tg">
        Отправить объявление
    </button>
</div>

<script>
    (($) => {

        const data = {
            tg: {
                token: '5949739525:AAED7FFZliBqmxkBuFb0RfFhi271dh7YJIs',
                chat_id: '1001716089662'
            },
            photo: 'https://krasnagorka.by/wp-content/uploads/2020/05/IMG_8678-2-320x240.jpg',
            house: {
                link: 'https://krasnagorka.by/dom-na-braslavskih-ozyorah/piligrim/',
                calendar: 'Пилигрим'
            },
            date:{
                from:'06.01.2022',
                to:'08.01.2022'
            },
            sale: 50,
            price: {
                old: 390,
                new: 310
            },
            order_link: 'https://krasnagorka.by/booking-form/?eventTabId=10654&booking=9486&calendarId=19&from=2023-01-06&to=2023-01-08&terem=Терем%202',
            description: 'Комфортный, уютный домик на троих с собственной барбекю зоной и шикарным видом на лес и озеро. Расположен вдали от остальных домов.'
        };
            

        $('.button-tg').on('click', function(){
            sendMessage(data);
        });
        
         const template = (data) => {
            return encodeURIComponent(`
⚡️ <b>Горящее предложение</b> ⚡️ <a href="${data.house.link}"><b>${data.house.calendar}</b></a> ⚡️\n
📌 ${data.description}\n
📆 Даты: <b>${data.date.from}</b> - <b>${data.date.to}</b>\n
❤️ Скидка: <b>${data.sale}%</b>\n
💰 Стоимость: <b>${data.price.new} руб.</b> <s>${data.price.old} руб.</s>\n
👉🏻 <a href="${data.order_link}"><b>ЗАБРОНИРОВАТЬ</b></a>`
            )}

        function sendMessage(data){ 
            const text = template(data);
            let url = `https://api.telegram.org/bot${data.tg.token}/sendPhoto?chat_id=-${data.tg.chat_id}&photo=${data.photo}&caption=${text}&parse_mode=HTML`;
            let xht = new XMLHttpRequest();
            xht.open("GET", url);
            xht.send();
        }

    })(jQuery);
</script>