@extends('clientarea.app')
@section('content')
<div class="col-md-12 content-header" >
    <h1><i class="fa fa-quote-left"></i> {{trans('application.invoices')}}</h1>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12" style="max-width:1040px;">
                            @if (Session::has('flash_notification.message')) {!! message() !!} @endif
                            <a href="{{ route('cinvoices.index') }}" class="btn btn-info btn-sm"> <i class="fa fa-chevron-left"></i> {{trans('application.back')}}</a>
                            <a href="{{ route('invoicepdf', $invoice->uuid) }}" class="btn btn-primary btn-sm pull-right" style="margin-left: 5px"> <i class="fa fa-download"></i> {{trans('application.download')}}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="invoice">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="panel-body">
                                        @if($invoiceSettings && $invoiceSettings->logo != '')
                                        <img src="{{ asset('assets/img/'.$invoiceSettings->logo) }}" alt="logo" width="100%"/>
                                        @endif
                                     </div>
                                </div>
                                <div class="col-md-9 text-right">
                                    <div class="panel-body" style="font-size: 16px;font-weight: bold;padding:0">
                                        <div class="col-xs-12 text-right"> <h1 style="margin:0">{{trans('application.invoice')}}</h1></div>
                                        <div class="col-xs-9 text-right invoice_title">{{trans('application.reference')}}</div>
                                        <div class="col-xs-3 text-right">{{ $invoice->number }}</div>
                                        <div class="col-xs-9 text-right invoice_title">{{trans('application.date')}}</div>
                                        <div class="col-xs-3 text-right">{{ format_date($invoice->invoice_date) }}</div>
                                        @if($invoice->due_date != '0000-00-00')
                                        <div class="col-xs-9 text-right invoice_title">{{trans('application.due_date')}}</div>
                                        <div class="col-xs-3 text-right">{{ format_date($invoice->due_date) }}</div>
                                        @endif
                                        @if($settings && $settings->gst != '')
                                        <div class="col-xs-9 text-right invoice_title">{{trans('application.gst_number')}}</div>
                                        <div class="col-xs-3 text-right">{{ $settings ? $settings->gst : '' }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel-body">
                                        <h4 class="invoice_title">{{trans('application.our_information')}}</h4><hr class="separator"/>
                                        @if($settings)
                                        <h4>{{ $settings->name }}</h4>
                                        {{ $settings->address1 ? $settings->address1.',' : '' }} {{ $settings->state ? $settings->state : '' }}<br/>
                                        {{ $settings->city ? $settings->city.',' : '' }} {{ $settings->postal_code ? $settings->postal_code.','  : ''  }}<br/>
                                        {{ $settings->country }}<br/>
                                            @if($settings->phone != '')
                                                {{trans('application.phone')}}: {{ $settings->phone }}<br/>
                                            @endif
                                            @if($settings->email != '')
                                                {{trans('application.email')}}: {{ $settings->email }}.
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                        <div class="panel-body">
                                            <h4 class="invoice_title">{{trans('application.billing_to')}} </h4><hr class="separator"/>
                                            <h4>{{ $invoice->client->name }}</h4>
                                            {{ $invoice->client->address1 ? $invoice->client->address1.',' : '' }} {{ $invoice->client->state ? $invoice->client->state : '' }}<br/>
                                            {{ $invoice->client->city ? $invoice->client->city.',' : '' }} {{ $invoice->client->postal_code ? $invoice->client->postal_code.','  : ''  }}<br/>
                                            {{ $invoice->client->country }}<br/>
                                            @if($invoice->client->phone != '')
                                                {{trans('application.phone')}}: {{ $invoice->client->phone }}<br/>
                                            @endif
                                            @if($invoice->client->email != '')
                                                {{trans('application.email')}}: {{ $invoice->client->email }}.
                                            @endif
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                            <table class="table">
                                <thead style="margin-bottom:30px;background: #2e3e4e;color: #fff;">
                                <tr>
                                    <th style="width:50%">{{trans('application.product')}}</th>
                                    <th style="width:10%" class="text-center">{{trans('application.quantity')}}</th>
                                    <th style="width:15%" class="text-right">{{trans('application.price')}}</th>
                                    <th style="width:10%" class="text-center">{{trans('application.tax')}}</th>
                                    <th style="width:15%" class="text-right">{{trans('application.total')}}</th>
                                </tr>
                                </thead>
                                <tbody id="items">
                                @foreach($invoice->items->sortBy('item_order') as $item)
                                <tr>
                                    <td><b>{!! $item->item_name !!}</b><br/>{!! $item->item_description !!}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">{{ format_amount($item->price) }}</td>
                                    <td class="text-center">{{ $item->tax ? $item->tax->value.'%' : '' }}</td>
                                    <td class="text-right">{{ format_amount($invoice->totals[$item->uuid]['itemTotal']) }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="col-md-6" style="padding: 7% 12% 0 15%; text-transform: uppercase">
                                @if($invoiceSettings && $invoiceSettings->show_status)
                                    <div class="{{ $invoice->status == 2 ? 'invoice_status_paid' : 'invoice_status_cancelled' }}">
                                        {{ statuses()[$invoice->status]['label']  }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table"><tbody>
                                        <tr>
                                            <th style="width:50%">{{trans('application.subtotal')}}</th>
                                            <td class="text-right">
                                                <span id="subTotal">{{ format_amount($invoice->totals['subTotal']) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('application.tax')}}</th>
                                            <td class="text-right">
                                                <span id="taxTotal">{{ format_amount($invoice->totals['taxTotal']) }}</span>
                                            </td>
                                        </tr>
                                        @if($invoice->totals['discount'] > 0)
                                        <tr>
                                            <th>{{trans('application.discount')}}</th>
                                            <td class="text-right">
                                                <span id="taxTotal">{{ format_amount($invoice->totals['discount']) }}</span>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>{{trans('application.total')}}</th>
                                            <td class="text-right">
                                                <span id="grandTotal">{{ format_amount($invoice->totals['grandTotal']) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('application.paid')}}</th>
                                            <td class="text-right">
                                                <span id="grandTotal">{{ format_amount($invoice->totals['paidFormatted']) }}</span>
                                            </td>
                                        </tr>
                                        <tr class="amount_due">
                                            <th>{{trans('application.amount_due')}}:</th>
                                            <td class="text-right">
                                                <span class="currencySymbol" style="display: inline-block;">{{ $invoice->currency }} </span>
                                                <span id="amountDue">{{ $invoice->totals['amountDue'] }}</span>
                                            </td>
                                        </tr>
                                        </tbody></table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if($invoice->notes)
                                    <h4 class="invoice_title">{{trans('application.notes')}}</h4><hr class="separator"/>
                                    {!! htmlspecialchars_decode($invoice->notes,ENT_QUOTES) !!}<br/><br/>
                                @endif
                                @if($invoice->terms)
                                    <h4 class="invoice_title">{{trans('application.terms')}}</h4><hr class="separator"/>
                                    {!! htmlspecialchars_decode($invoice->terms,ENT_QUOTES) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cleafix"></div>
    </div>
</section>
@endsection


