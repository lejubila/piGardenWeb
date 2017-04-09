@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <!--
          <div class="pull-left image">
            <img src="http://placehold.it/160x160/00a65a/ffffff/&text={{ Auth::user()->name[0] }}" class="img-circle" alt="User Image">
          </div>
          -->
          <!-- div class="pull-left info" -->
          <div class="info text-center" style="position:static; padding:5px;">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

          <li class="header">{{ strtoupper(trans('pigarden.zones')) }}</li>
          @forelse( \App\Zones::get() as $zone )
          <li><a href="{{route('zone.edit', ['zone' => $zone->name])}}" class="link-zone-{{$zone->name}}"><i class="fa {{$zone->state == 0 ? 'fa-toggle-off' : 'fa-toggle-on'}}"></i> <span>{{$zone->name_stripped}}</span></a></li>
          @empty
          <li><a><span><i>{{ trans('pigarden.zones_empty') }}</i></span></a></li>
          @endforelse

          <li class="header">{{ strtoupper(trans('pigarden.setup')) }}</li>
          <li><a href="{{route('initial_setup.get')}}"><i class="fa fa-cogs"></i> <span>{{ trans('pigarden.initial_setup.title') }}</span></a></li>

          <!-- <li><a href="{{ url('admin/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li> -->


          <!-- Users, Roles Permissions -->
<!--
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="{{ url('admin/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              <li><a href="{{ url('admin/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
            </ul>
          </li>
-->


          <!-- ======================================= -->
          <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> <span>{{trans('pigarden.users')}}</span></a></li>
          <li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
