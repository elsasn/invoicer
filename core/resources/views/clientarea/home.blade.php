@extends('clientarea.app')
@section('content')
    <div class="col-md-12 content-header" >
        <h1><i class="fa fa-dashboard"></i> {{ trans('application.dashboard') }}</h1>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-file-pdf-o bg-green"></i>
                    <span class="info-box-text">{{ trans('application.invoices') }}</span>
                    <span class="info-box-number">{{ $invoices }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-list-alt bg-yellow"></i>
                    <span class="info-box-text">{{ trans('application.estimates') }}</span>
                    <span class="info-box-number">{{ $estimates }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-usd bg-aqua"></i>
                    <span class="info-box-text">{{ trans('application.payments') }}</span>
                    <span class="info-box-number" style="color: #00a65a;">{{ $total_payments }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-credit-card bg-red"></i>
                    <span class="info-box-text">{{ trans('application.outstanding_amount') }}</span>
                    <span class="info-box-number" style="color: #dd4b39;">{{ $total_outstanding }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="panel panel-primary dashboard_stats">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-usd fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <p class="info-box-number">{{ $invoice_stats['partiallyPaid'] }}</p>
                                <p class="info-box-text">{{ trans('application.invoices_partially_paid') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="panel bg-yellow dashboard_stats">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-money fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <p class="info-box-number">{{ $invoice_stats['unpaid'] }}</p>
                                <p class="info-box-text">{{ trans('application.unpaid_invoices') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="panel bg-red dashboard_stats">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-times fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <p class="info-box-number">{{  $invoice_stats['overdue'] }}</p>
                                <p class="info-box-text">{{ trans('application.invoices_overdue') }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="panel bg-green dashboard_stats">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-check fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <p class="info-box-number">{{ $invoice_stats['paid'] }}</p>
                                <p class="info-box-text">{{ trans('application.paid_invoices') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> {{ trans('application.recent_invoices') }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table-hover datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ trans('application.invoice_number') }}</th>
                                <th>{{ trans('application.invoice_status') }}</th>
                                <th>{{ trans('application.client') }}</th>
                                <th>{{ trans('application.date') }}</th>
                                <th>{{ trans('application.due_date') }}</th>
                                <th>{{ trans('application.amount') }}</th>
                                <th width="20%">{{ trans('application.action') }} </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentInvoices as $count=>$invoice)
                                <tr>
                                    <td>{{ $count+1 }}</td>
                                    <td><a href="{{ route('cinvoices.show', $invoice->uuid) }}">{{ $invoice->number }}</a></td>
                                    <td><span class="label {{ statuses()[$invoice->status]['class'] }}">{{ ucwords(statuses()[$invoice->status]['label']) }}</span></td>
                                    <td>{{ $invoice->client->name }}</td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->due_date }} </td>
                                    <td>{!! '<span style="display:inline-block">'.$invoice->currency.'</span><span style="display:inline-block"> '.format_amount($invoice->totals['grandTotal']).'</span>'  !!}</td>
                                    <td>
                                        <a href="{{ route('cinvoices.show',$invoice->uuid) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> {{ trans('application.view') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> {{ trans('application.recent_estimates') }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table-hover datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ trans('application.estimate_number') }}</th>
                                <th>{{ trans('application.client') }}</th>
                                <th>{{ trans('application.date') }}</th>
                                <th>{{ trans('application.amount') }}</th>
                                <th width="20%">{{ trans('application.action') }} </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentEstimates as $count=>$estimate)
                                <tr>
                                    <td>{{ $count+1 }}</td>
                                    <td><a href="{{ route('cestimates.show', $estimate->uuid) }}">{{ $estimate->estimate_no }}</a></td>
                                    <td>{{ $estimate->client->name }}</td>
                                    <td>{{ $estimate->estimate_date }}</td>
                                    <td>{!! '<span style="display:inline-block">'.$estimate->currency.'</span><span style="display:inline-block"> '.format_amount($estimate->totals['grandTotal']).'</span>' !!}</td>
                                    <td>
                                        <a href="{{ route('cestimates.show',$estimate->uuid) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> {{ trans('application.view') }} </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection