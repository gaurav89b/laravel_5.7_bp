@extends('admin.layouts.master')

@section('content')
<h1>{{ trans('admin/users.manage_users') }}</h1>
<p>{!! link_to_route('users.create', trans('admin/users.add_new') , null, array('class' => 'btn btn-success')) !!}</p>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
    </ul>
</div>
@endif
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">{{ trans('admin/users.list') }}</div>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive datatable table_layout_fixed users_table" id="datatable-users">
            <thead>
                <tr>
                    <th>User Id</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>User Type</th>
                    <th>Status</th>
                    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $aUserRole = config('user_roles.user_type');
                    $aStatus = config('app_constants.status_display');
                ?>
                @foreach ($users as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>
                        {{ $row->first_name . " " . $row->last_name  }}
                    </td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $aUserRole[$row->fk_users_role] }}</td>
                    <td>{{ $aStatus[$row->is_active] }}</td>
                    
                    <td>
                        {!! link_to_route('users.edit', trans('admin/users.edit'), array($row->id), array('class' => 'btn btn-xs btn-info')) !!}
                        {!! Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'onsubmit' => "return confirm('".trans("admin/users.are_you_sure")."');",  'route' => array('users.destroy', $row->id))) !!}
                        {!! Form::submit(trans('admin/users.delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    $('.hidden').hide();
    $('#datatable-users').dataTable({
        retrieve: true,
        "iDisplayLength": 100,
        "aaSorting": [],
        "order": [[ 0, "desc" ]],
    });
</script>
@stop