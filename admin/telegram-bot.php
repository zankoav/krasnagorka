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
            return `<b>ПИЛИГРИМ</b>"\n"<b>30</b>`;
        }
        

        
        

        function sendMessage(text){ 
            // const url = `https://api.telegram.org/bot${tg.token}/sendMessage
            const url = `https://api.telegram.org/bot${tg.token}/sendMessage?chat_id=-${tg.chat_id}&text=${text}&parse_mode=HTML`; // The url to request

            const xht = new XMLHttpRequest();
            xht.open("GET", url);
            xht.send();
        }
    })(jQuery);
</script>