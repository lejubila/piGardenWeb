{{-- single relationships (1-1, 1-n) --}}
<td>
	<?php
		if ($entry->{$column['entity']}()->getResults()) {
	    	echo $entry->{$column['entity']}()->getResults()->{$column['attribute']};
	    }
	?>
</td>