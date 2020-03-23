<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

<li class="header">{{ strtoupper(trans('pigarden.zones')) }}</li>
@forelse( \App\Zones::get() as $zone )
    <li><a href="{{route('zone.edit', ['zone' => $zone->name])}}" class="link-zone-{{$zone->name}}"><i class="fa {{$zone->state == 0 ? 'fa-toggle-off' : 'fa-toggle-on'}}"></i> <span>{{$zone->name_stripped}}</span></a></li>
@empty
    <li><a><span><i>{{ trans('pigarden.zones_empty') }}</i></span></a></li>
@endforelse

<li class="header">{{ strtoupper(trans('pigarden.setup')) }}</li>
<li><a href="{{route('initial_setup.get')}}"><i class="fa fa-cogs"></i> <span>{{ trans('pigarden.initial_setup.title') }}</span></a></li>
<li><a href="{{backpack_url('icon')}}"><i class="fa fa-picture-o"></i> <span>{{ trans('pigarden.setup_icons.title') }}</span></a></li>


<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>

<!-- Users, Roles Permissions -->
@if(
    config('backpack.permissionmanager.allow_manage_user') ||
    backpack_user()->hasPermissionTo('manage users')
)
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Perm</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
        @if(
            config('backpack.permissionmanager.allow_role_create') ||
            config('backpack.permissionmanager.allow_role_update') ||
            config('backpack.permissionmanager.allow_role_delete')
        )
        <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
        @endif
        @if(
            config('backpack.permissionmanager.allow_permission_create') ||
            config('backpack.permissionmanager.allow_permission_update') ||
            config('backpack.permissionmanager.allow_permission_delete')
        )
        <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
        @endif
    </ul>
</li>
@endif
