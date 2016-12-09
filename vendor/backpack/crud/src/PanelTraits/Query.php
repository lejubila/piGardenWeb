<?php

namespace Backpack\CRUD\PanelTraits;

trait Query
{
    // ----------------
    // ADVANCED QUERIES
    // ----------------

    /**
     * Add another clause to the query (for ex, a WHERE clause).
     *
     * Examples:
     * // $this->crud->addClause('active');
     * $this->crud->addClause('type', 'car');
     * $this->crud->addClause('where', 'name', '==', 'car');
     * $this->crud->addClause('whereName', 'car');
     * $this->crud->addClause('whereHas', 'posts', function($query) {
     *     $query->activePosts();
     *     });
     *
     * @param [type]
     */
    public function addClause($function)
    {
        return call_user_func_array([$this->query, $function], array_slice(func_get_args(), 1, 3));
    }

    /**
     * Order the results of the query in a certain way.
     *
     * @param  [type]
     * @param  string
     *
     * @return [type]
     */
    public function orderBy($field, $order = 'asc')
    {
        return $this->query->orderBy($field, $order);
    }

    /**
     * Group the results of the query in a certain way.
     *
     * @param  [type]
     *
     * @return [type]
     */
    public function groupBy($field)
    {
        return $this->query->groupBy($field);
    }

    /**
     * Limit the number of results in the query.
     *
     * @param  [number]
     *
     * @return [type]
     */
    public function limit($number)
    {
        return $this->query->limit($number);
    }
}
