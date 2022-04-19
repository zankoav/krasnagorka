<?php

namespace LsFactory;

use Ls\Wp\Log as Log;

class FactoryException extends \Exception {

    protected $type;

    public function __construct($message, $type, $code = 0) {
		parent::__construct($message, $code);
        $this->type = $type;
	}

    public function __toString() {
        Log::error($this->type, $this->message);
        return  "[{$this->type}]: {$this->message}";
    }
}
