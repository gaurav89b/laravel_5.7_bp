@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1>{{ trans('admin/users.edit') }}</h1>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
            </ul>
        </div>
        @endif
    </div>
</div>
{!! Form::model($users, array('files' => true, 'class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array('users.update', $users->id))) !!}

{!! Form::hidden('fk_users_role', $users->fk_users_role, null, ['class' => 'form-control']) !!}

<div class="form-group">
    {!! Form::label('fk_users_role', 'User Type', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('fk_users_role', $aUserRole, null, ['class' => 'form-control', 'disabled' => true]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('first_name', 'First Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('first_name', old('name',$users->first_name), ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('last_name', 'Last Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('last_name', old('last_name',$users->last_name), ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('email', 'Email', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::email('email', old('email',$users->email), ['class' => 'form-control', 'readonly' => 'readonly']) !!} 
    </div>
</div>
<div class="form-group">
    {!! Form::label('title', 'Status', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('is_active', config('app_constants.status_display'), null, ['class' => 'form-control']) !!}
    </div> 
</div>


<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="col-sm-2 control-label">Password</label>

    <div class="col-sm-10">
        <input id="password" type="password" class="form-control" name="password" >

        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="password-confirm" class="col-sm-2 control-label">Confirm Password</label>

    <div class="col-sm-10">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
    </div>
</div>

<div class="tutor_wrapper hide">
    <div class="form-group">
        {!! Form::label('title', 'Tutor Type', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('tutor_type', config('app_constants.tutor_type'), $users->tutor_type, ['class' => 'form-control']) !!}
        </div> 
    </div>
    <div class="form-group">
        {!! Form::label('year_trained', 'Year Trained', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('year_trained', config('app_constants.training_year'), $users->year_trained, ['class' => 'form-control']) !!}
        </div> 
    </div>
</div>
@if($users->fk_users_role == config('user_roles.tutor_role_id'))
<div class="form-group">
        {!! Form::label('xx', 'Pic Consent', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            
                @if($users->is_consent == 0)
                    Pending <span id='upload_pic' class='btn btn-xs btn-info'>Upload Pic</span>
                @else
                    Approved
                @endif
            
        </div> 
    </div>
    <div class='pic_consent hide'>
        <div class="form-group">
            {!! Form::label('image', 'Image', array('class'=>'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::file('image') !!}
                {!! Form::hidden('image_w', 4096) !!}
                {!! Form::hidden('image_h', 4096) !!}

            </div>
        </div>
    </div>
@endif
<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        {!! Form::submit(trans('admin/users.update'), array('class' => 'btn btn-primary')) !!}
        {!! link_to_route('users.index', trans('admin/users.cancel'), null, array('class' => 'btn btn-default')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection
@section('javascript')
<script>
    function handleUser() {
        var userTypeVal = $('#fk_users_role').val();
        
        showhidefields(userTypeVal);
        
    }
    function showhidefields(userTypeVal) {
        $('.tutor_wrapper').addClass("hide");
        $('.org_tutor_wrapper').addClass("hide");
        
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
    $( "#upload_pic" ).click(function() {
        $('.pic_consent').removeClass('hide');
    });
</script>
@endsection