{{-- localized datetime using jenssegers/date --}}
<td data-order="{{ $entry->{$column['name']} }}">
	{{ Date::parse($entry->{$column['name']})->format(config('backpack.base.default_datetime_format')) }}
</td>