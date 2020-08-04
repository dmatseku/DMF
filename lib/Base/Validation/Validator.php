<?php


namespace   lib\Base\Validation;

class   Validator
{
    /**
     * @var array
     */
    private array   $rules = [];
    /**
     * @var array
     */
    private array   $errors = [];

    /**
     * Validator constructor. create rules from array
     *
     * @param array $pattern
     */
    public function __construct(array $pattern)
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

    /**
     * validate data
     *
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool
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

    /**
     * get all errors
     *
     * @return array
     */
    public function getErrorMessages(): array
    {
        return $this->errors;
    }

    /**
     * get errors for property
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public function getErrorMessagesFor(string $name)
    {
        return $this->errors[$name] ?? null;
    }
}