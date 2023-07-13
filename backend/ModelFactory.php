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

        $packageId = $_GET['package-id'];
        $endDate;
        if(isset($packageId)){
            $endDate = get_post_meta($packageId, 'package_end', 1);
            $today = date("Y-m-d");
            Log::info('ok', [
                "packageEndDate"=>$endDate,
                "today"=>$today
            ]);
        }
        
        if( isset($endDate, $packageId) && 
            'publish' === get_post_status( $packageId )
        ){
            $model = new PackageModel();
            $model->setPackageId($packageId);
        }else{
            $model = new BaseModel();
        }

        return $model->getModel();
    }

}