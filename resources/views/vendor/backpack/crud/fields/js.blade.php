@push('crud_fields_scripts')
    @if(isset($field['view']) && \View::exists($field['view']))
        @include($field['view'])
    @endif
@endpush

