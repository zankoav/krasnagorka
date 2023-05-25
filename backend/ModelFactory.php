<?php

use Ls\Wp\Log as Log;

use LsModel\Model as Model;
use LsModel\ModelImpl as ModelImpl;


class ModelFactory
{

    public static function getBookingModel(){
        $model = new Model();
        return 'GG';//$model->getBookingModel();
    }

}