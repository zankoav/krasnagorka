<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

<div class="wrap">
    <h1 class="wp-heading"><?= get_admin_page_title() ?></h1>
    <bitton class="button button-primary button-large button-tg">
        Отправить объявление
    </button>
</div>

<script>
    (($) => {
        $('.button-tg').on('click', function(){
            sendMessage(template());
        });

        const template = () => {
            return `
                <a href="https://krasnagorka.by/wp-content/uploads/2020/05/IMG_8678-2-300x420.jpg"></a>
                <b>ПИЛИГРИМ</b>
                Скидка: <b>30 %</b>
                Цена: <b>100 руб.</b> <s>120 руб.</s>
                <p>Уютный домик на двоих около причала со всем необходимым: мини-туалет, мини-душ, мини-спальня, мини-кухня, мини-терраса :)</p>
                c 06.01 по 08.01
                <a href="https://krasnagorka.by/booking-form/?eventTabId=10654&booking=12979&calendarId=43&from=2023-01-06&to=2023-01-08">Забронировать</a>
            `;
        }
        

        const tg ={
            token: '5949739525:AAED7FFZliBqmxkBuFb0RfFhi271dh7YJIs',
            chat_id: '1001716089662'
        };


        function sendMessage(text){ 
            const url = `https://api.telegram.org/bot${tg.token}/sendMessage?chat_id=-${tg.chat_id}&text=${text}&parse_mode=HTML`; // The url to request
            const xht = new XMLHttpRequest();
            xht.open("GET", url);
            xht.send();
        }
    })(jQuery);
</script>