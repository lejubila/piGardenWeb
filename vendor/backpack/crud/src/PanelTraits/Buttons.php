<?php

namespace Backpack\CRUD\PanelTraits;

trait Buttons
{
    // ------------
    // BUTTONS
    // ------------

    // TODO: $this->crud->reorderButtons('stack_name', ['one', 'two']);

    /**
     * Add a button to the CRUD table view.
     * @param string $stack    Where should the button be visible? Options: top, line, bottom
     * @param string $name     The name of the button. Unique.
     * @param string $type     Type of button: view or model_function
     * @param string $content  The HTML for the button
     * @param string $position Where in the stack it should be placed: beginning or end
     */
    public function addButton($stack, $name, $type, $content, $position = false)
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

        switch ($position) {
            case 'beginning':
                $this->buttons->prepend(new CrudButton($stack, $name, $type, $content));
                break;

            default:
                $this->buttons->push(new CrudButton($stack, $name, $type, $content));
                break;
        }
    }

    public function addButtonFromModelFunction($stack, $name, $model_function_name, $position = false)
    {
        $this->addButton($stack, $name, 'model_function', $model_function_name, $position);
    }

    public function addButtonFromView($stack, $name, $view, $position = false)
    {
        $view = 'vendor.backpack.crud.buttons.'.$view;

        $this->addButton($stack, $name, 'view', $view, $position);
    }

    public function buttons()
    {
        return $this->buttons;
    }

    public function initButtons()
    {
        $this->buttons = collect();

        // line stack
        $this->addButton('line', 'preview', 'view', 'crud::buttons.preview', 'end');
        $this->addButton('line', 'update', 'view', 'crud::buttons.update', 'end');
        $this->addButton('line', 'delete', 'view', 'crud::buttons.delete', 'end');

        // top stack
        $this->addButton('top', 'create', 'view', 'crud::buttons.create');
        $this->addButton('top', 'reorder', 'view', 'crud::buttons.reorder');
    }

    public function removeButton($name)
    {
        $this->buttons->reject(function ($button) {
            return $button->name == $name;
        });
    }

    public function removeButtonFromStack($name, $stack)
    {
        $this->buttons->reject(function ($button) {
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
