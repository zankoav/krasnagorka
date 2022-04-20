<?php
use Ls\Wp\Log as Log;

use LsFactory\ContactException;
use LsFactory\OrderException;
use LsFactory\OrderFactory;


use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Exceptions\AmoCRMApiException;
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

use AmoCRM\Collections\CustomFieldsValuesCollection;

use AmoCRM\Collections\CatalogElementsCollection;
use AmoCRM\Filters\CatalogElementsFilter;
use AmoCRM\Models\CatalogElementModel;
use AmoCRM\Models\CatalogModel;

use AmoCRM\Collections\NotesCollection;
use AmoCRM\Models\NoteType\CommonNote;


/**
 * Created by PhpStorm.
 * User: alexandrzanko
 * Date: 11/22/19
 * Time: 2:39 PM
 */

class AMOCRM_Controller extends WP_REST_Controller {

    public function register_routes() {
        $namespace = 'amocrm/v4';

        register_rest_route($namespace, '/create-lead/', [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'create_lead'),
                'permission_callback' => array($this, 'create_lead_permissions_check')
            ),
        ]);
    }

    public function create_lead_permissions_check($request) {
        return true;
    }

    public function create_lead($request) {
        try {

            $order = OrderFactory::initOrderByRequest($request);

            $response = $order;
            // if(OrderFactory::isAvailableOrder($order)){
            //     OrderFactory::createOrder($order);
            //     AmoCrmFactory::createLead($order);
            //     MailFactory::sendVoucher($order);

            //     $response = new SuccessfulResponse($order);
            // }else{
            //     $response = new NotAvailableResponse();
            // }
        // } catch(OrderException $e){
        //     $response = new ExceptionResponse($e);
        // } catch(OrderFactoryException $e){
        //     $response = new ExceptionResponse($e);
        // } catch(AmoCrmFactoryException $e){
        //     $response = new ExceptionResponse($e);
        // } catch(MailFactoryException $e){
        //     $response = new ExceptionResponse($e);
        // };

        } catch( ContactException $e){
            $response = $e;
        } catch( OrderException $e){
            $response = $e;
        }

        return new WP_REST_Response($order, 200);
    }
}

