<?php

namespace Backpack\CRUD\PanelTraits;

trait Delete
{
    /*
    |--------------------------------------------------------------------------
    |                                   DELETE
    |--------------------------------------------------------------------------
    */

    /**
     * Delete a row from the database.
     *
     * @param  [int] The id of the item to be deleted.
     * @param int $id
     *
     * @return [bool] Deletion confirmation.
     *
     * TODO: should this delete items with relations to it too?
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
