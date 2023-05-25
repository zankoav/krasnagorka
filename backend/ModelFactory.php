<?php

namespace LsModel;

use Ls\Wp\Log as Log;

use LsModel\Model as Model;


class ModelFactory
{

    public static function GET_BOOKING_MODEL(){
        $model = new Model();
        return $model->getBookingModel();
    }

}