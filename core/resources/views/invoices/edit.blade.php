@extends('app')
@section('content')
<div class="col-md-12 content-header" >
    <h1><i class="fa fa-file-pdf-o"></i> {{ trans('application.invoices') }}</h1>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12" style="max-width:1040px;">
                            <a href="{{ route('invoices.index') }}" class="btn btn-info btn-xs"> <i class="fa fa-chevron-left"></i> {{ trans('application.back') }}</a>
                            <a href="{{ route('invoices.show', $invoice->uuid) }}" class="btn btn-primary btn-xs pull-right"> <i class="fa fa-search"></i>  {{trans('application.preview')}}</a>
                        </div>
                    </div>
                    <div class="row">
                            <div class="invoice">
                                {!! Form::model($invoice, ['route' => ['invoices.update', $invoice->uuid],  'method' => 'PATCH', 'id' => 'invoice_form', 'data-toggle'=>"validator", 'role' =>"form"]) !!}
                                <div class="col-md-12">
                                    <div class="text-right"><h1 style="margin:0">{{ trans('application.invoice') }}</h1></div>
                                    <div class="col-md-7" style="padding: 0px">
                                        <div class="contact to">
                                            <div class="form-group">
                                                {!! Form::label('client', trans('application.client')) !!}
                                                <div class="input-group col-md-9">
                                                    {!! Form::select('client',$clients,$invoice->client_id, ['class' => 'form-control chosen', 'id' => 'client', 'required']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('currency', trans('application.currency')) !!}
                                                <div class="input-group col-md-9">
                                                    {!! Form::select('currency',$currencies,null, ['class' => 'form-control chosen', 'required']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('number', trans('application.invoice_number')) !!}
                                                <div class="input-group col-md-9">
                                                    {!! Form::text('number',null, ['class' => 'form-control input-sm', 'id' => 'number', 'required', 'readonly']) !!}
                                                    <span class="input-group-addon" style="padding-top: 6px;padding-bottom: 6px;">
                                                        <a id="change_invoice_num" href="javascript:void(0)"><i class="fa fa-pencil"></i></a>
                                                    </span>
                                                </div>
                                           </div>
                                            <div class="form-group">
                                                {!! Form::label('number', trans('application.recurring')) !!}
                                                <div class="input-group col-md-9">
                                                    {!! Form::select('recurring',['0'=>trans('application.no'),'1'=>trans('application.yes')],null, ['class' => 'form-control input-sm chosen', 'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="padding: 0px">
                                        <div class="form-group">
                                            {!! Form::label('invoice_date', trans('application.date')) !!}
                                            {!! Form::text('invoice_date',null, ['class' => 'form-control datepicker input-sm' , 'id' => 'invoice_date', 'required','readonly']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('due_date', trans('application.due_date')) !!}
                                            {!! Form::text('due_date',null, ['class' => 'form-control datepicker input-sm' , 'id' => 'due_date', 'required','readonly']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('status', trans('application.status')) !!}
                                            <select class="form-control chosen required input-sm" name="status" id="status">
                                                @foreach($statuses as $key => $status)
                                                <option value="{{ $key }}" {{ $key == $invoice->status ?  'selected' : '' }}> {{ strtoupper($status['label']) }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('number', trans('application.recurring_cycle')) !!}
                                            {!! Form::select('recurring_cycle',['1'=>trans('application.monthly'),'2'=>trans('application.quartely'),'3'=>trans('application.semi_annually'),'4'=>trans('application.annually')],null, ['class' => 'form-control input-sm chosen', 'required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-striped" id="item_table">
                                        <thead style="background: #2e3e4e;color: #fff;">
                                        <tr>
                                            <th width="5%"></th>
                                            <th width="20%">{{ trans('application.product') }}</th>
                                            <th width="35%">{{ trans('application.description') }}</th>
                                            <th width="10%">{{ trans('application.quantity') }}</th>
                                            <th width="10%">{{ trans('application.price') }}</th>
                                            <th width="15%">{{ trans('application.tax') }}</th>
                                            <th width="15%"class="text-right">{{ trans('application.amount') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->items->sortBy('item_order') as $item)
                                        <tr class="item">
                                            <td><span class="btn btn-danger btn-xs deleteItem" data-id="{{ $item->uuid }}"><i class="fa fa-trash"></i></span>{!! Form::hidden('itemId',$item->uuid, ['id'=>'itemId', 'required']) !!}</td>
                                            <td><div class="form-group">{!! Form::text('item_name',$item->item_name,['class' => 'form-control input-sm item_name', 'id'=>"item_name", 'required']) !!}</div></td>
                                            <td><div class="form-group">{!! Form::textarea('item_description',$item->item_description,['class' => 'form-control input-sm item_description', 'id'=>"item_description",'rows'=>'1','style'=>'resize: vertical;text-transform: capitalize;']) !!}</div></td>
                                            <td class="text-center"><div class="form-group">{!! Form::input('number', 'quantity',$item->quantity, ['class' => 'form-control calcEvent input-sm quantity', 'id'=>"quantity" , 'required', 'step' => 'any', 'min' => '0']) !!}</div></td>
                                            <td class="text-right"><div class="form-group">{!! Form::input('number','price',$item->price, ['class' => 'form-control input-sm calcEvent rate', 'id'=>"price", 'required', 'step' => 'any', 'min' => '0']) !!}</div></td>
                                            <td><div class="form-group">{!! Form::customSelect('tax',$taxes['options'],$item->tax_id, ['class' => 'form-control input-sm calcEvent tax', 'id'=>"tax"]) !!}</div></td>
                                            <td class="text-right"><span class="itemTotal">{{ $invoice->totals[$item->uuid]['itemTotal'] }}</span></td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <span id="btn_add_row" class="btn btn-xs btn-info "><i class="fa fa-plus"></i> {{ trans('application.add_row') }}</span>
                                    <span id="btn_product_list_modal" class="btn btn-xs btn-primary "><i class="fa fa-plus"></i> {{ trans('application.add_from_products') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th style="width:50%">{{ trans('application.subtotal') }}:</th>
                                            <td class="text-right">
                                                <span id="subTotal">{{ $invoice->totals['subTotal'] }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('application.tax') }}:</th>
                                            <td class="text-right">
                                                <span id="taxTotal">{{ $invoice->totals['taxTotal'] }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align: middle">{{ trans('application.discount') }}
                                                {!! Form::select('discount_mode',array('1'=>'%','0'=>'Amount'), $invoice->discount_mode,['class' => 'text-right input-sm', 'id' => 'discount_mode','style'=>'width:50%']) !!}
                                            </th>
                                            <td class="text-right">
                                                <div class="form-group">
                                                    {!! Form::input('number','discount', null,['class' => 'form-control text-right input-sm calcEvent', 'id' => 'discount', 'step'=>'any', 'min'=>'0']) !!}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('application.total') }}:</th>
                                            <td class="text-right">
                                                <span id="grandTotal">{{ $invoice->totals['grandTotal'] }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('application.paid') }}:</th>
                                            <td class="text-right">
                                                <span id="paidTotal">{{ $invoice->totals['paidFormatted'] }}</span>
                                                {!! Form::hidden('paid',$invoice->totals['paid'], ['id' => 'paidAmount']) !!}
                                            </td>
                                        </tr>
                                        <tr class="amount_due">
                                            <th>{{ trans('application.amount_due') }}:</th>
                                            <td class="text-right">
                                                <span class="currencySymbol" style="display: inline-block;">{{ $invoice->currency }} </span>
                                                <span id="amountDue">{{ $invoice->totals['amountDue'] }}</span>
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
                                        {!! Form::textarea('terms',null, ['class' => 'form-control text_editor', 'rows' =>  '2', 'id' => 'invoice_terms']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-xs btn-success pull-right" id="saveInvoice"><i class="fa fa-save"></i> {{trans('application.save_invoice')}}</button>
                                </div>
                                {!!  Form::close() !!}
                            </div>
                       </div>
                </div>
            </div>
        </div>>
    </div>
</section>
@endsection
@section('scripts')
    @include('invoices.partials._invoices_js')
@endsection