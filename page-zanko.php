<?php

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    use AmoCRM\Models\LeadModel;
    use AmoCRM\Collections\Leads\LeadsCollection;
    use AmoCRM\Client\AmoCRMApiClient;
    use League\OAuth2\Client\Token\AccessTokenInterface;
    use AmoCRM\Exceptions\AmoCRMApiException;
    use AmoCRM\Collections\TagsCollection;
    use AmoCRM\Models\TagModel;
    use AmoCRM\Filters\ContactsFilter;
    use AmoCRM\Models\ContactModel;
    use AmoCRM\Collections\LinksCollection;
    use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
    use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
    use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;



    if (!defined('ABSPATH')) {
        exit;
    }?>


    <h1>Hello Alexandr</h1>
    <p>Testing ...</p>

    <?php
        $clientId = '79aac717-18fc-4495-8a5f-7124a70de05d';
        $clientSecret = 'h1MPktXuLLrCPrEneoFP7kh2rlVllzaxkzfivOK2xWzOTxFHqtIu26VDUIaEyOpG';
        $redirectUri = 'https://krasnagorka.by';
        $code = 'def502000fbd47b384ca66f1c806a90c0255d176b3c774243eeb100a7858487c3adfbb5e1725fe2ac5a779ec5df93953672838939dd5dafcf89e87cdce028d68eae1760655eceb4a020e3c42020e654fe5fd50f59e0102a07098677a661c81ca3ad30e28b63c88075a06158fb074b0e93d7cc0b4801943c43afcf3059acef227bec274b75c7757ddee960384eaee4502c12f7717bb9d3ac583466564044e9c5976d4ee42a741a449266475f6086ea0ff3dfd9adc2f1c2f5dd750661d69d15b343898bad73e9fcfb2e484e2a0fcab0f4616988a5d192cd44de662154ea62ed486ee7f6fea0bf30114a358e21452a7a8f3cf2f35718e1607075634fe55a3ae2b85961583b698eec38a24173d398b665a6c23e7a91a0adb5e8705b926119c8218fee68647020f2e40e8382eff50fbf35a29748c73593c23a0793bebca23f80cb8108adbda27b7dcbe61ce47020bf811d3c58dc371906fc9ccf124d400bc91642ae58ece09c82ac1f337a5f95ceb16db9b6dc29baca9ff4753a577349917b155e123a2be6fe1d01693bfc9a616e71948e23a47c1eb31c3c9dac1e89b4515dc30cb5aa2b988368a3a2f31513b6a14612fae888db801ddb5b07a2a622cb9b87b28196c';
        $link = 'https://krasnogorka.amocrm.ru/oauth2/access_token';

        if ( ! class_exists( '\AmoCRM\Client\AmoCRMApiClient' ) ) 
            return;

        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $accessToken = getToken();
        $apiClient
            ->setAccountBaseDomain('krasnogorka.amocrm.ru')
            ->setAccessToken($accessToken)
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    saveToken(
                        [
                            'access_token' => $accessToken->getToken(),
                            'refresh_token' => $accessToken->getRefreshToken(),
                            'expires_in' => $accessToken->getExpires(),
                            'baseDomain' => $baseDomain,
                        ]
                    );
                });


        // try {
        //     $request = $apiClient->getRequest();
        //     $queryResult = $request->get('api/v4/leads');
        //     var_dump($queryResult); die;

        // } catch( AmoCRMApiException $e ) {
        //     var_dump($request->getLastRequestInfo()); die;
        // }

        $leadsService = $apiClient->leads();

        $lead = new LeadModel();
        // $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        // $textCustomFieldValueModel = new TextCustomFieldValuesModel();
        // $textCustomFieldValueModel->setFieldId(269303);
        // $textCustomFieldValueModel->setValues(
        //     (new TextCustomFieldValueCollection())
        //         ->add((new TextCustomFieldValueModel())->setValue('Текст'))
        // );
        // $leadCustomFieldsValues->add($textCustomFieldValueModel);
        // $lead->setCustomFieldsValues($leadCustomFieldsValues);
        $lead->setName('ZANKO ALEXANDR FROM V4');
        $lead->setStatusId(19518940);
        $lead->setTags((new TagsCollection())
           ->add(
                (new TagModel())
                    ->setId(500)
                    ->setName('Страница Бронирования')
            )
        );
        
        try {
            $lead = $leadsService->addOne($lead);
            //  var_dump($lead);
        } catch (AmoCRMApiException $e) {
            var_dump($e);
            die;
        }

        $contactPhone = '+375291010101';
        $contactEmail = 'zankoav@gmail.com';

        //Получим контакт по ID, сделку и привяжем контакт к сделке
        try {
            $contactsFilter = new ContactsFilter();
            $contactsFilter->setQuery($contactPhone);
            $contactsCollection = $apiClient->contacts()->get($contactsFilter);
            if($contactsCollection->count() > 0 ){
               $contact = $contactsCollection->first();
            }else{
                $contactsFilter->setQuery($contactEmail);
                $contactsCollection = $apiClient->contacts()->get($contactsFilter);
                if($contactsCollection->count() > 0 ){
                    $contact = $contactsCollection->first();
                    $customFields = $contact->getCustomFieldsValues();
                    $phoneField = (new MultitextCustomFieldValuesModel())->setFieldId(135479);
                    $phoneField->setValues(
                        (new MultitextCustomFieldValueCollection())
                            ->add(
                                (new MultitextCustomFieldValueModel())
                                    ->setValue($contactPhone)
                            )
                    );
                    $apiClient->contacts()->updateOne($contact);
                }else{
                    $contact = new ContactModel();
                    $contact->setName('TEST V4');
                    $contact = $apiClient->contacts()->addOne($contact);
                    $customFields = $contact->getCustomFieldsValues();
                    $phoneField = (new MultitextCustomFieldValuesModel())->setFieldId(135479);
                    $emailField = (new MultitextCustomFieldValuesModel())->setFieldId(135491);
                    
                    //Установим значение поля phone
                    $phoneField->setValues(
                        (new MultitextCustomFieldValueCollection())
                            ->add(
                                (new MultitextCustomFieldValueModel())
                                    ->setValue($contactPhone)
                            )
                    );

                    //Установим значение поля email
                    $emailField->setValues(
                        (new MultitextCustomFieldValueCollection())
                            ->add(
                                (new MultitextCustomFieldValueModel())
                                    ->setValue($contactEmail)
                            )
                    );

                    $customFields->add($phoneField);
                    $customFields->add($emailField);

                    $contact = $apiClient->contacts()->addOne($contact);
                }
            }

            $links = new LinksCollection();
            $links->add($contact);
            $apiClient->leads()->link($lead, $links);
            var_dump($contact);
        } catch (AmoCRMApiException $e) {
            printError($e);
            die;
        }

        // $links = new LinksCollection();
        // $links->add($contact);
        // try {
        //     $apiClient->leads()->link($lead, $links);
        // } catch (AmoCRMApiException $e) {
        //     printError($e);
        //     die;
        // }

        // try {
        //     $leadsCollection = $leadsService->get();
        //     var_dump("FIRST", $leadsCollection);
        //     // $leadsCollection = $leadsService->nextPage($leadsCollection);
        //     // var_dump("SECOND",$leadsCollection);

        //     //Создадим сделку с заполненым полем типа текст

        // } catch (AmoCRMApiException $e) {
        //     printError($e);
        //     die;
        // }











    //     $subdomain = 'krasnogorka'; //Поддомен нужного аккаунта
    // $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

    // /** Соберем данные для запроса */
    // $data = [
    //     'client_id' =>  '79aac717-18fc-4495-8a5f-7124a70de05d',
    //     'client_secret' =>  'h1MPktXuLLrCPrEneoFP7kh2rlVllzaxkzfivOK2xWzOTxFHqtIu26VDUIaEyOpG',
    //     'grant_type' => 'authorization_code',
    //     'code' => 'def50200ba9ed75f75a56176991a43ba185c7f9303c5875b6487388c3f61eb3a16a805cf4aefd890219837ec1b3857ab6b398d42517ff4c625ab311ad39788098faf35400c2af5aec132c96a02aa36fa39339cc9ff373a569ff8aca6fa09d78faeaa3d0861acedfd4687e6d281e305cac9c0e1f42b137db034b9573038dba3fabdb538569edf23c89da94783ddc3aac824c901089a8478ad98bc0820dbc35e94f9a254de0ae9086ed4c92a21ecacac91185f21dc40b2703bfd521d36230602d460a8708205dee3acec43e006383fa32a215a1ee585496f5cb9d41f3226cef84fc15a2e02603070589105ee7f275669fa4c79e8dfefcf657aefceac04a8b00b1622604f08a129b36192bdf7d700f8a253653ab526229f78925ed69bd1bdea1f0a1a4a37d4bb281896f62bc4cb48dda534672ac66bf44c858200a2194668b1dbf143786a92383f4aaf3ccddb243d70c93a8abbbbc6096b5a447f854f1032899bcf2a43c9051793a562c782c65ef62e00e6e03705395584fd25240e0badc0f2bef8ca30a055e5c72c7bf0c8e6162d39e5ae1a5b5c881ed69191da6e92d238c935a479df112c93bbcbb430725c33296d1926bcc835b596f402acd2c2ef152e1b6d34',
    //     'redirect_uri' => 'https://krasnagorka.by',
    // ];

    // /**
    //  * Нам необходимо инициировать запрос к серверу.
    //  * Воспользуемся библиотекой cURL (поставляется в составе PHP).
    //  * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
    //  */
    // $curl = curl_init(); //Сохраняем дескриптор сеанса cURL
    // /** Устанавливаем необходимые опции для сеанса cURL  */
    // curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
    // curl_setopt($curl,CURLOPT_URL, $link);
    // curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
    // curl_setopt($curl,CURLOPT_HEADER, false);
    // curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
    // curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
    // curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
    // curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
    // $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
    // $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    // curl_close($curl);
    // /** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
    // $code = (int)$code;
    // $errors = [
    //     400 => 'Bad request',
    //     401 => 'Unauthorized',
    //     403 => 'Forbidden',
    //     404 => 'Not found',
    //     500 => 'Internal server error',
    //     502 => 'Bad gateway',
    //     503 => 'Service unavailable',
    // ];

    // try
    // {
    //     /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
    //     if ($code < 200 || $code > 204) {
    //         throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    //     }
    // }
    // catch(\Exception $e)
    // {
    //     die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
    // }

    // /**
    //  * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
    //  * нам придётся перевести ответ в формат, понятный PHP
    //  */
    // $response = json_decode($out, true);

    // $access_token = $response['access_token']; //Access токен
    // $refresh_token = $response['refresh_token']; //Refresh токен
    // $token_type = $response['token_type']; //Тип токена
    // $expires_in = $response['expires_in']; //Через сколько действие токена истекает
    // $response['baseDomain'] = 'krasnogorka.amocrm.ru';

    // saveToken($response);

    // var_dump('OK');
    // die;
    ?>