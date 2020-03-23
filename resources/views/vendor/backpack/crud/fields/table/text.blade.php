<!-- text input -->
<input class="form-control input-sm" type="text" ng-model="item.{{ $prop }}"
        @include('vendor.backpack.crud.inc.table_field_attributes')
>

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


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}
