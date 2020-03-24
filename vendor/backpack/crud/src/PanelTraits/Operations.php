<?php

namespace Backpack\CRUD\PanelTraits;

trait Operations
{
    /*
    |--------------------------------------------------------------------------
    |                               OPERATIONS
    |--------------------------------------------------------------------------
    | Helps developers set and get the current CRUD operation, as defined by
    | the contoller method being run.
    */
    public $operation;

    /**
     * Get the current CRUD operation being performed.
     *
     * @return string Operation being performed in string form.
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set the CRUD operation being performed in string form.
     *
     * @param string $operation_name Ex: create / update / revision / delete
     */
    public function setOperation($operation_name)
    {
        $this->operation = $operation_name;
    }
}
