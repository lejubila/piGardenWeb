<?php

namespace Backpack\CRUD\PanelTraits;

trait Read
{
    /*
    |--------------------------------------------------------------------------
    |                                   READ
    |--------------------------------------------------------------------------
    */

    /**
     * Find and retrieve an entry in the database or fail.
     *
     * @param  [int] The id of the row in the db to fetch.
     *
     * @return [Eloquent Collection] The row in the db.
     */
    public function getEntry($id)
    {
        $entry = $this->model->findOrFail($id);

        return $entry->withFakes();
    }

    /**
     * Get all entries from the database.
     *
     * @return [Collection of your model]
     */
    public function getEntries()
    {
        $entries = $this->query->get();

        // add the fake columns for each entry
        foreach ($entries as $key => $entry) {
            $entry->addFakes($this->getFakeColumnsAsArray());
        }

        return $entries;
    }

    /**
     * Get the fields for the create or update forms.
     *
     * @param  [form] create / update / both - defaults to 'both'
     * @param  [integer] the ID of the entity to be edited in the Update form
     *
     * @return [array] all the fields that need to be shown and their information
     */
    public function getFields($form, $id = false)
    {
        switch (strtolower($form)) {
            case 'create':
                return $this->getCreateFields();
                break;

            case 'update':
                return $this->getUpdateFields($id);
                break;

            default:
                return $this->getCreateFields();
                break;
        }
    }

    /**
     * Enable the DETAILS ROW functionality:.
     *
     * In the table view, show a plus sign next to each entry.
     * When clicking that plus sign, an AJAX call will bring whatever content you want from the EntityCrudController::showDetailsRow($id) and show it to the user.
     */
    public function enableDetailsRow()
    {
        $this->details_row = true;
    }

    /**
     * Disable the DETAILS ROW functionality:.
     */
    public function disableDetailsRow()
    {
        $this->details_row = false;
    }

    /**
     * Set the number of rows that should be show on the table page (list view).
     */
    public function setDefaultPageLength($value)
    {
        $this->default_page_length = $value;
    }

    /**
     * Get the number of rows that should be show on the table page (list view).
     */
    public function getDefaultPageLength()
    {
        // return the custom value for this crud panel, if set using setPageLength()
        if ($this->default_page_length) {
            return $this->default_page_length;
        }

        // otherwise return the default value in the config file
        if (config('backpack.crud.default_page_length')) {
            return config('backpack.crud.default_page_length');
        }

        return 25;
    }

    /*
    |--------------------------------------------------------------------------
    |                                AJAX TABLE
    |--------------------------------------------------------------------------
    */

    /**
     * Tell the list view to use AJAX for loading multiple rows.
     */
    public function enableAjaxTable()
    {
        $this->ajax_table = true;
    }

    /**
     * Check if ajax is enabled for the table view.
     * @return bool
     */
    public function ajaxTable()
    {
        return $this->ajax_table;
    }

    /**
     * Get the HTML of the cells in a table row, for a certain DB entry.
     * @param  Entity $entry A db entry of the current entity;
     * @return array         Array of HTML cell contents.
     */
    public function getRowViews($entry)
    {
        $response = [];
        foreach ($this->columns as $key => $column) {
            $response[] = $this->getCellView($column, $entry);
        }

        return $response;
    }

    /**
     * Get the HTML of a cell, using the column types.
     * @param  array $column
     * @param  Entity $entry   A db entry of the current entity;
     * @return HTML
     */
    public function getCellView($column, $entry)
    {
        if (! isset($column['type'])) {
            return \View::make('crud::columns.text')->with('crud', $this)->with('column', $column)->with('entry', $entry)->render();
        } else {
            if (view()->exists('vendor.backpack.crud.columns.'.$column['type'])) {
                return \View::make('vendor.backpack.crud.columns.'.$column['type'])->with('crud', $this)->with('column', $column)->with('entry', $entry)->render();
            } else {
                if (view()->exists('crud::columns.'.$column['type'])) {
                    return \View::make('crud::columns.'.$column['type'])->with('crud', $this)->with('column', $column)->with('entry', $entry)->render();
                } else {
                    return \View::make('crud::columns.text')->with('crud', $this)->with('column', $column)->with('entry', $entry)->render();
                }
            }
        }
    }
}
