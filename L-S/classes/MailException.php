<?php

namespace LsFactory;

use LsFactory\MailException;

class MailException extends FactoryException {

    public function __construct($message, $code = 400) {
		parent::__construct($message, 'MailException', $code);
	}

}
