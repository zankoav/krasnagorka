<?php
namespace LsFactory;

use LsFactory\Contact;
use LsFactory\Order;
use LsFactory\AmoCrmException;

use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\TagModel;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Collections\ContactsCollection;

use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Collections\TasksCollection;
use AmoCRM\Models\TaskModel;

use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;

use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;

use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\DateCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\DateCustomFieldValuesModel;

use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateTimeCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\DateTimeCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\DateTimeCustomFieldValuesModel;

use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;

use AmoCRM\Models\CustomFieldsValues\NumericCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NumericCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\NumericCustomFieldValueModel;

use AmoCRM\Models\CustomFieldsValues\PriceCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\PriceCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\PriceCustomFieldValueModel;


use AmoCRM\Models\CustomFieldsValues\CheckboxCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\CheckboxCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\CheckboxCustomFieldValueModel;

use AmoCRM\Collections\CustomFieldsValuesCollection;

use AmoCRM\Collections\CatalogElementsCollection;
use AmoCRM\Filters\CatalogElementsFilter;
use AmoCRM\Models\CatalogElementModel;
use AmoCRM\Models\CatalogModel;

use AmoCRM\Collections\NotesCollection;
use AmoCRM\Models\NoteType\CommonNote;

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
        try{
            $apiClient = self::getAmoCrmApiClient();
            $leadsService = $apiClient->leads();

            $lead = new LeadModel();

            $leadName = 'Сделка с формы бронирования';
            $stageId = $order->isBookedOnly() ? 19518940 : 35452366; // Подтвердить бронирование | Сделка Из Сайта (webpay)
            
            $noteStr = implode("\n", $order->note);
            
            $lead->setName($leadName);
            $lead->setStatusId($stageId);
            $lead->setTags((new TagsCollection())
                    ->add(
                        (new TagModel())
                            ->setId(1181317)
                            ->setName('Страница Бронирования')
                    )
            );

            // Total Price
            $lead->setPrice($order->price);

            $leadCustomFields = new CustomFieldsValuesCollection();

            // Order food price 
            $foodPriceFieldValueModel = new TextCustomFieldValuesModel();
            $foodPriceFieldValueModel->setFieldId(760959);
            $foodPriceFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                            ->setValue($order->foodPrice)
                    )
            );
            $leadCustomFields->add($foodPriceFieldValueModel);

            // Order accommodation price
            $accommodationPriceFieldValueModel = new NumericCustomFieldValuesModel();
            $accommodationPriceFieldValueModel->setFieldId(760961);
            $accommodationPriceFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->accommodationPrice)
                    )
            );
            $leadCustomFields->add($accommodationPriceFieldValueModel);

            // Date From
            $dateFromFieldValueModel = new DateCustomFieldValuesModel();
            $dateFromFieldValueModel->setFieldId(66211);
            $dateFromModel = new DateCustomFieldValueModel();
            $dateFromModel->setValue($order->dateStart);
            $dateFromModelCollection = new DateCustomFieldValueCollection();
            $dateFromModelCollection->add($dateFromModel);
            $dateFromFieldValueModel->setValues($dateFromModelCollection);
            $leadCustomFields->add($dateFromFieldValueModel);

            // Date To 
            $dateToFieldValueModel = new DateCustomFieldValuesModel();
            $dateToFieldValueModel->setFieldId(66213);
            $dateToModel = new DateCustomFieldValueModel();
            $dateToModel->setValue($order->dateEnd);
            $dateToModelCollection = new DateCustomFieldValueCollection();
            $dateToModelCollection->add($dateToModel);
            $dateToFieldValueModel->setValues($dateToModelCollection);
            $leadCustomFields->add($dateToFieldValueModel);

            // Order people count
            $peopleCountFieldValueModel = new NumericCustomFieldValuesModel();
            $peopleCountFieldValueModel->setFieldId(760963);
            $peopleCountFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->peopleCount)
                    )
            );
            $leadCustomFields->add($peopleCountFieldValueModel);


            // Order food breakfast count
            $foodBreakfastFieldValueModel = new NumericCustomFieldValuesModel();
            $foodBreakfastFieldValueModel->setFieldId(760937);
            $foodBreakfastFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->foodBreakfast)
                    )
            );
            $leadCustomFields->add($foodBreakfastFieldValueModel);

            
            // Order food lunch count
            $foodLunchFieldValueModel = new NumericCustomFieldValuesModel();
            $foodLunchFieldValueModel->setFieldId(760939);
            $foodLunchFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->foodLunch)
                    )
            );
            $leadCustomFields->add($foodLunchFieldValueModel);

            // Order food dinner count
            $foodDinnerFieldValueModel = new NumericCustomFieldValuesModel();
            $foodDinnerFieldValueModel->setFieldId(760941);
            $foodDinnerFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->foodDinner)
                    )
            );
            $leadCustomFields->add($foodDinnerFieldValueModel);

            // Order food variant
            $foodVariantFieldValueModel = new SelectCustomFieldValuesModel();
            $foodVariantFieldValueModel->setFieldId(761481);
            $foodVariantFieldValueModel->setValues(
                (new SelectCustomFieldValueCollection())
                    ->add((new SelectCustomFieldValueModel())
                            ->setValue($order->getFoodVariant())
                    )
            );
            $leadCustomFields->add($foodVariantFieldValueModel);

            // Order bath house white count
            $bathHouseWhiteFieldValueModel = new NumericCustomFieldValuesModel();
            $bathHouseWhiteFieldValueModel->setFieldId(760943);
            $bathHouseWhiteFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->bathHouseWhite)
                    )
            );
            $leadCustomFields->add($bathHouseWhiteFieldValueModel);

            // Order bath house black count
            $bathHouseBlackFieldValueModel = new NumericCustomFieldValuesModel();
            $bathHouseBlackFieldValueModel->setFieldId(760945);
            $bathHouseBlackFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->bathHouseBlack)
                    )
            );
            $leadCustomFields->add($bathHouseBlackFieldValueModel);
            
            // Order small animal count
            $smallAnimalCountFieldValueModel = new NumericCustomFieldValuesModel();
            $smallAnimalCountFieldValueModel->setFieldId(760947);
            $smallAnimalCountFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->smallAnimalCount)
                    )
            );
            $leadCustomFields->add($smallAnimalCountFieldValueModel);

            // Order big animal count
            $bigAnimalCountFieldValueModel = new NumericCustomFieldValuesModel();
            $bigAnimalCountFieldValueModel->setFieldId(760949);
            $bigAnimalCountFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->bigAnimalCount)
                    )
            );
            $leadCustomFields->add($bigAnimalCountFieldValueModel);

            // Order child count without bed
            $childCountFieldValueModel = new NumericCustomFieldValuesModel();
            $childCountFieldValueModel->setFieldId(760965);
            $childCountFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->childCount)
                    )
            );
            $leadCustomFields->add($childCountFieldValueModel);


            if($order->eventChilds != null){
                // Order event child count
                $eventChildCountFieldValueModel = new NumericCustomFieldValuesModel();
                $eventChildCountFieldValueModel->setFieldId(763255);
                $eventChildCountFieldValueModel->setValues(
                    (new NumericCustomFieldValueCollection())
                        ->add((new NumericCustomFieldValueModel())
                                ->setValue($order->eventChilds)
                        )
                );
                $leadCustomFields->add($eventChildCountFieldValueModel);
            }
            // Order baby bed
            $babyBedFieldValueModel = new CheckboxCustomFieldValuesModel();
            $babyBedFieldValueModel->setFieldId(760951);
            $babyBedFieldValueModel->setValues(
                (new CheckboxCustomFieldValueCollection())
                    ->add((new CheckboxCustomFieldValueModel())
                            ->setValue($order->babyBed)
                    )
            );
            $leadCustomFields->add($babyBedFieldValueModel);
            
             // Comment
             $commentFieldValueModel = new TextCustomFieldValuesModel();
             $commentFieldValueModel->setFieldId(357377);
             $commentFieldValueModel->setValues(
                 (new TextCustomFieldValueCollection())
                     ->add((new TextCustomFieldValueModel())
                             ->setValue($noteStr)
                     )
             );
             $leadCustomFields->add($commentFieldValueModel);
            
            // Order prepaid percentage
            if($order->prepaidType != null){
                $prepaidTypePercentageFieldValueModel = new SelectCustomFieldValuesModel();
                $prepaidTypePercentageFieldValueModel->setFieldId(429245);
                $prepaidTypePercentageFieldValueModel->setValues(
                    (new SelectCustomFieldValueCollection())
                        ->add((new SelectCustomFieldValueModel())
                                ->setValue($order->prepaidType . '%')
                        )
                );
                $leadCustomFields->add($prepaidTypePercentageFieldValueModel);
            }
            
            // Order payment method
            if($order->getPaymentMethod() != '-'){
                $paymentMethodFieldValueModel = new SelectCustomFieldValuesModel();
                $paymentMethodFieldValueModel->setFieldId(70309);
                $paymentMethodFieldValueModel->setValues(
                    (new SelectCustomFieldValueCollection())
                        ->add((new SelectCustomFieldValueModel())
                                ->setValue($order->getPaymentMethod())
                        )
                );
                $leadCustomFields->add($paymentMethodFieldValueModel);
            }

            // Order scenario
            if(!empty($order->scenario)){
                $scenarioFieldValueModel = new SelectCustomFieldValuesModel();
                $scenarioFieldValueModel->setFieldId(763253);
                $scenarioFieldValueModel->setValues(
                    (new SelectCustomFieldValueCollection())
                        ->add((new SelectCustomFieldValueModel())
                                ->setValue($order->scenario)
                        )
                );
                $leadCustomFields->add($scenarioFieldValueModel);
            }

            // Is fire order
            $isEventFireOrderFieldValueModel = new CheckboxCustomFieldValuesModel();
            $isEventFireOrderFieldValueModel->setFieldId(760957);
            $isEventFireOrderFieldValueModel->setValues(
                (new CheckboxCustomFieldValueCollection())
                    ->add((new CheckboxCustomFieldValueModel())
                            ->setValue(!empty($order->eventTabId) and empty($order->eventId))
                    )
            );
            $leadCustomFields->add($isEventFireOrderFieldValueModel);

            // Is event order
            $isEventOrderFieldValueModel = new CheckboxCustomFieldValuesModel();
            $isEventOrderFieldValueModel->setFieldId(761273);
            $isEventOrderFieldValueModel->setValues(
                (new CheckboxCustomFieldValueCollection())
                    ->add((new CheckboxCustomFieldValueModel())
                            ->setValue(!empty($order->eventId))
                    )
            );
            $leadCustomFields->add($isEventOrderFieldValueModel);

            // Event id 
            $eventIdOrderFieldValueModel = new TextCustomFieldValuesModel();
            $eventIdOrderFieldValueModel->setFieldId(761301);
            $eventIdOrderFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                            ->setValue($order->eventId)
                    )
            );
            $leadCustomFields->add($eventIdOrderFieldValueModel);

            

            $eventVariant = $order->eventVariant();
            if(!empty($eventVariant)){

                // Variant title of event
                $isEventVariantTitleOrderFieldValueModel = new TextCustomFieldValuesModel();
                $isEventVariantTitleOrderFieldValueModel->setFieldId(761275);
                $isEventVariantTitleOrderFieldValueModel->setValues(
                    (new TextCustomFieldValueCollection())
                        ->add((new TextCustomFieldValueModel())
                                ->setValue($eventVariant['title'])
                        )
                );
                $leadCustomFields->add($isEventVariantTitleOrderFieldValueModel);

                // Variant description of event
                $isEventVariantDescriptionOrderFieldValueModel = new TextCustomFieldValuesModel();
                $isEventVariantDescriptionOrderFieldValueModel->setFieldId(761299);
                $isEventVariantDescriptionOrderFieldValueModel->setValues(
                    (new TextCustomFieldValueCollection())
                        ->add((new TextCustomFieldValueModel())
                                ->setValue($eventVariant['description'])
                        )
                );
                $leadCustomFields->add($isEventVariantDescriptionOrderFieldValueModel);

                // Variant id of event
                $isEventVariantIdOrderFieldValueModel = new TextCustomFieldValuesModel();
                $isEventVariantIdOrderFieldValueModel->setFieldId(761297);
                $isEventVariantIdOrderFieldValueModel->setValues(
                    (new TextCustomFieldValueCollection())
                        ->add((new TextCustomFieldValueModel())
                                ->setValue($order->variantId)
                        )
                );
                $leadCustomFields->add($isEventVariantIdOrderFieldValueModel);
            }
            
            // Order Type
            $typeFieldValueModel = new TextCustomFieldValuesModel();
            $typeFieldValueModel->setFieldId(640633);
            $typeFieldValueModel->setValues(
                (new TextCustomFieldValueCollection())
                    ->add((new TextCustomFieldValueModel())
                            ->setValue($order->type)
                    )
            );
            $leadCustomFields->add($typeFieldValueModel);

            // Order ID
            $orderIdFieldValueModel = new NumericCustomFieldValuesModel();
            $orderIdFieldValueModel->setFieldId(639191);
            $orderIdFieldValueModel->setValues(
                (new NumericCustomFieldValueCollection())
                    ->add((new NumericCustomFieldValueModel())
                            ->setValue($order->id)
                    )
            );
            $leadCustomFields->add($orderIdFieldValueModel);

            $lead->setCustomFieldsValues($leadCustomFields);

            $houseElement = null;
            $catalogElementsFilter = new CatalogElementsFilter();
            $catalogElementsFilter->setIds([self::CALENDAR_OBJECTS_MAPPING[$order->calendarId]]);
            $catalogElementsService = $apiClient->catalogElements(1321);
            $catalogElementsCollection = $catalogElementsService->get($catalogElementsFilter);
            $houseElement = $catalogElementsCollection->first();
            $houseElement->setQuantity(1);

            $lead = $leadsService->addOne($lead);

            $links = new LinksCollection();
            $links->add($houseElement);
            $apiClient
                ->leads()
                ->link($lead, $links);

            $notePrepaidType = $order->prepaidType ?? '-';

            $isFireOrder = 'Нет';
            $isEventOrder = 'Нет';
            
            if($order->scenario == 'Event'){
                $isEventOrder = get_the_title($order->eventId);
            }else if($order->scenario == 'Fier'){
                $isFireOrder = 'Да';
            }

            $order->note[] = "Сумма: {$order->price} руб.";
            $order->note[] = "Количество Человек: {$order->peopleCount}";
            $order->note[] = "Горящее предложение: {$isFireOrder}";
            if(!empty($eventVariant)){
                $order->note[] = "Мероприятие: {$isEventOrder}";
                $order->note[] = "Количество детей (до 12 лет): {$order->eventChilds}";
                $order->note[] = "Пакет: " . $eventVariant['title'];
                $order->note[] = "Описание пакета: " . $eventVariant['description'];
            }
            
            $order->note[] = "Стоимость питания: {$order->foodPrice} руб.";

            $order->note[] = "Детская кроватка: {$order->isBabyBedMessage()}";

            $order->note[] = "Завтраки: {$order->foodBreakfast}";
            $order->note[] = "Обеды: {$order->foodLunch}";
            $order->note[] = "Ужины: {$order->foodDinner}";
            $order->note[] = "Пакет питания: {$order->getFoodVariant()}";

            $order->note[] = "Бани по белому: {$order->bathHouseWhite} кол-во";
            $order->note[] = "Бани по черному: {$order->bathHouseBlack} кол-во";

            $order->note[] = "Мелкие животные: {$order->smallAnimalCount} кол-во";
            $order->note[] = "Крупные животные: {$order->bigAnimalCount} кол-во";

            $order->note[] = "Стоимость проживания: {$order->accommodationPrice} руб.";
            $order->note[] = "Домик: {$order->calendarName}";
            $order->note[] = "Паспорт №: {$order->contact->passport}";
            $order->note[] = "Способ оплтаты: {$order->getPaymentMethod()}";
            $order->note[] = "Оплата %: {$notePrepaidType}";

            $noteStr = implode("\n", $order->note);

            $notesCollection = new NotesCollection();
            $messageNote = new CommonNote();
            $messageNote
                ->setEntityId($lead->getId())
                ->setText($noteStr);
            $notesCollection->add($messageNote);
            $apiClient
                ->notes(EntityTypesInterface::LEADS)
                ->add($notesCollection);

            $order->leadId = $lead->getId();
            update_post_meta($order->id, 'sbc_lead_id', $order->leadId);

            // CONTACT

            $contact = null;
            $contactsCollection = null;
            $contactsFilter = new ContactsFilter();
            $contactsFilter->setQuery($order->contact->phone);

            try{
                $contactsCollection = $apiClient->contacts()->get($contactsFilter);
            } catch (AmoCRMApiNoContentException $e) {
                $contact = null;
                $contactsCollection = null;
            }
            


            if (!empty($contactsCollection) and $contactsCollection->count() > 0) {
                $contact = $contactsCollection->first();
                $contact->setName($order->contact->fio);
                $customFields = $contact->getCustomFieldsValues();

                $emailField = $customFields->getBy('fieldCode', 'EMAIL');
                if (empty($emailField)) {
                    $emailField = (new MultitextCustomFieldValuesModel())->setFieldCode('EMAIL');
                    $customFields->add($emailField);
                }
                $emailField->setValues(
                    (new MultitextCustomFieldValueCollection())
                        ->add(
                            (new MultitextCustomFieldValueModel())
                                ->setEnum('WORK')
                                ->setValue($order->contact->email)
                        )
                );

                if (!empty($order->contact->passport)) {
                    $passportFieldValueModel = new TextCustomFieldValuesModel();
                    $passportFieldValueModel->setFieldId(638673);
                    $passportFieldValueModel->setValues(
                        (new TextCustomFieldValueCollection())
                            ->add((new TextCustomFieldValueModel())
                                ->setValue($order->contact->passport))
                    );
                    $customFields->add($passportFieldValueModel);
                }

                $contact = $apiClient->contacts()->updateOne($contact);
            } else {
                $contactsFilter->setQuery($order->contact->email);

                try{
                    $contactsCollection = $apiClient->contacts()->get($contactsFilter);
                } catch (AmoCRMApiNoContentException $e) {
                    $contact = null;
                    $contactsCollection = null;
                }

                if (!empty($contactsCollection) and $contactsCollection->count() > 0) {
                    $contact = $contactsCollection->first();
                    $contact->setName($order->contact->fio);

                    $customFields = $contact->getCustomFieldsValues();
                    $phoneField = $customFields->getBy('fieldCode', 'PHONE');
                    if (empty($phoneField)) {
                        $phoneField = (new MultitextCustomFieldValuesModel())->setFieldCode('PHONE');
                        $customFields->add($phoneField);
                    }
                    $phoneField->setValues(
                        (new MultitextCustomFieldValueCollection())
                            ->add(
                                (new MultitextCustomFieldValueModel())
                                    ->setEnum('WORKDD')
                                    ->setValue($order->contact->phone)
                            )
                    );

                    if (!empty($order->contact->passport)) {
                        $passportFieldValueModel = new TextCustomFieldValuesModel();
                        $passportFieldValueModel->setFieldId(638673);
                        $passportFieldValueModel->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add((new TextCustomFieldValueModel())
                                    ->setValue($order->contact->passport))
                        );
                        $customFields->add($passportFieldValueModel);
                    }

                    $contact = $apiClient->contacts()->updateOne($contact);
                } else {
                    $contact = new ContactModel();
                    $contact->setName($order->contact->fio);

                    $contactCustomFields = new CustomFieldsValuesCollection();
                    $phoneFieldValueModel = new MultitextCustomFieldValuesModel();
                    $phoneFieldValueModel->setFieldCode('PHONE');
                    $phoneFieldValueModel->setValues(
                        (new MultitextCustomFieldValueCollection())
                            ->add(
                                (new MultitextCustomFieldValueModel())
                                    ->setEnum('WORKDD')
                                    ->setValue($order->contact->phone)
                            )
                    );

                    $emailFieldValueModel = new MultitextCustomFieldValuesModel();
                    $emailFieldValueModel->setFieldCode('EMAIL');
                    $emailFieldValueModel->setValues(
                        (new MultitextCustomFieldValueCollection())
                            ->add(
                                (new MultitextCustomFieldValueModel())
                                    ->setEnum('WORK')
                                    ->setValue($order->contact->email)
                            )
                    );

                    $contactCustomFields->add($phoneFieldValueModel);
                    $contactCustomFields->add($emailFieldValueModel);
                    $contact->setCustomFieldsValues($contactCustomFields);

                    if (!empty($order->contact->passport)) {
                        $passportFieldValueModel = new TextCustomFieldValuesModel();
                        $passportFieldValueModel->setFieldId(638673);
                        $passportFieldValueModel->setValues(
                            (new TextCustomFieldValueCollection())
                                ->add((new TextCustomFieldValueModel())
                                    ->setValue($order->contact->passport))
                        );
                        $contactCustomFields->add($passportFieldValueModel);
                    }
                    $contact = $apiClient->contacts()->addOne($contact);
                }
            }

            $links = new LinksCollection();
            $links->add($contact);
            $apiClient->leads()->link($lead, $links);

            if($order->isBookedOnly() || $order->paymentMethod === Order::METHOD_CARD){
                $taskId = self::addAmoCrmTask('Помочь клиенту определиться с заказом', $lead->getId());
                update_post_meta($order->id, 'sbc_task_id', $taskId);
            }

            if($order->foodPrice > 0){
                    // Создадим задачу по питанию
                $tasksCollection = new TasksCollection();
                $task = new TaskModel();
                $task->setTaskTypeId(TaskModel::TASK_TYPE_ID_CALL)
                    ->setText('Проверить Питание')
                    ->setCompleteTill(mktime(date("H"), date("i") + 60))
                    ->setEntityType(EntityTypesInterface::LEADS)
                    ->setEntityId($lead->getId())
                    ->setDuration(1 * 60 * 60) // 1 час
                    ->setResponsibleUserId(2373844);
                $tasksCollection->add($task);

                try {
                    $apiClient->tasks()->add($tasksCollection);
                } catch (AmoCRMApiException $e) {
                    Logger::log('Exceptions: ' . $e->getTitle() . ' <<< tasksCollection >>> ' . $e->getDescription());
                }
            }
           
        } catch (AmoCRMApiException $e) {
            throw new AmoCrmException("AmoCRMApiException {$e->getMessage()}", 301);
        } catch (Exception $e) {
            throw new AmoCrmException("Exception {$e->getMessage()}", 302);
        }
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

    private static function addAmoCrmTask($message, $leadId){
        $taskId = false;

        $apiClient = self::getAmoCrmApiClient();
        //Создадим задачу
        $tasksCollection = new TasksCollection();
        $task = new TaskModel();
        $task->setTaskTypeId(TaskModel::TASK_TYPE_ID_CALL)
            ->setText($message)
            ->setCompleteTill(mktime(date("H"), date("i") + 30))
            ->setEntityType(EntityTypesInterface::LEADS)
            ->setEntityId(intval($leadId))
            ->setDuration(1 * 60 * 60) // 1 час
            ->setResponsibleUserId(2373844);
        $tasksCollection->add($task);

        try {
            $tasksCollection = $apiClient->tasks()->add($tasksCollection);
            $taskToStore = $tasksCollection->first();
            $taskId = $taskToStore->getId();
        } catch (AmoCRMApiException $e) {
            Log::error('Exception: ' . $e->getTitle(), $e->getDescription());
        }

        return $taskId;
    }
}
