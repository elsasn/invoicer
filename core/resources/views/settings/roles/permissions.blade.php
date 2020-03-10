@extends('modal')
@section('content')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title">{{trans('application.assign_permissions')}}</h5>
            </div>

            {!! Form::model($role, ['url' => 'settings/assignPermission', 'class'=>"ajax-submit"]) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', trans('application.role')) !!}
                    {!! Form::hidden('role_id', $role->uuid) !!}
                    <p>{{$role->name}}</p>
                </div>
                <div class="form-group">
                    <table class="table">
                        <tr>
                            <th>{{trans('application.name')}}</th>
                            <th>{{trans('application.description')}}</th>
                            <th>{{trans('application.assign')}}</th>
                        </tr>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{$permission->name}}</td>
                                <td>{{$permission->description}}</td>
                                <td>{!! Form::checkbox($permission->name, $permission->uuid, $role->permissions->contains('name', $permission->name) ? true : null ) !!} </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                {!! form_buttons() !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection