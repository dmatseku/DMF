<?php


namespace   lib\Base\Http;

use         lib\Base\Http\Request;


abstract class Response
{
    protected $args = [];

    abstract public function    run();

    public function             with($valuesArray)
    {
        $this->args = $valuesArray + $this->args;
        return $this;
    }

    public function             withErrors($errorsArray)
    {
        $this->args['inputErrors'] = $errorsArray['inputErrors'] ?? $errorsArray;
        return $this;
    }

    public function             withInput($input, $except = null)
    {
        if (is_array($input)) {
            $this->args['prevInput'] = $input['prevInput'] ?? $input;
        }

        if (is_array($except)) {
            foreach ($except as $name) {
                unset($this->args['prevInput'][$name]);
            }
        } elseif ($except !== null) {
            unset($this->args['prevInput'][$except]);
        }

        return $this;
    }
}