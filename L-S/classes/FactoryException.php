<?php

namespace LsFactory;

class FactoryException extends Exception {

    protected $type;

    public function __construct($message, $type, $code = 0) {
		parent::__construct($message, $code);
        $this->type = $type;
	}

    public function getMessage(){
        return "[$this->type]: $this->message";
    }

}
