@extends('modal')
@section('content')
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 class="modal-title">{{trans('application.edit_role')}}</h5>
        </div>
        {!! Form::model($role, ['route' => ['roles.update', $role->uuid], 'method'=>'PATCH', 'class'=>"ajax-submit"]) !!}
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', trans('application.name')) !!}
                {!! Form::text('name', null, ['class' => "form-control input-sm", 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', trans('application.description')) !!}
                {!! Form::textarea('description', null, ['class' => "form-control input-sm",'rows'=>3]) !!}
            </div>
        </div>
        <div class="modal-footer">
            {!! form_buttons() !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection