<?php
namespace LsModel;

use Ls\Wp\Log as Log;


class ModelFactory
{

    // $_GET['clear']
    // $_GET['booking'];
    // $_GET['eventTabId'];
    // $_GET['from'];
    // $_GET['to'];
    // $_GET['terem'];
    // $_GET['calendarId'];
    // $_GET['obj'];
    // $_GET['eventId'];
    // $_GET['var'];
    // $_GET['people'];

    public static function getBookingModel(){

        $model;

        // Package ID
        $packageId = $_GET['package-id'];

        // Event ID
        $eventTabId = $_GET['eventTabId'];
        $eventId  = $_GET['eventId'];

        if(self::availablePackageModel($packageId)){
            $model = new PackageModel();
            $model->setPackageId($packageId);
        }else if(isset($eventTabId, $eventId)){
            $model = new EventModel();
        }else if(isset($eventTabId)){
            $model = new FierModel();
        }else{
            $model = new BaseModel();
        }

        return $model->getModel();
    }

    private static function availablePackageModel($packageId){
        $endDate;

        if(isset($packageId)){
            $endDate = get_post_meta($packageId, 'package_end', 1);
        }

        $result =   isset($endDate, $packageId) && 
                    strtotime("+1 day") < strtotime($endDate) && 
                    'publish' === get_post_status( $packageId );
        
        return $result;
    }

}