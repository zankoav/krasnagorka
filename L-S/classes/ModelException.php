<?php

namespace LsFactory;

use LsFactory\ModelException;

class ModelException extends FactoryException {

    public function __construct($message, $code = 500) {
		parent::__construct($message, 'ModelException', $code);
	}

}
