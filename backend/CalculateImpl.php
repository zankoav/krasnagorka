<?php
namespace LsCalculate;

use Ls\Wp\Log as Log;

abstract class CalculateImpl
{
    abstract protected function scenario();
    abstract protected function calculate($data);

    protected function response($request){
        return [
            'scenario' => $this->scenario(),
            'result' => $this->calculate($request)
        ];
    }
}
