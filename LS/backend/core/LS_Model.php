<?php

class LS_Model{ 

    public function initModel(){
        /**
         * @var IModel $model 
         */
        $model;

        if(is_page_template('template-ls-primary.php')){
            $model= new PrimaryModel();
        }
        return $model->getModel();
    }
}
?>