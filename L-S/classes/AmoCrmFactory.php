<?php
namespace LsFactory;

use LsFactory\Contact;
use LsFactory\Order;
use LsFactory\AmoCrmException;

// use AmoCRM\Models\LeadModel;
// use AmoCRM\Collections\Leads\LeadsCollection;
// use AmoCRM\Client\AmoCRMApiClient;
// use League\OAuth2\Client\Token\AccessTokenInterface;
// use AmoCRM\Exceptions\AmoCRMApiException;
// use AmoCRM\Collections\TagsCollection;
// use AmoCRM\Models\TagModel;
// use AmoCRM\Filters\ContactsFilter;
// use AmoCRM\Filters\LeadsFilter;
// use AmoCRM\Models\ContactModel;
// use AmoCRM\Collections\LinksCollection;
// use AmoCRM\Collections\ContactsCollection;

// use AmoCRM\Helpers\EntityTypesInterface;
// use AmoCRM\Collections\TasksCollection;
// use AmoCRM\Models\TaskModel;

// use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
// use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;
// use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;

// use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
// use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
// use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;

// use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateCustomFieldValueCollection;
// use AmoCRM\Models\CustomFieldsValues\ValueModels\DateCustomFieldValueModel;
// use AmoCRM\Models\CustomFieldsValues\DateCustomFieldValuesModel;

// use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateTimeCustomFieldValueCollection;
// use AmoCRM\Models\CustomFieldsValues\ValueModels\DateTimeCustomFieldValueModel;
// use AmoCRM\Models\CustomFieldsValues\DateTimeCustomFieldValuesModel;

// use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
// use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
// use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;

// use AmoCRM\Models\CustomFieldsValues\NumericCustomFieldValuesModel;
// use AmoCRM\Models\CustomFieldsValues\ValueCollections\NumericCustomFieldValueCollection;
// use AmoCRM\Models\CustomFieldsValues\ValueModels\NumericCustomFieldValueModel;

// use AmoCRM\Models\CustomFieldsValues\PriceCustomFieldValuesModel;
// use AmoCRM\Models\CustomFieldsValues\ValueCollections\PriceCustomFieldValueCollection;
// use AmoCRM\Models\CustomFieldsValues\ValueModels\PriceCustomFieldValueModel;

// use AmoCRM\Collections\CustomFieldsValuesCollection;

// use AmoCRM\Collections\CatalogElementsCollection;
// use AmoCRM\Filters\CatalogElementsFilter;
// use AmoCRM\Models\CatalogElementModel;
// use AmoCRM\Models\CatalogModel;

// use AmoCRM\Collections\NotesCollection;
// use AmoCRM\Models\NoteType\CommonNote;

class AmoCrmFactory {

    public const CALENDAR_OBJECTS_MAPPING = [
        17 => 1036665,  37 => 1036663,
        18 => 1036661,  19 => 1036659,
        20 => 1036657,  21 => 1036655,
        22 => 1036653,  23 => 1036651,
        24 => 1036649,  25 => 1036647,
        26 => 1036645,  27 => 1036643,
        28 => 1036641,  29 => 1036639,
        14 => 1036585,  13 => 1036583,
        15 => 10393,    9 => 10391,
        43 => 1663367,  16 => 10389
    ];

