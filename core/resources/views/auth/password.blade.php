@extends('default')
@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
@if (count($errors) > 0)
{!! form_errors($errors) !!}
@endif
<section class="login-form">
    {!! Form::open(['url' => '/password/email']) !!}
    <div class="form-group">
        {!! Form::label('email', trans('application.email')) !!}
        {!! Form::input('email','email', null, ['class'=>"form-control",'required', 'placeholder'=>"email"]) !!}
    </div>
    <div class="form-group">
        {!! Form::Submit(trans('application.reset_password'), ['class'=>"btn btn-primary form-control"]) !!}
    </div>
    {!! Form::close() !!}
    <div class="form-group">
        <a href="{{ route('admin_login') }}" class="pull-right">{{trans('application.go_to_login')}}</a>
        <div class="clearfix"></div>
    </div>
</section>
@endsection
