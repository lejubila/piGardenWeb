<?php

namespace Backpack\CRUD\PanelTraits;

use Illuminate\Support\Collection;

trait Buttons
{
    // ------------
    // BUTTONS
    // ------------

    // TODO: $this->crud->reorderButtons('stack_name', ['one', 'two']);

    /**
     * Add a button to the CRUD table view.
     *
     * @param string      $stack           Where should the button be visible? Options: top, line, bottom.
     * @param string      $name            The name of the button. Unique.
     * @param string      $type            Type of button: view or model_function.
     * @param string      $content         The HTML for the button.
     * @param bool|string $position        Position on the stack: beginning or end. If false, the position will be
     *                                     'beginning' for the line stack or 'end' otherwise.
     * @param bool        $replaceExisting True if a button with the same name on the given stack should be replaced.
     *
     * @return \Backpack\CRUD\PanelTraits\CrudButton The new CRUD button.
     */
    public function addButton($stack, $name, $type, $content, $position = false, $replaceExisting = true)
    {
        if ($position == false) {
            switch ($stack) {
                case 'line':
                    $position = 'beginning';
                    break;

                default:
                    $position = 'end';
                    break;
            }
        }

        if ($replaceExisting) {
            $this->removeButton($name, $stack);
        }

        $button = new CrudButton($stack, $name, $type, $content);
        switch ($position) {
            case 'beginning':
                $this->buttons->prepend($button);
                break;

            default:
                $this->buttons->push($button);
                break;
        }

        return $button;
    }

    public function addButtonFromModelFunction($stack, $name, $model_function_name, $position = false)
    {
        $this->addButton($stack, $name, 'model_function', $model_function_name, $position);
    }

    public function addButtonFromView($stack, $name, $view, $position = false)
    {
        $view = 'crud::buttons.'.$view;

        $this->addButton($stack, $name, 'view', $view, $position);
    }

    /**
     * @return Collection
     */
    public function buttons()
    {
        return $this->buttons;
    }

    public function initButtons()
    {
        $this->buttons = collect();

        // line stack
        $this->addButton('line', 'show', 'view', 'crud::buttons.show', 'end');
        $this->addButton('line', 'update', 'view', 'crud::buttons.update', 'end');
        $this->addButton('line', 'revisions', 'view', 'crud::buttons.revisions', 'end');
        $this->addButton('line', 'clone', 'view', 'crud::buttons.clone', 'end');
        $this->addButton('line', 'delete', 'view', 'crud::buttons.delete', 'end');

        // top stack
        $this->addButton('top', 'create', 'view', 'crud::buttons.create');
        $this->addButton('top', 'reorder', 'view', 'crud::buttons.reorder');
    }

    /**
     * Modify the attributes of a button.
     *
     * @param  string $name          The button name.
     * @param  array  $modifications The attributes and their new values.
     *
     * @return CrudButton                The button that has suffered the changes, for daisychaining methods.
     */
    public function modifyButton($name, $modifications = null)
    {
        /**
         * @var CrudButton|null
         */
        $button = $this->buttons()->firstWhere('name', $name);

        if (! $button) {
            abort(500, 'CRUD Button "'.$name.'" not found. Please check the button exists before you modify it.');
        }

        if (is_array($modifications)) {
            foreach ($modifications as $key => $value) {
                $button->{$key} = $value;
            }
        }

        return $button;
    }

    /**
     * Remove a button from the CRUD panel.
     *
     * @param string $name  Button name.
     * @param string $stack Optional stack name.
     */
    public function removeButton($name, $stack = null)
    {
        $this->buttons = $this->buttons->reject(function ($button) use ($name, $stack) {
            return $stack == null ? $button->name == $name : ($button->stack == $stack) && ($button->name == $name);
        });
    }

    /**
     * @param array $names Button names
     * @param string|null $stack Optional stack name.
     */
    public function removeButtons($names, $stack = null)
    {
        if (! empty($names)) {
            foreach ($names as $name) {
                $this->removeButton($name, $stack);
            }
        }
    }

    public function removeAllButtons()
    {
        $this->buttons = collect([]);
    }

    public function removeAllButtonsFromStack($stack)
    {
        $this->buttons = $this->buttons->reject(function ($button) use ($stack) {
            return $button->stack == $stack;
        });
    }

    public function removeButtonFromStack($name, $stack)
    {
        $this->buttons = $this->buttons->reject(function ($button) use ($name, $stack) {
            return $button->name == $name && $button->stack == $stack;
        });
    }
}

class CrudButton
{
    public $stack;
    public $name;
    public $type = 'view';
    public $content;

    public function __construct($stack, $name, $type, $content)
    {
        $this->stack = $stack;
        $this->name = $name;
        $this->type = $type;
        $this->content = $content;
    }
}
