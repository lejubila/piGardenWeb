<?php

namespace Backpack\CRUD\PanelTraits;

trait AutoFocus
{
    public $autoFocusOnFirstField = true;

    /**
     * @return bool
     */
    public function getAutoFocusOnFirstField()
    {
        return $this->autoFocusOnFirstField;
    }

    public function setAutoFocusOnFirstField($value)
    {
        return $this->autoFocusOnFirstField = (bool) $value;
    }

    public function enableAutoFocus()
    {
        return $this->setAutoFocusOnFirstField(true);
    }

    public function disableAutoFocus()
    {
        return $this->setAutoFocusOnFirstField(false);
    }
}
