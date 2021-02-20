<?php
 abstract class BaseModel implements IModel{

   public abstract function init(object $model);

   public function getModel(){
      $model = new class{};
      $model->devise=LS_setDevice();
      $model->today=LS_Today::today();
      $model->weather=ls_get_weatherObj();
      $model->currency = ((new LS_Currency)->getCurrency());
      $model->contact = (object)[
         "a1"=>"+375 29 320 19 19",
         "mts"=>"+375 29 701 19 19",
         "life"=>"+375 25 920 19 19",
         "email"=>"info@krasnagorka.by"
      ];
      
      $model = $this->init($model);
      return $model;
   }


 }