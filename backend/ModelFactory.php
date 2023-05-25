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
        if(false){

        }else{ 
            $model = new BaseModel();
        }
        
        return $model->getBookingModel();
    }

}