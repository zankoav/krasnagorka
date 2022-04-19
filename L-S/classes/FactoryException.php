<?php

namespace LsFactory;

class FactoryException extends \Exception {

    protected $type;

    public function __construct($message, $type) {
		parent::__construct($message);
        $this->type = $type;
	}

    // public function getMessage(){
    //     return 'gg';//"[$this->type]: $this->message";
    // }

}
