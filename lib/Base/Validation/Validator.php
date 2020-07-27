<?php


namespace   lib\Base\Validation;

class   Validator
{
    protected   $rules = [];
    protected   $errors = [];

    public function __construct($pattern)
    {
        foreach ($pattern as $property => $rules) {
            if (is_array($rules)) {
                $this->rules[$property] = Rule::createRulesArray($rules);
            } elseif (is_string($rules)) {
                $this->rules[$property] = Rule::createRulesArray(explode('|', $rules));
            } else {
                throw new \RuntimeException('Invalid pattern for validator', 500);
            }
        }
    }

    public function validate($data)
    {
        $success = true;

        foreach ($this->rules as $property => $rules) {
            foreach ($rules as $rule) {
                if (!$rule->check($property, $data, $rules)) {
                    $success = false;
                    $this->errors[$property][] = $rule->getMessage($property, $data);
                }
            }
        }

        return $success;
    }

    public function getErrorMessages()
    {
        return $this->errors;
    }

    public function getErrorMessagesFor($name)
    {
        return $this->errors[$name] ?? null;
    }
}

/*
 * [
 *     'property' => 'rule:params|rule:params|rule:params',
 *     'property' => ['rule:params', 'rule:params', 'rule:params'],
 *     'property' => [
 *         'rule' => [param1, param2, param3],
 *         'rule' => [param1, param2, param3],
 *         'rule' => [param1, param2, param3]
 *     ]
 *     'property' => [
 *         'rule:params',
 *         'rule' => [param1, param2, param3]
 *     ]
 * ]
 */