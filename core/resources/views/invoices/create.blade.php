@extends('app')
@section('content')
<div class="col-md-12 content-header" >
    <h1><i class="fa fa-file-pdf-o"></i> {{ trans('application.invoices') }}</h1>
</div>
<section class="content">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
    <div class="row">
        <div class="col-md-6" style="width:1000px;margin-left:20px"><br/>
            <a href="{{ route('invoices.index') }}" class="btn btn-info btn-xs"> <i class="fa fa-chevron-left"></i> {{ trans('application.back') }}</a>
        </div>
    </div>
<div class="panel-body">
<div class="row">
    <div class="invoice">
        {!! Form::open(['route' => ['invoices.store'], 'id' => 'invoice_form', 'data-toggle'=>"validator", 'role' =>"form"]) !!}
        <div class="col-md-12">
          <div class="text-right"><h1 style="margin:0">{{ trans('application.invoice') }}</h1></div>
            <div class="col-md-7" style="padding: 0px">
                <div class="contact to">
                    <div class="form-group">
                        {!! Form::label('client', trans('application.client')) !!}
                        <div class="input-group col-md-9">
                            {!! Form::select('client',$clients,null, ['class' => 'form-control chosen input-sm', 'id' => 'client', 'required']) !!}
                            <span class="input-group-addon">
                                <a href="{{ route('clients.create') }}" data-toggle="ajax-modal" class="ajaxNonReload" data-element="client"><i class="fa fa-plus"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('currency', trans('application.currency')) !!}
                        <div class="input-group col-md-9">
                            {!! Form::select('currency',$currencies,null, ['class' => 'form-control input-sm chosen', 'required']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('number', trans('application.invoice_number')) !!}
                        <div class="input-group col-md-9">
                            {!! Form::text('number',$invoice_num, ['class' => 'form-control input-sm', 'id' => 'number', 'required', 'readonly']) !!}
                            <span class="input-group-addon" style="padding-top: 6px;padding-bottom: 6px;">
                                <a id="change_invoice_num" href="javascript:void(0)"><i class="fa fa-pencil"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('number', trans('application.recurring')) !!}
                        <div class="input-group col-md-9">
                            {!! Form::select('recurring',['0'=>trans('application.no'),'1'=>trans('application.yes')],0, ['class' => 'form-control input-sm chosen', 'required']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5" style="padding: 0px">
                <div class="form-group">
                    {!! Form::label('invoice_date', trans('application.date')) !!}
                    {!! Form::text('invoice_date',date('Y-m-d'), ['class' => 'form-control datepicker input-sm' , 'id' => 'invoice_date', 'required','readonly']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('due_date', trans('application.due_date')) !!}
                    {!! Form::text('due_date',$settings ? date('Y-m-d',strtotime("+".$settings->due_days." days")) : date('Y-m-d'), ['class' => 'form-control datepicker input-sm' , 'id' => 'due_date','readonly']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('status', trans('application.status')) !!}
                    <select class="form-control chosen required input-sm" name="status" id="status">
                        @foreach($statuses as $key => $status)
                            <option value="{{ $key }}"> {{ strtoupper($status['label']) }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('number', trans('application.recurring_cycle')) !!}
                    {!! Form::select('recurring_cycle',['1'=>trans('application.monthly'),'2'=>trans('application.quarterly'),'3'=>trans('application.semi_annually'),'4'=>trans('application.annually')],1, ['class' => 'form-control input-sm chosen', 'required']) !!}
                </div>
            </div>
    </div>
    <div class="col-md-12">
        <table class="table table-striped" id="item_table">
            <thead class="item-table-header">
            <tr>
                <th width="5%"></th>
                <th width="20%">{{ trans('application.product') }}</th>
                <th width="35%">{{ trans('application.description') }}</th>
                <th width="10%" class="text-center">{{ trans('application.quantity') }}</th>
                <th width="10%" class="text-center">{{ trans('application.price') }}</th>
                <th width="10%" class="text-center">{{ trans('application.tax') }}</th>
                <th width="10%"class="text-right">{{ trans('application.amount') }}</th>
            </tr>
            </thead>
            <tbody>
                <tr class="item">
                    <td></td>
                    <td><div class="form-group">{!! Form::text('item_name',null,['class' => 'form-control input-sm item_name', 'id'=>"item_name" , 'required']) !!}</div></td>
                    <td><div class="form-group">{!! Form::textarea('item_description',null,['class' => 'form-control item_description input-sm','id'=>"item_description",'rows'=>'1','style'=>'resize: vertical;text-transform: capitalize;']) !!}</div></td>
                    <td><div class="form-group">{!! Form::input('number','quantity',null, ['class' => 'form-control calcEvent quantity input-sm', 'id'=>"quantity" , 'required', 'step' => 'any', 'min' => '0']) !!}</div></td>
                    <td><div class="form-group">{!! Form::input('number','price',null, ['class' => 'form-control calcEvent price input-sm', 'id'=>"price", 'required','step' => 'any', 'min' => '0']) !!}</div></td>
                    <td><div class="form-group">{!! Form::customSelect('tax',$taxes['options'],$taxes['default'], ['class' => 'form-control calcEvent tax input-sm', 'id'=>"tax"]) !!}</div></td>
                    <td class="text-right"><span class="itemTotal">0.00</span></td>
                </tr>
            </tbody>
        </table>
    </div><!-- /.col -->
    <div class="col-md-6">
        <span id="btn_add_row" class="btn btn-xs btn-info "><i class="fa fa-plus"></i> {{ trans('application.add_row') }}</span>
        <span id="btn_product_list_modal" class="btn btn-xs btn-primary "><i class="fa fa-plus"></i> {{ trans('application.add_from_products') }}</span>
    </div><!-- /.col -->
    <div class="col-md-6">
        <table class="table">
            <tbody>
            <tr>
                <th style="width:50%">{{ trans('application.subtotal') }}</th>
                <td class="text-right">
                    <span id="subTotal">0.00</span>
                </td>
            </tr>
            <tr>
                <th>Tax</th>
                <td class="text-right">
                    <span id="taxTotal">0.00</span>
                </td>
            </tr>
            <tr>
                <th style="vertical-align: middle">
                    {{ trans('application.discount') }}
                    {!! Form::select('discount_mode',array('1'=>'%','0'=>'Amount'), null,['class' => 'text-right input-sm calcEvent', 'id' => 'discount_mode','style'=>'width:50%']) !!}
                </th>
                <td class="text-right">
                    <div class="form-group">
                    {!! Form::input('number','discount', null,['class' => 'form-control text-right calcEvent input-sm', 'id' => 'discount', 'step'=>'any', 'min'=>'0']) !!}
                   </div>
                </td>
            </tr>
            <tr class="amount_due">
                <th>{{ trans('application.total') }}:</th>
                <td class="text-right">
                    <span class="currencySymbol" style="display: inline-block;"></span>
                    <span id="grandTotal">0.00</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('notes', trans('application.notes')) !!}
            {!! Form::textarea('notes',null, ['class' => 'form-control text_editor','rows' =>  '2']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('terms', trans('application.terms')) !!}
            {!! Form::textarea('terms',$settings ? $settings->terms : '', ['class' => 'form-control text_editor', 'id' => 'invoice_terms', 'rows' =>  '2']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-xs btn-success pull-right" id="saveInvoice"><i class="fa fa-save"></i> {{ trans('application.save_invoice') }}</button>
    </div>
    {!!  Form::close() !!}
    </div>
    </div>
   </div>
  </div>
 </div>
</div>
</section>
@endsection
@section('scripts')
    @include('invoices.partials._invoices_js')
@endsection

