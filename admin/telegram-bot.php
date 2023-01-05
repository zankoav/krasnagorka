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

        const tg ={
            token: '5949739525:AAED7FFZliBqmxkBuFb0RfFhi271dh7YJIs',
            chat_id: '1001716089662'
        };



        const options = {
            method: 'POST',
            url: `https://api.telegram.org/bot${tg.token}/sendMessage`,
            headers: {accept: 'application/json', 'content-type': 'application/json'},
            data: {
                chat_id: tg.chat_id,
                text: 'Hello',
                parse_mode: 'HTML',
                disable_web_page_preview: false,
                disable_notification: false,
                reply_to_message_id: null
            }
        };


        $('.button-tg').on('click', function(){
            sendMessage(template());

            // axios.request(options)
            //     .then(function (response) {
            //         console.log(response.data);
            //     })
            //     .catch(function (error) {
            //         console.error(error);
            //     });

        });
        const template = () => {
            return encodeURI(`
⚡️ Горящее предложение ⚡️ <a href="https://krasnagorka.by/dom-na-braslavskih-ozyorah/piligrim/"><b>Пилигрим</b></a> ⚡️\n
📌 Комфортный, уютный домик на троих с собственной барбекю зоной и шикарным видом на лес и озеро. Расположен вдали от остальных домов.\n
📆 Даты: <b>06.01.2022</b> - <b>08.01.2022</b>
❤️ Скидка: <b>30%</b>
Стоимость: <b>310 руб.</b> <s>390.00 руб.</s>\n
<a href="https://krasnagorka.by/booking-form/?`) + encodeURIComponent('eventTabId=10654&booking=9486&calendarId=19&from=2023-01-06&to=2023-01-08&terem=Терем%202"') + encodeURI("><b>ЗАБРОНИРОВАТЬ</b></a>");
        }        
        

        function sendMessage(text){ 
            const photo = 'https://krasnagorka.by/wp-content/uploads/2020/05/IMG_8678-2-320x240.jpg';
            let url = `https://api.telegram.org/bot${tg.token}/sendPhoto?chat_id=-${tg.chat_id}&photo=${photo}&caption=${text}&parse_mode=HTML`;
            let xht = new XMLHttpRequest();
            xht.open("GET", url);
            xht.send();
        }
    })(jQuery);
</script>