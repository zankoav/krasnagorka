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
            sendMessage('Всем привет');
        });

        const tg ={
            token: '5949739525:AAED7FFZliBqmxkBuFb0RfFhi271dh7YJIs',
            chat_id: '1001716089662'
        };


        function sendMessage(text){ 
            const url = `https://api.telegram.org/bot${tg.token}/sendMessage?chat_id=-${tg.chat_id}&text=${text}`; // The url to request
            const xht = new XMLHttpRequest();
            xht.open("GET", url);
            xht.send();
        }
    })(jQuery);
</script>