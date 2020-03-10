@extends('modal')
@section('content')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title">{{ trans('application.currency') }}</h5>
            </div>
            {!! Form::open(['route' => ['currency.store'],'class' => 'ajax-submit', 'id' => 'currency_frm']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', trans('application.name')) !!}
                    {!! Form::text('name', null, ['class' => "form-control input-sm", 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('symbol', trans('application.symbol')) !!}
                    {!! Form::text('symbol', null, ['class' => "form-control input-sm", 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('exchange_rate', trans('application.exchange_rate')) !!}
                    <div class="input-group">
                        <span class="input-group-addon input-sm"><strong>1 USD = </strong></span>
                        {!! Form::text('exchange_rate', null, ['class' => "form-control input-sm", 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! form_buttons() !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection