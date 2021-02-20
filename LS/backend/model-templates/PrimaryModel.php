<?php
class PrimaryModel extends BaseModel{
    
    public function init(object $model){
        $model->objContent = LS_Assets::objContent();
        
        return $model;
    }
}