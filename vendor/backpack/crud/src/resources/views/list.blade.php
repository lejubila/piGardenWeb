@extends('backpack::layout')

@section('after_styles')
	<!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
	    <small>{{ trans('backpack::crud.all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span> {{ trans('backpack::crud.in_the_database') }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->
  <div class="box">
    <div class="box-header {{ $crud->hasAccess('create')?'with-border':'' }}">

      @include('crud::inc.button_stack', ['stack' => 'top'])

    </div>
    <div class="box-body">

		<table id="crudTable" class="table table-bordered table-striped display">
        <thead>
          <tr>
            @if ($crud->details_row)
              <th></th> <!-- expand/minimize button column -->
            @endif

            {{-- Table columns --}}
            @foreach ($crud->columns as $column)
              <th>{{ $column['label'] }}</th>
            @endforeach

            @if ( $crud->buttons->where('stack', 'line') )
              <th>{{ trans('backpack::crud.actions') }}</th>
            @endif
          </tr>
        </thead>
        <tbody>

          @if (!$crud->ajaxTable())
            @foreach ($entries as $k => $entry)
            <tr data-entry-id="{{ $entry->getKey() }}">

              @if ($crud->details_row)
                @include('crud::columns.details_row_button')
              @endif

              {{-- load the view from the application if it exists, otherwise load the one in the package --}}
              @foreach ($crud->columns as $column)
                @if (!isset($column['type']))
                  @include('crud::columns.text')
                @else
                  @if(view()->exists('vendor.backpack.crud.columns.'.$column['type']))
                    @include('vendor.backpack.crud.columns.'.$column['type'])
                  @else
                    @if(view()->exists('crud::columns.'.$column['type']))
                      @include('crud::columns.'.$column['type'])
                    @else
                      @include('crud::columns.text')
                    @endif
                  @endif
                @endif

              @endforeach

              @if ($crud->buttons->where('stack', 'line')->count())
                <td>
                  @include('crud::inc.button_stack', ['stack' => 'line'])
                </td>
              @endif

            </tr>
            @endforeach
          @endif

        </tbody>
        <tfoot>
          <tr>
            @if ($crud->details_row)
              <th></th> <!-- expand/minimize button column -->
            @endif

            {{-- Table columns --}}
            @foreach ($crud->columns as $column)
              <th>{{ $column['label'] }}</th>
            @endforeach

            @if ( $crud->buttons->where('stack', 'line') )
              <th>{{ trans('backpack::crud.actions') }}</th>
            @endif
          </tr>
        </tfoot>
      </table>

    </div><!-- /.box-body -->

    @include('crud::inc.button_stack', ['stack' => 'bottom'])

  </div><!-- /.box -->
@endsection

@section('after_scripts')
	<!-- DATA TABES SCRIPT -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
	  jQuery(document).ready(function($) {
	  	var table = $("#crudTable").DataTable({
        "pageLength": {{ $crud->getDefaultPageLength() }},
        "language": {
              "emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
              "info":           "{{ trans('backpack::crud.info') }}",
              "infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
              "infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
              "infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
              "thousands":      "{{ trans('backpack::crud.thousands') }}",
              "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
              "loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
              "processing":     "{{ trans('backpack::crud.processing') }}",
              "search":         "{{ trans('backpack::crud.search') }}",
              "zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
              "paginate": {
                  "first":      "{{ trans('backpack::crud.paginate.first') }}",
                  "last":       "{{ trans('backpack::crud.paginate.last') }}",
                  "next":       "{{ trans('backpack::crud.paginate.next') }}",
                  "previous":   "{{ trans('backpack::crud.paginate.previous') }}"
              },
              "aria": {
                  "sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
                  "sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
              }
          },

          @if ($crud->ajaxTable())
          "processing": true,
          "serverSide": true,
          "ajax": {
              "url": "{{ url($crud->route.'/search') }}",
              "type": "POST"
          },
          @endif
      });

      $.ajaxPrefilter(function(options, originalOptions, xhr) {
          var token = $('meta[name="csrf_token"]').attr('content');

          if (token) {
                return xhr.setRequestHeader('X-XSRF-TOKEN', token);
          }
      });

      // make the delete button work in the first result page
      register_delete_button_action();

      // make the delete button work on subsequent result pages
      $('#crudTable').on( 'draw.dt',   function () {
         register_delete_button_action();

         @if ($crud->details_row)
          register_details_row_button_action();
         @endif
      } ).dataTable();

      function register_delete_button_action() {
        $("[data-button-type=delete]").unbind('click');
        // CRUD Delete
        // ask for confirmation before deleting an item
        $("[data-button-type=delete]").click(function(e) {
          e.preventDefault();
          var delete_button = $(this);
          var delete_url = $(this).attr('href');

          if (confirm("{{ trans('backpack::crud.delete_confirm') }}") == true) {
              $.ajax({
                  url: delete_url,
                  type: 'DELETE',
                  success: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "{{ trans('backpack::crud.delete_confirmation_title') }}",
                          text: "{{ trans('backpack::crud.delete_confirmation_message') }}",
                          type: "success"
                      });
                      // delete the row from the table
                      delete_button.parentsUntil('tr').parent().remove();
                  },
                  error: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "{{ trans('backpack::crud.delete_confirmation_not_title') }}",
                          text: "{{ trans('backpack::crud.delete_confirmation_not_message') }}",
                          type: "warning"
                      });
                  }
              });
          } else {
              new PNotify({
                  title: "{{ trans('backpack::crud.delete_confirmation_not_deleted_title') }}",
                  text: "{{ trans('backpack::crud.delete_confirmation_not_deleted_message') }}",
                  type: "info"
              });
          }
        });
      }


      @if ($crud->details_row)
      function register_details_row_button_action() {
        // Add event listener for opening and closing details
        $('#crudTable tbody').on('click', 'td .details-row-button', function () {
            var tr = $(this).closest('tr');
            var btn = $(this);
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                $(this).children('i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                $('div.table_row_slider', row.child()).slideUp( function () {
                    row.child.hide();
                    tr.removeClass('shown');
                } );
            }
            else {
                // Open this row
                $(this).children('i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                // Get the details with ajax
                $.ajax({
                  url: '{{ Request::url() }}/'+btn.data('entry-id')+'/details',
                  type: 'GET',
                  // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                  // data: {param1: 'value1'},
                })
                .done(function(data) {
                  // console.log("-- success getting table extra details row with AJAX");
                  row.child("<div class='table_row_slider'>" + data + "</div>", 'no-padding').show();
                  tr.addClass('shown');
                  $('div.table_row_slider', row.child()).slideDown();
                  register_delete_button_action();
                })
                .fail(function(data) {
                  // console.log("-- error getting table extra details row with AJAX");
                  row.child("<div class='table_row_slider'>{{ trans('backpack::crud.details_row_loading_error') }}</div>").show();
                  tr.addClass('shown');
                  $('div.table_row_slider', row.child()).slideDown();
                })
                .always(function(data) {
                  // console.log("-- complete getting table extra details row with AJAX");
                });
            }
        } );
      }

      register_details_row_button_action();
      @endif


	  });
	</script>
@endsection
