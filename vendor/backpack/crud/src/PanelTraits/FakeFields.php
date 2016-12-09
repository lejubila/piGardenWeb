<?php

namespace Backpack\CRUD\PanelTraits;

trait FakeFields
{
    /**
     * Refactor the request array to something that can be passed to the model's create or update function.
     * The resulting array will only include the fields that are stored in the database and their values,
     * plus the '_token' and 'redirect_after_save' variables.
     *
     * @param Request $request - everything that was sent from the form, usually \Request::all()
     * @param string  $form    - create/update - to determine what fields should be compacted
     *
     * @return array
     */
    public function compactFakeFields($request, $form = 'create')
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

        // go through each defined field
        foreach ($fields as $k => $field) {
            // if it's a fake field
            if (isset($fields[$k]['fake']) && $fields[$k]['fake'] == true) {
                // add it to the request in its appropriate variable - the one defined, if defined
                if (isset($fields[$k]['store_in'])) {
                    $request[$fields[$k]['store_in']][$fields[$k]['name']] = $request[$fields[$k]['name']];

                    // remove the fake field
                    array_pull($request, $fields[$k]['name']);

                    if (! in_array($fields[$k]['store_in'], $fake_field_columns_to_encode, true)) {
                        array_push($fake_field_columns_to_encode, $fields[$k]['store_in']);
                    }
                } else {
                    //otherwise in the one defined in the $crud variable

                    $request['extras'][$fields[$k]['name']] = $request[$fields[$k]['name']];

                    // remove the fake field
                    array_pull($request, $fields[$k]['name']);

                    if (! in_array('extras', $fake_field_columns_to_encode, true)) {
                        array_push($fake_field_columns_to_encode, 'extras');
                    }
                }
            }
        }

        // json_encode all fake_value columns in the database, so they can be properly stored and interpreted
        if (count($fake_field_columns_to_encode)) {
            foreach ($fake_field_columns_to_encode as $key => $value) {
                $request[$value] = json_encode($request[$value]);
            }
        }

        // if there are no fake fields defined, this will just return the original Request in full
        // since no modifications or additions have been made to $request
        return $request;
    }
}
