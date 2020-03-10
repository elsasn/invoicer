<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classic Invoicer 2 - Admin Account Creation</title>
    <!-- CSS -->
     @include('install.partials.styles')
</head>
<body class="login-page">
<div class="container">
    <div class="login-logo">
        <b>Classic</b> Invoicer 2 Installation
    </div>
    <div class="panel">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div class="callout callout-warning">
						<h4>Create a user account</h4>
					</div>
					@if (count($errors) > 0)
					{!! form_errors($errors) !!}
					@endif
					@if (Session::has('flash_notification.message'))
					{!! message() !!}
					@endif
					{!! Form::open(['url'=>'/install/user']) !!}
					<div class="form-group">
						{!! Form::label('name', 'Name') !!}
						{!! Form::text('name', null, ['class' => 'form-control input-sm','required', 'placeholder' => 'name' ]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('email', 'Email') !!}
						{!! Form::text('email', null, ['class' => 'form-control input-sm','required', 'placeholder' => 'Email' ]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('username', 'Username') !!}
						{!! Form::text('username', null, ['class' => 'form-control input-sm','required', 'placeholder' => 'Username' ]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('password', 'Password') !!}
						{!! Form::password('password', ['class' => 'form-control input-sm','required','placeholder' => 'Password' ]) !!}
					</div>
					<div class="form-group">
						{!! Form::label('password_confirmation', 'Confirm Password') !!}
						{!! Form::password('password_confirmation', ['class' => 'form-control input-sm','required','placeholder' => 'Password' ]) !!}
					</div>
					<div class="form-group">
						{!! Form::submit('Submit', ['class' => 'btn btn-sm btn-success next_btn']) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
    </div>
</div>
@include('install.partials.scripts')
</body>
</html>
