{{-- relationships with pivot table (n-n) --}}
<td>
    <?php
        $results = $entry->{$column['entity']}()->getResults();

        if ($results && $results->count()) {
            $results_array = $results->pluck($column['attribute'], 'id');
            echo implode(', ', $results_array->toArray());
        } else {
            echo '-';
        }
    ?>
</td>