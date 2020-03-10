@extends('modal')
@section('content')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title">{{trans('application.add_locale')}}</h5>
            </div>
            {!! Form::open(['route' => ['translations.store'], 'class' => 'ajax-submit', 'files'=>true]) !!}
            <div class="modal-body">
                @include('translations.partials.form')
            </div>
            <div class="modal-footer">
            {!! form_buttons() !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection