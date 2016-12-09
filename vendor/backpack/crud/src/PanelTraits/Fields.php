<?php

namespace Backpack\CRUD\PanelTraits;

trait Fields
{
    // ------------
    // FIELDS
    // ------------

    /**
     * Add a field to the create/update form or both.
     *
     * @param string   $form    The form to add the field to (create/update/both)
     */
    public function addField($field, $form = 'both')
    {
        // if the field_defition_array array is a string, it means the programmer was lazy and has only passed the name
        // set some default values, so the field will still work
        if (is_string($field)) {
            $complete_field_array['name'] = $field;
        } else {
            $complete_field_array = $field;
        }

        // if the label is missing, we should set it
        if (! isset($complete_field_array['label'])) {
            $complete_field_array['label'] = ucfirst($complete_field_array['name']);
        }

        // if the field type is missing, we should set it
        if (! isset($complete_field_array['type'])) {
            $complete_field_array['type'] = $this->getFieldTypeFromDbColumnType($complete_field_array['name']);
        }

        // store the field information into the correct variable on the CRUD object
        switch (strtolower($form)) {
            case 'create':
                $this->create_fields[$complete_field_array['name']] = $complete_field_array;
                break;

            case 'update':
                $this->update_fields[$complete_field_array['name']] = $complete_field_array;
                break;

            default:
                $this->create_fields[$complete_field_array['name']] = $complete_field_array;
                $this->update_fields[$complete_field_array['name']] = $complete_field_array;
                break;
        }
    }

    public function addFields($fields, $form = 'both')
    {
        if (count($fields)) {
            foreach ($fields as $field) {
                $this->addField($field, $form);
            }
        }
    }

    /**
     * Remove a certain field from the create/update/both forms by its name.
     *
     * @param string $name Field name (as defined with the addField() procedure)
     * @param string $form update/create/both
     */
    public function removeField($name, $form = 'both')
    {
        switch (strtolower($form)) {
            case 'create':
                array_forget($this->create_fields, $name);
                break;

            case 'update':
                array_forget($this->update_fields, $name);
                break;

            default:
                array_forget($this->create_fields, $name);
                array_forget($this->update_fields, $name);
                break;
        }
    }

    /**
     * Remove many fields from the create/update/both forms by their name.
     *
     * @param array  $array_of_names A simple array of the names of the fields to be removed.
     * @param string $form           update/create/both
     */
    public function removeFields($array_of_names, $form = 'both')
    {
        if (! empty($array_of_names)) {
            foreach ($array_of_names as $name) {
                $this->removeField($name, $form);
            }
        }
    }

    /**
     * Check if field is the first of its type in the given fields array.
     * It's used in each field_type.blade.php to determine wether to push the css and js content or not (we only need to push the js and css for a field the first time it's loaded in the form, not any subsequent times).
     *
     * @param array $field        The current field being tested if it's the first of its type.
     * @param array $fields_array All the fields in that particular form.
     *
     * @return bool true/false
     */
    public function checkIfFieldIsFirstOfItsType($field, $fields_array)
    {
        if ($field['name'] == $this->getFirstOfItsTypeInArray($field['type'], $fields_array)['name']) {
            return true;
        }

        return false;
    }

    /**
     * Order the fields in a certain way.
     *
     * @param [string] Column name.
     * @param [attributes and values array]
     */
    public function setFieldOrder($fields)
    {
        // TODO
    }

    // ALIAS of setFieldOrder($fields)
    public function setFieldsOrder($fields)
    {
        $this->setFieldOrder($fields);
    }

    // ------------
    // TONE FUNCTIONS - UNDOCUMENTED, UNTESTED, SOME MAY BE USED
    // ------------
    // TODO: check them

    public function orderFields($order)
    {
        $this->setSort('fields', (array) $order);
    }
}
