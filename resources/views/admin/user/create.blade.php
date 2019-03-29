
@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1>{{ trans('admin/users.add_new') }}</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
    </div>
</div>

{!! Form::open(array('files' => true, 'route' => 'users.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')) !!}
@if( Gate::check('isOrgAdmin', Auth::user()))
    {!! Form::hidden('fk_users_role', config('user_roles.tutor_role_id'), ['class' => 'form-control', 'id' => 'fk_users_role']) !!}
    
@else
    <div class="form-group">
        {!! Form::label('fk_users_role', 'User Type', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('fk_users_role', $aUserRole, null, ['class' => 'form-control', 'onchange' => 'handleUser()']) !!}
        </div>
    </div>
@endif

<div class="form-group">
    {!! Form::label('first_name', 'First Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('first_name', old('first_name'), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('last_name', 'Last Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('last_name', old('last_name'), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('email', 'Email', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="org_tutor_wrapper hide">
    @if( Gate::check('isOrgAdmin', Auth::user()))
        
    @else
        <div class="form-group">
            {!! Form::label('organisation', 'Organisation', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('organisation', $aOrganisation, null, ['class' => 'form-control']) !!}
            </div> 
        </div>
    @endif
</div>

<div class="tutor_wrapper hide">
    <div class="form-group">
        {!! Form::label('title', 'Tutor Type', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('tutor_type', config('app_constants.tutor_type'), null, ['class' => 'form-control']) !!}
        </div> 
    </div>
    <div class="form-group">
        {!! Form::label('expiry', 'Expiry Date', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::date('expiry', old('expiry'), ['class' => 'form-control']) !!}
        </div> 
    </div>
    <div class="form-group">
        {!! Form::label('year_trained', 'Year Trained', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('year_trained', config('app_constants.training_year'), null, ['class' => 'form-control']) !!}
        </div> 
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        {!! Form::submit(trans('admin/users.save'), array('class' => 'btn btn-primary')) !!}
        {!! link_to_route('users.index', trans('admin/users.cancel'), null, array('class' => 'btn btn-default')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection
@section('javascript')
<script>
    function handleUser() {
        var userTypeVal = $('#fk_users_role').val();
        //console.log(userTypeVal);
        showhidefields(userTypeVal);
        
    }
    function showhidefields(userTypeVal) {
        $('.tutor_wrapper').addClass("hide");
        $('.org_tutor_wrapper').addClass("hide");
        var dateControl = document.querySelector('input[type="date"]');
        dateControl.value = '';
        if (userTypeVal == 3) {
            $('.org_tutor_wrapper').removeClass("hide");
        } else {
            if (userTypeVal == 4) {
                $('.tutor_wrapper').removeClass("hide");
                $('.org_tutor_wrapper').removeClass("hide");
            }
        }
    }
    $( window ).load(function() {
        // Run code
        handleUser();
    });
</script>
@endsection
