@if (isset($table_field_property['attributes']))
    @foreach ($table_field_property['attributes'] as $attribute => $value)
        @if (is_string($attribute))
            {{ $attribute }}="{{ $value }}"
        @endif
    @endforeach

    @if (!isset($table_field_property['attributes']['class']))
        @if (isset($default_class))
            class="{{ $default_class }}"
        @else
            class="form-control"
        @endif
    @endif
@else
    @if (isset($default_class))
        class="{{ $default_class }}"
    @else
        class="form-control"
    @endif
@endif