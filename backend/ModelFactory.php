<?php
namespace LsModel;

use Ls\Wp\Log as Log;


class ModelFactory
{

    public static function getBookingModel(){
        $model = new Model();
        return $model->getBookingModel();
    }

}