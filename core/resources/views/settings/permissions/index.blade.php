@extends('app')
@section('content')
    <div class="col-md-12 content-header" >
        <h1><i class="fa fa-users"></i> {{trans('application.permissions')}}</h1>
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
                                @if($permissions->count() > 0)
                                    @foreach($permissions as $count=>$permission)
                                        <tr>
                                            <td>{{ $count+1 }}.</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->description }}</td>
                                            <td>{!! edit_btn('permissions.edit', $permission->uuid) !!}</td>
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