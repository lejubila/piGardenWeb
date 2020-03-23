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
     * @param string|array $field The new field.
     * @param string       $form  The CRUD form. Can be 'create', 'update' or 'both'. Default is 'both'.
     *
     * @return self
     */
    public function addField($field, $form = 'both')
    {
        // if the field_definition_array array is a string, it means the programmer was lazy and has only passed the name
        // set some default values, so the field will still work
        if (is_string($field)) {
            $completeFieldsArray['name'] = $field;
        } else {
            $completeFieldsArray = $field;
        }

        // if this is a relation type field and no corresponding model was specified, get it from the relation method
        // defined in the main model
        if (isset($completeFieldsArray['entity']) && ! isset($completeFieldsArray['model'])) {
            $completeFieldsArray['model'] = $this->getRelationModel($completeFieldsArray['entity']);
        }

        // if the label is missing, we should set it
        if (! isset($completeFieldsArray['label'])) {
            $completeFieldsArray['label'] = mb_ucfirst(str_replace('_', ' ', $completeFieldsArray['name']));
        }

        // if the field type is missing, we should set it
        if (! isset($completeFieldsArray['type'])) {
            $completeFieldsArray['type'] = $this->getFieldTypeFromDbColumnType($completeFieldsArray['name']);
        }

        // if a tab was mentioned, we should enable it
        if (isset($completeFieldsArray['tab'])) {
            if (! $this->tabsEnabled()) {
                $this->enableTabs();
            }
        }

        $this->transformFields($form, function ($fields) use ($completeFieldsArray) {
            $fields[$completeFieldsArray['name']] = $completeFieldsArray;

            return $fields;
        });

        return $this;
    }

    /**
     * Add multiple fields to the create/update form or both.
     *
     * @param array  $fields The new fields.
     * @param string $form   The CRUD form. Can be 'create', 'update' or 'both'. Default is 'both'.
     */
    public function addFields($fields, $form = 'both')
    {
        if (count($fields)) {
            foreach ($fields as $field) {
                $this->addField($field, $form);
            }
        }
    }

    /**
     * Move the most recently added field after the given target field.
     *
     * @param string $targetFieldName The target field name.
     * @param string $form            The CRUD form. Can be 'create', 'update' or 'both'. Default is 'both'.
     */
    public function afterField($targetFieldName, $form = 'both')
    {
        $this->transformFields($form, function ($fields) use ($targetFieldName) {
            return $this->moveField($fields, $targetFieldName, false);
        });
    }

    /**
     * Move the most recently added field before the given target field.
     *
     * @param string $targetFieldName The target field name.
     * @param string $form            The CRUD form. Can be 'create', 'update' or 'both'. Default is 'both'.
     */
    public function beforeField($targetFieldName, $form = 'both')
    {
        $this->transformFields($form, function ($fields) use ($targetFieldName) {
            return $this->moveField($fields, $targetFieldName, true);
        });
    }

    /**
     * Move the most recently added field before or after the given target field. Default is before.
     *
     * @param array  $fields          The form fields.
     * @param string $targetFieldName The target field name.
     * @param bool   $before          If true, the field will be moved before the target field, otherwise it will be moved after it.
     *
     * @return array
     */
    private function moveField($fields, $targetFieldName, $before = true)
    {
        if (array_key_exists($targetFieldName, $fields)) {
            $targetFieldPosition = $before ? array_search($targetFieldName, array_keys($fields))
                : array_search($targetFieldName, array_keys($fields)) + 1;

            if ($targetFieldPosition >= (count($fields) - 1)) {
                // target field name is same as element
                return $fields;
            }

            $element = array_pop($fields);
            $beginningArrayPart = array_slice($fields, 0, $targetFieldPosition, true);
            $endingArrayPart = array_slice($fields, $targetFieldPosition, null, true);

            $fields = array_merge($beginningArrayPart, [$element['name'] => $element], $endingArrayPart);
        }

        return $fields;
    }

    /**
     * Remove a certain field from the create/update/both forms by its name.
     *
     * @param string $name Field name (as defined with the addField() procedure)
     * @param string $form update/create/both
     */
    public function removeField($name, $form = 'both')
    {
        $this->transformFields($form, function ($fields) use ($name) {
            array_forget($fields, $name);

            return $fields;
        });
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
     * Remove all fields from the create/update/both forms.
     *
     * @param string $form update/create/both
     */
    public function removeAllFields($form = 'both')
    {
        $current_fields = $this->getCurrentFields();
        if (! empty($current_fields)) {
            foreach ($current_fields as $field) {
                $this->removeField($field['name'], $form);
            }
        }
    }

    /**
     * Update value of a given key for a current field.
     *
     * @param string $field         The field
     * @param array  $modifications An array of changes to be made.
     * @param string $form          update/create/both
     */
    public function modifyField($field, $modifications, $form = 'both')
    {
        foreach ($modifications as $key => $newValue) {
            switch (strtolower($form)) {
          case 'create':
              $this->create_fields[$field][$key] = $newValue;
              break;

          case 'update':
              $this->update_fields[$field][$key] = $newValue;
              break;

          default:
              $this->create_fields[$field][$key] = $newValue;
              $this->update_fields[$field][$key] = $newValue;
              break;
        }
        }
    }

    /**
     * Set label for a specific field.
     *
     * @param string $field
     * @param string $label
     */
    public function setFieldLabel($field, $label)
    {
        if (isset($this->create_fields[$field])) {
            $this->create_fields[$field]['label'] = $label;
        }
        if (isset($this->update_fields[$field])) {
            $this->update_fields[$field]['label'] = $label;
        }
    }

    /**
     * Check if field is the first of its type in the given fields array.
     * It's used in each field_type.blade.php to determine wether to push the css and js content or not (we only need to push the js and css for a field the first time it's loaded in the form, not any subsequent times).
     *
     * @param array $field        The current field being tested if it's the first of its type.
     *
     * @return bool true/false
     */
    public function checkIfFieldIsFirstOfItsType($field)
    {
        $fields_array = $this->getCurrentFields();
        $first_field = $this->getFirstOfItsTypeInArray($field['type'], $fields_array);

        if ($field['name'] == $first_field['name']) {
            return true;
        }

        return false;
    }

    /**
     * Decode attributes that are casted as array/object/json in the model.
     * So that they are not json_encoded twice before they are stored in the db
     * (once by Backpack in front-end, once by Laravel Attribute Casting).
     */
    public function decodeJsonCastedAttributes($data, $form, $id = false)
    {
        // get the right fields according to the form type (create/update)
        $fields = $this->getFields($form, $id);
        $casted_attributes = $this->model->getCastedAttributes();

        foreach ($fields as $field) {

            // Test the field is castable
            if (isset($field['name']) && array_key_exists($field['name'], $casted_attributes)) {

                // Handle JSON field types
                $jsonCastables = ['array', 'object', 'json'];
                $fieldCasting = $casted_attributes[$field['name']];

                if (in_array($fieldCasting, $jsonCastables) && isset($data[$field['name']]) && ! empty($data[$field['name']]) && ! is_array($data[$field['name']])) {
                    try {
                        $data[$field['name']] = json_decode($data[$field['name']]);
                    } catch (\Exception $e) {
                        $data[$field['name']] = [];
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getCurrentFields()
    {
        if ($this->entry) {
            return $this->getUpdateFields($this->entry->getKey());
        }

        return $this->getCreateFields();
    }

    /**
     * Order the CRUD fields in the given form. If certain fields are missing from the given order array, they will be
     * pushed to the new fields array in the original order.
     *
     * @param array  $order An array of field names in the desired order.
     * @param string $form  The CRUD form. Can be 'create', 'update' or 'both'.
     */
    public function orderFields($order, $form = 'both')
    {
        $this->transformFields($form, function ($fields) use ($order) {
            return $this->applyOrderToFields($fields, $order);
        });
    }

    /**
     * Apply the given order to the fields and return the new array.
     *
     * @param array $fields The fields array.
     * @param array $order  The desired field order array.
     *
     * @return array The ordered fields array.
     */
    private function applyOrderToFields($fields, $order)
    {
        $orderedFields = [];
        foreach ($order as $fieldName) {
            if (array_key_exists($fieldName, $fields)) {
                $orderedFields[$fieldName] = $fields[$fieldName];
            }
        }

        if (empty($orderedFields)) {
            return $fields;
        }

        $remaining = array_diff_key($fields, $orderedFields);

        return array_merge($orderedFields, $remaining);
    }

    /**
     * Set the order of the CRUD fields.
     *
     * @param array $fields Fields order.
     *
     * @deprecated This method was not and will not be implemented since its a duplicate of the orderFields method.
     * @see        Fields::orderFields() to order the CRUD fields.
     */
    public function setFieldOrder($fields)
    {
        // not implemented
    }

    /**
     * Set the order of the CRUD fields.
     *
     * @param array $fields Fields order.
     *
     * @deprecated This method was not and will not be implemented since its a duplicate of the orderFields method.
     * @see        Fields::orderFields() to order the CRUD fields.
     */
    public function setFieldsOrder($fields)
    {
        $this->setFieldOrder($fields);
    }

    /**
     * Apply the given callback to the form fields.
     *
     * @param string   $form     The CRUD form. Can be 'create', 'update' or 'both'.
     * @param callable $callback The callback function to run for the given form fields.
     */
    private function transformFields($form, callable $callback)
    {
        switch (strtolower($form)) {
            case 'create':
                $this->create_fields = $callback($this->create_fields);
                break;

            case 'update':
                $this->update_fields = $callback($this->update_fields);
                break;

            default:
                $this->create_fields = $callback($this->create_fields);
                $this->update_fields = $callback($this->update_fields);
                break;
        }
    }
}
