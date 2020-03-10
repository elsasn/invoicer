@extends('modal')
@section('content')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title">{{trans('application.edit_permission')}}</h5>
            </div>
            {!! Form::model($permission, ['route' => ['permissions.update', $permission->uuid], 'method'=>'PATCH', 'class'=>"ajax-submit"]) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', trans('application.name')) !!}
                    <p>{{$permission->name}}</p>
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