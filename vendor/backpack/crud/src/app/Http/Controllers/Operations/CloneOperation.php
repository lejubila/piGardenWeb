<?php

namespace Backpack\CRUD\app\Http\Controllers\Operations;

trait CloneOperation
{
    /**
     * Create a duplicate of the current entry in the datatabase.
     *
     * @param int $id
     *
     * @return Response
     */
    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        $clonedEntry = $this->crud->model->findOrFail($id)->replicate();

        return (string) $clonedEntry->push();
    }

    /**
     * Create duplicates of multiple entries in the datatabase.
     *
     * @param int $id
     *
     * @return Response
     */
    public function bulkClone()
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');

        $entries = $this->request->input('entries');
        $clonedEntries = [];

        foreach ($entries as $key => $id) {
            if ($entry = $this->crud->model->find($id)) {
                $clonedEntries[] = $entry->replicate()->push();
            }
        }

        return $clonedEntries;
    }
}
