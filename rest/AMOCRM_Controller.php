<?php
use Ls\Wp\Log as Log;

use LsFactory\FactoryException;
use LsFactory\OrderFactory;
// use LsFactory\AmoCrmFactory;
use LsFactory\MailFactory;


/**
 * Created by PhpStorm.
 * User: alexandrzanko
 * Date: 11/22/19
 * Time: 2:39 PM
 */

class AMOCRM_Controller extends WP_REST_Controller {

    public function register_routes() {
        $namespace = 'amocrm/v4';

        register_rest_route($namespace, '/create-order/', [
            array(
                'methods'             => 'POST',
                'callback'            => array($this, 'create_order'),
                'permission_callback' => array($this, 'create_order_permissions_check')
            ),
        ]);
    }

    public function create_order_permissions_check($request) {
        return true;
    }

    public function create_order($request) {
        try {
            
            // $order = OrderFactory::initOrderByRequest($request);
            // OrderFactory::isAvailableOrder($order);
            // OrderFactory::insert($order);
            // AmoCrmFactory::createLead($order);
            // MailFactory::sendOrder($order);

            // $response = $order;

        } catch( FactoryException $e ){
            $response = $e->getResponse();
        } catch ( TypeError $e ) {
            $response = ['error' => $e->getMessage()];
        } catch ( Exception $e ) {
            $response = ['error' => $e->getMessage()];
        }

        return new WP_REST_Response(['dd'], 200);
    }
}

