<!-- text input -->
<!--
<input class="form-control input-sm" type="text" ng-model="item.{{ $prop }}"
        @include('vendor.backpack.crud.inc.table_field_attributes')
>
-->

<div class="input-group table-field-combobox-from-array">
    <input type="text"
           class="form-control input-sm"
           ng-model="item.{{ $prop }}"
            @include('vendor.backpack.crud.inc.table_field_attributes')
    >

    <div class="input-group-btn btn-group-sm">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            @foreach($table_field_property['options'] as $k => $v)
                <li><a class="dropdown-item" href="#" data-key="{{$k}}">{{$v}}</a></li>
            @endforeach
        </ul>
    </div>

    <!--
    <div class="input-group-append">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">0</a>
            <a class="dropdown-item" href="#">1</a>
            <a class="dropdown-item" href="#">2</a>
            <a class="dropdown-item" href="#">3</a>
            <a class="dropdown-item" href="#">4</a>
            <a class="dropdown-item" href="#">5</a>
            <a class="dropdown-item" href="#">6</a>
            <a class="dropdown-item" href="#">12</a>
            <a class="dropdown-item" href="#">18</a>
            <a class="dropdown-item" href="#">24</a>
            <a class="dropdown-item" href="#">30</a>
        </div>
    </div>
    -->
</div>



{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

{{-- @push('crud_fields_styles')
    <!-- no styles -->
@endpush --}}


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

{{-- @push('crud_fields_scripts')
    <!-- no scripts -->
@endpush --}}


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if (!property_exists($crud, 'field_combobox_from_array_already_present'))
    @php
    $crud->field_combobox_from_array_already_present = 1;
    @endphp
    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script>
            jQuery(document).ready(function($) {
                $("div[ng-app='backPackTableApp']").on('click', '.table-field-combobox-from-array a.dropdown-item', function(e){
                    e.preventDefault();
                    var input = $($(this).parents('.input-group').get(0)).find('input');
                    input.val( $(this).data('key') );
                    input.trigger('change');
                });
            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
