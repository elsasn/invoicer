<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head><body>
<div class="container">
    <div style="width:300px;height:130px;float:left;overflow: hidden">
        @if($settings && $settings->logo != '')
            <img src="{{ asset('assets/img/'.$settings->logo) }}" alt="logo" width="50%"/>
        @endif
    </div>
    <div class="text-right" style="width:300px;height:130px;float:right;">
        <div class="text-right"> <h2>{{trans('application.invoice')}}</h2></div>
        <table style="width: 100%">
            <tr>
                <td class="text-right" style="width: 40%">{{trans('application.reference')}}</td>
                <td class="text-right">{{ $invoice->number }}</td>
            </tr>
            <tr>
                <td class="text-right">{{trans('application.date')}}</td>
                <td class="text-right">{{ $settings ? date($settings->date_format, strtotime($invoice->invoice_date)) : $invoice->date_format }}</td>
            </tr>
            <tr>
                <td class="text-right">{{trans('application.due_date')}}</td>
                <td class="text-right">{{ $settings ? date($settings->date_format, strtotime($invoice->due_date)) : $invoice->due_date }}</td>
            </tr>
            @if($settings && $settings->vat != '')
                <tr>
                    <td class="text-right">{{trans('application.vat_number')}}</td>
                    <td class="text-right">{{ $settings ? $settings->vat : '' }}</td>
                </tr>
            @endif
        </table>
    </div>
    <div style="clear: both"></div>
    <div class="col-md-12">
        <div class="from_address">
            <h4 class="invoice_title">{{trans('application.our_information')}}</h4><hr class="separator"/>
            @if($settings)
                <h4>{{ $settings->name }}</h4>
                @if($settings->address1 != '' || $settings->state != '')
                    {{ $settings->address1 ? $settings->address1.',' : '' }} {{ $settings->state ? $settings->state : '' }}<br/>
                @endif
                @if($settings->city != '' || $settings->postal_code != '')
                    {{ $settings->city ? $settings->city.',' : '' }} {{ $settings->postal_code ? $settings->postal_code.','  : ''  }}<br/>
                @endif
                @if($settings->country != '')
                    {{ $settings->country }}<br/>
                @endif
                @if($settings->phone != '')
                    {{trans('application.phone')}}: {{ $settings->phone }}<br/>
                @endif
                @if($settings->email != '')
                    {{trans('application.email')}}: {{ $settings->email }}.
                @endif
            @endif
        </div>
        <div class="to_address">
            <h4 class="invoice_title">{{trans('application.billing_to')}} </h4><hr class="separator"/>
            <h4>{{ $invoice->client->name }}</h4>
            @if($invoice->client->address1 != '' || $invoice->client->state != '')
                {{ $invoice->client->address1 ? $invoice->client->address1.',' : '' }} {{ $invoice->client->state ? $invoice->client->state : '' }}<br/>
            @endif
            @if($invoice->client->city != '' || $invoice->client->postal_code != '')
                {{ $invoice->client->city ? $invoice->client->city.',' : '' }} {{ $invoice->client->postal_code ? $invoice->client->postal_code.','  : ''  }}<br/>
            @endif
            @if($invoice->client->country != '')
                {{ $invoice->client->country }}<br/>
            @endif
            @if($invoice->client->phone != '')
                {{trans('application.phone')}}: {{ $invoice->client->phone }}<br/>
            @endif
            @if($invoice->client->email != '')
                {{trans('application.email')}}: {{ $invoice->client->email }}.
            @endif
        </div>
    </div>
    <div style="clear: both"></div>
    <div class="col-md-12">
        <table class="table">
            <tr style="margin-bottom:30px;background: #2e3e4e;color: #fff;" class="item_table_header">
                <th style="width:50%">{{trans('application.product')}}</th>
                <th style="width:10%" class="text-center">{{trans('application.quantity')}}</th>
                <th style="width:15%" class="text-right">{{trans('application.price')}}</th>
                <th style="width:10%" class="text-center">{{trans('application.tax')}}</th>
                <th style="width:15%" class="text-right">{{trans('application.total')}}</th>
            </tr>
            @foreach($invoice->items->sortBy('item_order') as $item)
                <tr class="items">
                    <td><b>{!! $item->item_name !!}</b><br/>{!! htmlspecialchars_decode(nl2br(e($item->item_description)),ENT_QUOTES) !!}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ format_amount($item->price) }}</td>
                    <td class="text-center">{{ $item->tax ? $item->tax->value.'%' : '' }}</td>
                    <td class="text-right">{{ format_amount($invoice->totals[$item->uuid]['itemTotal']) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-12">
        <div class="col-md-6" style="padding: 7% 25% 0 10%;width: 30%; text-transform: uppercase">
            @if($invoiceSettings && $invoiceSettings->show_status)
                <div class="{{ $invoice->status == 2 ? 'invoice_status_paid' : 'invoice_status_cancelled' }}">
                    {{ statuses()[$invoice->status]['label']  }}
                </div>
            @endif
        </div>
        <table class="table">
            <tr>
                <th style="width:75%" class="text-right">{{trans('application.subtotal')}}</th>
                <td class="text-right">
                    <span id="subTotal">{{ $invoice->currency.' '.format_amount($invoice->totals['subTotal']) }}</span>
                </td>
            </tr>
            <tr>
                <th class="text-right">{{trans('application.tax')}}</th>
                <td class="text-right">
                    <span id="taxTotal">{{ $invoice->currency.' '.format_amount($invoice->totals['taxTotal']) }}</span>
                </td>
            </tr>
            @if($invoice->totals['discount'] > 0)
                <tr>
                    <th class="text-right">{{trans('application.discount')}}</th>
                    <td class="text-right">
                        <span id="taxTotal">{{ $invoice->currency.' '.format_amount($invoice->totals['discount']) }}</span>
                    </td>
                </tr>
            @endif
            <tr>
                <th class="text-right">{{trans('application.total')}}</th>
                <td class="text-right">
                    <span id="grandTotal">{{ $invoice->currency.' '.format_amount($invoice->totals['grandTotal']) }}</span>
                </td>
            </tr>
            <tr>
                <th class="text-right">{{trans('application.paid')}}</th>
                <td class="text-right">
                    <span id="grandTotal">{{ $invoice->currency.' '.format_amount($invoice->totals['paidFormatted']) }}</span>
                </td>
            </tr>
            <tr class="amount_due">
                <th class="text-right">{{trans('application.amount_due')}}:</th>
                <td class="text-right">
                    <span id="grandTotal">{{ $invoice->currency.' '.format_amount($invoice->totals['amountDue']) }}</span>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-12">
        @if($invoice->notes)
            <h4 class="invoice_title">{{trans('application.notes')}}</h4><hr class="separator"/>
            {!! htmlspecialchars_decode($invoice->notes,ENT_QUOTES) !!} <br/>
        @endif
        @if($invoice->terms)
            <h4 class="invoice_title">{{trans('application.terms')}}</h4><hr class="separator"/>
            {!! htmlspecialchars_decode($invoice->terms,ENT_QUOTES) !!}
        @endif
    </div>
</div>
</body></html>
<style>
    body {
        font-family: 'DejaVu Sans', 'Source Sans Pro','Helvetica Neue','Helvetica,Arial',sans-serif;
        overflow-x: hidden;
        overflow-y: auto;
        font-size: 13px;
    }
    .amount_due {
        font-size: 20px;
        font-weight: 500;
    }
    .invoice_title{
        color: #2e3e4e;
        font-weight: bold;
    }
    .text-right{
        text-align: right;
    }
    .text-center{
        text-align: center;
    }
    .from_address{
        width: 300px;
        float: left;
        height: 220px;
    }
    .to_address{
        width: 300px;
        height: 220px;
        float: right;
    }
    .col-md-12{
        width: 100%;
    }
    .col-md-6{
        width: 50%;
        float: left;
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    .item_table_header>th{
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
    }
    .table>tr>td, .table>tr>th{
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
    }
    hr.separator{
        border-color:  #2e3e4e;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .items>td{
        border: 3px solid #fff !important;
        vertical-align: middle;
    }
    .items{
        background-color: #f1f1f1;
    }
    .invoice_status_cancelled
    {
        font-size : 20px;
        text-align : center;
        color: #cc0000;
        border: 1px solid #cc0000;
    }
    .invoice_status_paid
    {
        font-size : 25px;
        text-align : center;
        color: #82b440;
        border: 1px solid #82b440;
    }
</style>
