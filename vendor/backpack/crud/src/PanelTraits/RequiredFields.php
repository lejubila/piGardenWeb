<?php

namespace Backpack\CRUD\PanelTraits;

trait RequiredFields
{
    /*
    |--------------------------------------------------------------------------
    |                             REQUIRED FIELDS
    |--------------------------------------------------------------------------
    */
    public $requiredFields = [];

    /**
     * Parse a FormRequest class, figure out what inputs are required
     * and store this knowledge in the current object.
     *
     * @param string $class     Class that extends FormRequest
     * @param string $operation create/update
     */
    public function setRequiredFields($class, $operation)
    {
        $formRequest = new $class;

        $rules = $formRequest->rules();

        if (count($rules)) {
            foreach ($rules as $key => $rule) {
                if (
                    (is_string($rule) && strpos($rule, 'required') !== false && strpos($rule, 'required_') === false) ||
                    (is_array($rule) && array_search('required', $rule) !== false && array_search('required_', $rule) === false)
                ) {
                    $this->requiredFields[$operation][] = $key;
                }
            }
        }
    }

    /**
     * Check the current object to see if an input is required
     * for the given operation.
     *
     * @param string $inputName Field or input name.
     * @param string $operation create / update
     *
     * @return bool
     */
    public function isRequired($inputName, $operation)
    {
        if (! isset($this->requiredFields[$operation])) {
            return false;
        }

        return in_array($inputName, $this->requiredFields[$operation]);
    }
}
