<?php


namespace   lib\Base\Http;

use         lib\Base\Http\Request;


abstract class Response
{
    /**
     * @var array value
     */
    protected $args = [];

    /**
     * Make response
     */
    abstract public function    run();

    /**
     * insert args
     *
     * @param array $values
     *
     * @return $this
     */
    public function             with(array $values)
    {
        $this->args = $values + $this->args;
        return $this;
    }

    /**
     * insert error messages
     *
     * @param array $errors
     *
     * @return $this
     */
    public function             withErrors(array $errors)
    {
        $this->args['inputErrors'] = $errors['inputErrors'] ?? $errors;
        return $this;
    }

    /**
     * insert input in args
     *
     * @param array $input
     * @param string|mixed $except exclude these variables
     *
     * @return $this
     */
    public function             withInput(array $input, $except = null)
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