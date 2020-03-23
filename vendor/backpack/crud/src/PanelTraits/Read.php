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
     * Find and retrieve the id of the current entry.
     *
     * @return int|bool The id in the db or false.
     */
    public function getCurrentEntryId()
    {
        if ($this->entry) {
            return $this->entry->getKey();
        }

        $params = \Route::current()->parameters();

        return  // use the entity name to get the current entry
                // this makes sure the ID is corrent even for nested resources
                $this->request->input($this->entity_name) ??
                // otherwise use the next to last parameter
                array_values($params)[count($params) - 1] ??
                // otherwise return false
                false;
    }

    /**
     * Find and retrieve the current entry.
     *
     * @return \Illuminate\Database\Eloquent\Model|bool The row in the db or false.
     */
    public function getCurrentEntry()
    {
        $id = $this->getCurrentEntryId();

        if (! $id) {
            return false;
        }

        return $this->getEntry($id);
    }

    /**
     * Find and retrieve an entry in the database or fail.
     *
     * @param int The id of the row in the db to fetch.
     *
     * @return \Illuminate\Database\Eloquent\Model The row in the db.
     */
    public function getEntry($id)
    {
        if (! $this->entry) {
            $this->entry = $this->model->findOrFail($id);
            $this->entry = $this->entry->withFakes();
        }

        return $this->entry;
    }

    /**
     * Find and retrieve an entry in the database or fail.
     *
     * @param int The id of the row in the db to fetch.
     *
     * @return \Illuminate\Database\Eloquent\Model The row in the db.
     */
    public function getEntryWithoutFakes($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Make the query JOIN all relationships used in the columns, too,
     * so there will be less database queries overall.
     */
    public function autoEagerLoadRelationshipColumns()
    {
        $relationships = $this->getColumnsRelationships();

        if (count($relationships)) {
            $this->with($relationships);
        }
    }

    /**
     * Get all entries from the database.
     *
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getEntries()
    {
        $this->autoEagerLoadRelationshipColumns();

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
     * @param  string   $form create/update/both - defaults to 'both'
     * @param  bool|int $id   the ID of the entity to be edited in the Update form
     *
     * @return array all the fields that need to be shown and their information
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
     * Check if the create/update form has upload fields.
     * Upload fields are the ones that have "upload" => true defined on them.
     *
     * @param  string   $form create/update/both - defaults to 'both'
     * @param  bool|int $id   id of the entity - defaults to false
     *
     * @return bool
     */
    public function hasUploadFields($form, $id = false)
    {
        $fields = $this->getFields($form, $id);
        $upload_fields = array_where($fields, function ($value, $key) {
            return isset($value['upload']) && $value['upload'] == true;
        });

        return count($upload_fields) ? true : false;
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
     * Add two more columns at the beginning of the ListEntrie table:
     * - one shows the checkboxes needed for bulk actions
     * - one is blank, in order for evenual details_row or expand buttons
     * to be in a separate column.
     */
    public function enableBulkActions()
    {
        $this->bulk_actions = true;

        $this->addColumn([
            'type' => 'checkbox',
            'name' => 'bulk_actions',
            'label' => ' <input type="checkbox" class="crud_bulk_actions_main_checkbox" style="width: 16px; height: 16px;" />',
            'priority' => 1,
            'searchLogic' => false,
            'orderable' => false,
            'visibleInTable' => true,
            'visibleInModal' => false,
            'visibleInExport' => false,
            'visibleInShow' => false,
        ])->makeFirstColumn();

        $this->addColumn([
            'type' => 'custom_html',
            'name' => 'blank_first_column',
            'label' => ' ',
            'priority' => 1,
            'searchLogic' => false,
            'orderable' => false,
            'visibleInTabel' => true,
            'visibleInModal' => false,
            'visibleInExport' => false,
            'visibleInShow' => false,
        ])->makeFirstColumn();
    }

    /**
     * Remove the two columns needed for bulk actions.
     */
    public function disableBulkActions()
    {
        $this->bulk_actions = false;

        $this->removeColumn('bulk_actions');
        $this->removeColumn('blank_first_column');
    }

    /**
     * Set the number of rows that should be show on the list view.
     */
    public function setDefaultPageLength($value)
    {
        $this->default_page_length = $value;
    }

    /**
     * Get the number of rows that should be show on the list view.
     *
     * @return int
     */
    public function getDefaultPageLength()
    {
        // return the custom value for this crud panel, if set using setDefaultPageLength()
        if ($this->default_page_length) {
            return $this->default_page_length;
        }

        // otherwise return the default value in the config file
        if (config('backpack.crud.default_page_length')) {
            return config('backpack.crud.default_page_length');
        }

        return 25;
    }

    /**
     * If a custom page length was specified as default, make sure it
     * also show up in the page length menu.
     */
    public function addCustomPageLengthToPageLengthMenu()
    {
        // If the default Page Length isn't in the menu's values, Add it the beginnin and resort all to show a croissant list.
        // assume both array are the same lenght.
        if (! in_array($this->getDefaultPageLength(), $this->page_length_menu[0])) {
            // Loop through 2 arrays of prop. page_length_menu
            foreach ($this->page_length_menu as $key => &$page_length_choices) {
                // This is a condition that should be always true.
                if (is_array($page_length_choices)) {
                    array_unshift($page_length_choices, $this->getDefaultPageLength());
                }
            }
        }
    }

    /**
     * Specify array of available page lengths on the list view.
     *
     * @param array $menu  1d array of page length values,
     *                     or 2d array (first array: page length values, second array: page length labels)
     *                     More at: https://datatables.net/reference/option/lengthMenu
     */
    public function setPageLengthMenu($menu)
    {
        $this->page_length_menu = $menu;
    }

    /**
     * Get page length menu for the list view.
     *
     * @return array
     */
    public function getPageLengthMenu()
    {
        // if already set, use that
        if (! $this->page_length_menu) {
            // try to get the menu settings from the config file
            if (! $this->page_length_menu = config('backpack.crud.page_length_menu')) {
                // otherwise set a sensible default
                $this->page_length_menu = [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'backpack::crud.all']];
            }
            // if we have a 2D array, update all the values in the right hand array to their translated values
            if (isset($this->page_length_menu[1]) && is_array($this->page_length_menu[1])) {
                foreach ($this->page_length_menu[1] as $key => $val) {
                    $this->page_length_menu[1][$key] = trans($val);
                }
            }
        }

        $this->addCustomPageLengthToPageLengthMenu();

        return $this->page_length_menu;
    }

    /*
    |--------------------------------------------------------------------------
    |                                EXPORT BUTTONS
    |--------------------------------------------------------------------------
    */

    /**
     * Tell the list view to show the DataTables export buttons.
     */
    public function enableExportButtons()
    {
        $this->export_buttons = true;
    }

    /**
     * Check if export buttons are enabled for the table view.
     * @return bool
     */
    public function exportButtons()
    {
        return $this->export_buttons;
    }
}