    public static function createLead(Order $order){
        // try{
            // $apiClient = self::getAmoCrmApiClient();
            // $leadsService = $apiClient->leads();

            // $lead = new LeadModel();

            // $leadName = 'Сделка с формы бронирования';
            // $stageId = $order->isBookedOnly() ? 19518940 : 35452366; // Подтвердить бронирование | Сделка Из Сайта (webpay)
            
            // $lead->setName($leadName);
            // $lead->setStatusId($stageId);
            // $lead->setPrice($order->price);
            // $lead->setTags((new TagsCollection())
            //         ->add(
            //             (new TagModel())
            //                 ->setId(1181317)
            //                 ->setName('Страница Бронирования')
            //         )
            // );

            // $leadCustomFields = new CustomFieldsValuesCollection();

            // // Order ID
            // $orderIdFieldValueModel = new NumericCustomFieldValuesModel();
            // $orderIdFieldValueModel->setFieldId(639191);
            // $orderIdFieldValueModel->setValues(
            //     (new NumericCustomFieldValueCollection())
            //         ->add((new NumericCustomFieldValueModel())
            //                 ->setValue($order->id)
            //         )
            // );
            // $leadCustomFields->add($orderIdFieldValueModel);

            // // Order Type
            // $typeFieldValueModel = new TextCustomFieldValuesModel();
            // $typeFieldValueModel->setFieldId(640633);
            // $typeFieldValueModel->setValues(
            //     (new TextCustomFieldValueCollection())
            //         ->add((new TextCustomFieldValueModel())
            //                 ->setValue($order->type)
            //         )
            // );
            // $leadCustomFields->add($typeFieldValueModel);

            // // Comment
            // $commentFieldValueModel = new TextCustomFieldValuesModel();
            // $commentFieldValueModel->setFieldId(357377);
            // $commentFieldValueModel->setValues(
            //     (new TextCustomFieldValueCollection())
            //         ->add((new TextCustomFieldValueModel())
            //                 ->setValue($order->comment)
            //         )
            // );
            // $leadCustomFields->add($commentFieldValueModel);

            // // Date From
            // $dateFromFieldValueModel = new DateCustomFieldValuesModel();
            // $dateFromFieldValueModel->setFieldId(66211);
            // $dateFromModel = new DateCustomFieldValueModel();
            // $dateFromModel->setValue($order->dateStart);
            // $dateFromModelCollection = new DateCustomFieldValueCollection();
            // $dateFromModelCollection->add($dateFromModel);
            // $dateFromFieldValueModel->setValues($dateFromModelCollection);
            // $leadCustomFields->add($dateFromFieldValueModel);

            // // Date To 
            // $dateToFieldValueModel = new DateCustomFieldValuesModel();
            // $dateToFieldValueModel->setFieldId(66213);
            // $dateToModel = new DateCustomFieldValueModel();
            // $dateToModel->setValue($order->dateEnd);
            // $dateToModelCollection = new DateCustomFieldValueCollection();
            // $dateToModelCollection->add($dateToModel);
            // $dateToFieldValueModel->setValues($dateToModelCollection);
            // $leadCustomFields->add($dateToFieldValueModel);

            // $lead->setCustomFieldsValues($leadCustomFields);

            // $houseElement = null;
            // $catalogElementsFilter = new CatalogElementsFilter();
            // $catalogElementsFilter->setIds([self::CALENDAR_OBJECTS_MAPPING[$order->calendarId]]);
            // $catalogElementsService = $apiClient->catalogElements(1321);
            // $catalogElementsCollection = $catalogElementsService->get($catalogElementsFilter);
            // $houseElement = $catalogElementsCollection->first();
            // $houseElement->setQuantity(1);

            // $lead = $leadsService->addOne($lead);

            // $links = new LinksCollection();
            // $links->add($houseElement);
            // $apiClient
            //     ->leads()
            //     ->link($lead, $links);

            // $notesCollection = new NotesCollection();
            // $messageNote = new CommonNote();
            // $messageNote
            //     ->setEntityId($lead->getId())
            //     ->setText($order->comment);
            // $notesCollection->add($messageNote);
            // $apiClient
            //     ->notes(EntityTypesInterface::LEADS)
            //     ->add($notesCollection);

            // $order->leadId = $lead->getId();
            // update_post_meta($order->id, 'sbc_lead_id', $order->leadId);

        // } catch (AmoCRMApiException $e) {
        //     throw new AmoCrmException("AmoCRMApiException {$e->getMessage()}");
        // } catch (Exception $e) {
        //     throw new AmoCrmException("Exception {$e->getMessage()}");
        // }
    }

    private static function getAmoCrmApiClient()
    {

        $clientId = 'fcead59e-467f-482d-ab48-4df278e0bc1c';
        $clientSecret = 'tUiAfQfEvIepyj1mLX0T7Zzbot8fpil1zIOoYfXqmZNSF7f4dqRR20dYy0qnlGIW';
        $redirectUri = 'https://krasnagorka.by/wp-content/themes/krasnagorka/token_actions.php';
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
                }
            );
        return $apiClient;
    }
}
