@extends('clientarea.default')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['url' => 'clientarea/password/reset']) !!}
        {!! Form::hidden('token', $token) !!}
        <div class="form-group">
            {!! Form::label('email', trans('application.email')) !!}
            {!! Form::input('email','email', old('email'), ['class'=>"form-control",'required','placeholder'=>"email"]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', trans('application.password')) !!}
            {!! Form::password('password', ['class'=>"form-control",'required','placeholder'=>"password"]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', trans('application.confirm_password')) !!}
            {!! Form::password('password_confirmation', ['class'=>"form-control", 'placeholder'=>"Confirm Password"]) !!}
        </div>
        <div class="form-group">
            {!! Form::Submit(trans('application.reset_password'), ['class'=>"btn btn-primary form-control"]) !!}
        </div>
    {!! Form::close() !!}
@endsection
