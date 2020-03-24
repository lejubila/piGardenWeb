<?php

namespace Backpack\CRUD\PanelTraits;

trait Errors
{
    protected $groupedErrors = true;
    protected $inlineErrors = false;

    public function setErrorDefaults()
    {
        $this->groupedErrors = config('backpack.crud.show_grouped_errors', true);
        $this->inlineErrors = config('backpack.crud.show_inline_errors', false);
    }

    // Getters

    /**
     * @return bool
     */
    public function groupedErrorsEnabled()
    {
        return $this->groupedErrors;
    }

    /**
     * @return bool
     */
    public function inlineErrorsEnabled()
    {
        return $this->inlineErrors;
    }

    // Setters

    public function enableGroupedErrors()
    {
        $this->groupedErrors = true;

        return $this->groupedErrors;
    }

    public function disableGroupedErrors()
    {
        $this->groupedErrors = false;

        return $this->groupedErrors;
    }

    public function enableInlineErrors()
    {
        $this->inlineErrors = true;

        return $this->inlineErrors;
    }

    public function disableInlineErrors()
    {
        $this->inlineErrors = false;

        return $this->inlineErrors;
    }
}
