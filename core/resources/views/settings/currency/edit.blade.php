@extends('modal')@section('content')<div class="modal-dialog">    <div class="modal-content">        <div class="modal-header">            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>            <h5 class="modal-title">{{trans('application.edit_currency')}}</h5>        </div>        {!! Form::model($currency, ['route' => ['currency.update', $currency->uuid], 'method'=>'PATCH', 'class'=>"ajax-submit"]) !!}        <div class="modal-body">            <div class="form-group">                {!! Form::label('name', trans('application.currency_name')) !!}                {!! Form::text('name', null, ['class' => "form-control input-sm", 'required', 'readonly']) !!}            </div>            <div class="form-group">                {!! Form::label('code', trans('application.code')) !!}                {!! Form::text('code', null, ['class' => "form-control input-sm", 'required', 'readonly']) !!}            </div>            <div class="form-group">                {!! Form::label('symbol', trans('application.symbol')) !!}                {!! Form::text('symbol', null, ['class' => "form-control input-sm", 'required', 'readonly']) !!}            </div>            <div class="form-group">                {!! Form::label('exchange_rate', trans('application.exchange_rate')) !!}                <div class="input-group">                    <span class="input-group-addon input-sm"><strong>1 USD = </strong></span>                    {!! Form::text('exchange_rate', null, ['class' => "form-control input-sm", 'required', 'readonly']) !!}                </div>            </div>            <div class="form-group">                {!! Form::label('active', trans('application.active')) !!}                {!! Form::select('active', array('0'=>'No',  '1' => 'Yes'),  null, ['class' => "form-control input-sm"]) !!}            </div>            <div class="form-group">                {!! Form::label('default_currency', trans('application.default_currency')) !!}                {!! Form::select('default_currency', array('0'=>'No',  '1' => 'Yes'),  null, ['class' => "form-control input-sm"]) !!}            </div>        </div>        <div class="modal-footer">        {!! form_buttons() !!}        </div>        {!! Form::close() !!}    </div></div>@endsection