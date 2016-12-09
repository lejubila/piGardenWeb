<?php

namespace Backpack\CRUD\PanelTraits;

trait FakeColumns
{
    /**
     * Returns an array of database columns names, that are used to store fake values.
     * Returns ['extras'] if no columns have been found.
     */
    public function getFakeColumnsAsArray($form = 'create')
    {
        $fake_field_columns_to_encode = [];

        // get the right fields according to the form type (create/update)
        switch (strtolower($form)) {
            case 'update':
                $fields = $this->update_fields;
                break;

            default:
                $fields = $this->create_fields;
                break;
        }

        foreach ($fields as $k => $field) {
            // if it's a fake field
            if (isset($fields[$k]['fake']) && $fields[$k]['fake'] == true) {
                // add it to the request in its appropriate variable - the one defined, if defined
                if (isset($fields[$k]['store_in'])) {
                    if (! in_array($fields[$k]['store_in'], $fake_field_columns_to_encode, true)) {
                        array_push($fake_field_columns_to_encode, $fields[$k]['store_in']);
                    }
                } else {
                    //otherwise in the one defined in the $crud variable

                    if (! in_array('extras', $fake_field_columns_to_encode, true)) {
                        array_push($fake_field_columns_to_encode, 'extras');
                    }
                }
            }
        }

        if (! count($fake_field_columns_to_encode)) {
            return ['extras'];
        }

        return $fake_field_columns_to_encode;
    }
}
