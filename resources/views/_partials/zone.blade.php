            <div class="box box-primary box-zone" id="box-zone-{{ $zone->name }}">
                <div class="box-header with-border text-center">
                    <div class="box-title">{{ $zone->name_stripped }}</div>
                </div>
                <div class="box-body text-center">
                    @if (!isset($showButton) || $showButton)
                    <a class="btn btn-app btn-zone" id="btn-zone-{{ $zone->name }}" href="{{ $zone->actionHref }}"><i class="fa {{ $zone->actionButtonClass }}"></i> <span class="button-zone-text">{{ $zone->actionButtonText }}</span></a>
                    @endif
                    <img id="btn-zone-image-{{ $zone->name }}" class="sprinkler" src="{{ $zone->imageSrc }}" alt="sprinkler" />
                    @if(isset($force) && $force)
                    <div style="max-width:180px; margin:0 auto;">
                        <input class="icheck force_open" name="force_open_{{$zone->name}}" id="force_open_{{$zone->name}}" type="checkbox" value="1">
                        <label>{{ trans('pigarden.force_open_with_rain') }}</label>
                    </div>
                    @endif
                </div>
            </div>
