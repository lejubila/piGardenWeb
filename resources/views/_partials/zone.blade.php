            <?php
            $arr_cron_in_start = config('pigarden.cron_in.start');
            $arr_cron_in_length = config('pigarden.cron_in.length');
            ?>
            <div class="box box-primary box-zone" id="box-zone-{{ $zone->name }}">
                <div class="box-header with-border text-center">
                    <div class="box-title">{{ $zone->name_stripped }}</div>
                </div>
                <div class="box-body text-center">
                    <!-- Split button -->
                    @if (!isset($showButton) || $showButton)
                    <div class="btn-group btn-group-zone">
                        <a class="btn btn-app btn-zone" id="btn-zone-{{ $zone->name }}" href="{{ $zone->actionHref }}" style="margin-bottom: 0px;">
                            <i class="fa {{ $zone->actionButtonClass }}"></i> <span class="button-zone-text">{{ $zone->actionButtonText }}</span>
                        </a>
                        <button type="button"
                            class="btn btn-app dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="min-width: auto; padding: 1px 5px; margin-bottom:0px;"
                            {{ $zone->state > 0 ? 'disabled' : '' }}
                        >
                            <span class="glyphicon glyphicon-time {{ !empty($cron_open_in[$zone->name]) ? 'text-danger' : '' }}" aria-hidden="true"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach( $arr_cron_in_start as $cron_in_start )
                            <li class="open_in_start dropdown dropdown-submenu {{ !empty($cron_open_in[$zone->name]) ? 'hidden' : '' }}">
                                <a href="#" class="dropdown-toggle-zone" data-toggle="dropdown">{{ trans("pigarden.cron_in.start.$cron_in_start") }}</a>
                                <ul class="dropdown-menu">
                                    @foreach( $arr_cron_in_length as $cron_in_length )
                                    <li>
                                        <a class="btn-zone-open-in btn-zone-open-in-{{ $zone->name }}"
                                            href="{{ route( 'zone.play_in', ['zone' => $zone->name, 'start' => $cron_in_start, 'length' => $cron_in_length ]) }}">
                                        {{ trans("pigarden.cron_in.length.$cron_in_length") }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                            <li class="open_in_set {{ empty($cron_open_in[$zone->name]) ? 'hidden' : '' }}" style="position:relative;">
                                <a class="btn-zone-open-in-cancel btn-zone-open-in-cancel-{{ $zone->name }}" href="{{ route( 'zone.play_in_cancel', ['zone' => $zone->name] ) }}">
                                    <i><span class="text-danger"><span id="text-btn-zone-open-in-cancel-{{ $zone->name }}">{!! isset($cron_open_in[$zone->name]) ? $cron_open_in[$zone->name] : '' !!}</span> &nbsp;<span class="glyphicon glyphicon-remove-circle" style="position: absolute;top: 50%;right: 5px;margin-top: -7px;" aria-hidden="true"></span></span></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                    <!-- -->

                    @if (isset($showButton) && !$showButton)
                    <!-- <div class="text-danger pull-right"><br/><i>{!! isset($cron_open_in[$zone->name]) ? $cron_open_in[$zone->name] : '' !!}</i></div> -->
                    @endif

                    <img id="btn-zone-image-{{ $zone->name }}" class="sprinkler" src="{{ $zone->imageSrc }}" alt="sprinkler" />

                    @if (false || isset($showButton) && !$showButton && !empty($cron_open_in[$zone->name]))
                    &nbsp;&nbsp;
                    <span class="dropdown">
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuInfoIn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-time text-danger" aria-hidden="true"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuInfoIn" style="right: 0px; top: 27px; left: auto;">
                        <li><a href="#"><i class="text-danger">{!! $cron_open_in[$zone->name] !!}</i></a></li>
                      </ul>
                    </span>
                    @endif

                    @if (isset($showButton) && !$showButton)
                    &nbsp;&nbsp;
                    <span class="dropdown hidden">
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuInfoIn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-time text-danger" aria-hidden="true"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuInfoIn" style="right: 0px; top: 27px; left: auto;">
                        <li><a href="#"><i class="text-danger"><span id="text-btn-zone-open-in-cancel-{{ $zone->name }}"></span></i></a></li>
                      </ul>
                    </span>
                    @endif





                    @if(isset($force) && $force)
                    <div style="max-width:180px; margin:0 auto;">
                        <input class="icheck force_open" name="force_open_{{$zone->name}}" id="force_open_{{$zone->name}}" type="checkbox" value="1">
                        <label>{{ trans('pigarden.force_open_with_rain') }}</label>
                    </div>
                    @endif
                </div>
            </div>
