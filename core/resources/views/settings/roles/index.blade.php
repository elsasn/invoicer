@extends('app')
@section('content')
    <div class="col-md-12 content-header" >
        <h1><i class="fa fa-users"></i> {{trans('application.roles')}}</h1>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                @include('settings.partials._menu')
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        @if (count($errors) > 0)
                            {!! form_errors($errors) !!}
                        @endif
                        {!! Form::open(['route' => ['roles.store']]) !!}
                        <div class="form-group">
                            {!! Form::label('name', trans('application.name')) !!}
                            <div class="input-group col-md-4">
                                {!! Form::text('name', null, ['class' => "form-control input-sm", 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', trans('application.description')) !!}
                            {!! Form::textarea('description', null, ['class' => "form-control input-sm",'rows'=>3]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit(trans('application.save'), ['class="btn btn-sm btn-primary"']) !!}
                        </div>
                        {!! Form::close() !!}
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{trans('application.name')}}</th>
                                <th>{{trans('application.description')}}</th>
                                <th>{{trans('application.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if($roles->count() > 0)
                                    @foreach($roles as $role)
                                        <tr>
                                            <td></td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->description }}</td>
                                            <td>
                                                @if($role->name != 'admin')
                                                    {!! edit_btn('roles.edit', $role->uuid) !!}
                                                    <a class="btn btn-warning btn-xs" data-toggle="ajax-modal" data-rel="tooltip" data-placement="top" href="{{route('roles.show', $role->uuid)}}" title="{{trans("application.permissions")}}"><i class="fa fa-cog"></i></a>
                                                    {!! delete_btn('roles.destroy', $role->uuid) !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection