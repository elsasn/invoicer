@extends('app')
@section('content')
    <div class="col-md-12 content-header" >
        <h1><i class="fa fa-dashboard"></i> {{ trans('application.dashboard') }}</h1>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-users bg-aqua"></i>
                    <span class="info-box-text">{{ trans('application.clients') }}</span>
                    <span class="info-box-number">{{ $clients }}</span>
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-file-pdf-o bg-green"></i>
                    <span class="info-box-text">{{ trans('application.invoices') }}</span>
                    <span class="info-box-number">{{ $invoices }}</span>
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-list-alt bg-yellow"></i>
                    <span class="info-box-text">{{ trans('application.estimates') }}</span>
                    <span class="info-box-number">{{ $estimates }}</span>
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <i class="fa fa-puzzle-piece bg-red"></i>
                    <span class="info-box-text">{{ trans('application.products') }}</span>
                    <span class="info-box-number">{{ $products }}</span>
                </div><!-- /.info-box -->
            </div><!-- /.col -->
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
            <div class="col-md-6 text-center">
                <div class="box box-primary">
                    <div class="box-body">
                        <div id="yearly_overview">
                            <h4>{{ trans('application.yearly_overview') }}</h4>
                            <canvas id="yearly_overview_inner"></canvas>
                        </div><!-- /.col -->
                    </div><!-- ./box-body -->
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="box box-primary">
                    <div class="box-body">
                        <div id="payment_overview">
                            <h4>{{ trans('application.payment_overview') }}</h4>
                            <canvas id="payment_overview_inner"></canvas>
                        </div><!--/.col -->
                    </div><!-- ./box-body -->
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
                        <table class="table table-bordered table-striped table-hover">
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
                                    <td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->number }}</a> </td>
                                    <td><span class="label {{ statuses()[$invoice->status]['class'] }}">{{ ucwords(statuses()[$invoice->status]['label']) }} </span></td>
                                    <td><a href="{{  route('clients.show', $invoice->client_id) }}">{{ $invoice->client->name }}</a> </td>
                                    <td>{{ $invoice->invoice_date }} </td>
                                    <td>{{ $invoice->due_date }} </td>
                                    <td>{!! '<span style="display:inline-block">'.$invoice->currency.'</span><span style="display:inline-block"> '.format_amount($invoice->totals['grandTotal']).'</span>' !!} </td>
                                    <td>
                                        <a href="{{ route('invoices.show',$invoice->uuid) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> {{ trans('application.view') }} </a>
                                        @if(hasPermission('edit_invoice'))
                                            <a href="{{ route('invoices.edit',$invoice->uuid) }}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> {{ trans('application.edit') }} </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> {{ trans('application.recent_estimates') }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped table-hover">
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
                                    <td><a href="{{ route('estimates.show', $estimate->id) }}">{{ $estimate->estimate_no }} </a></td>
                                    <td><a href="{{ route('clients.show', $estimate->client_id) }}">{{ $estimate->client->name }}</a> </td>
                                    <td>{{ $estimate->estimate_date }} </td>
                                    <td>{!! '<span style="display:inline-block">'.$estimate->currency.'</span><span style="display:inline-block"> '.format_amount($estimate->totals['grandTotal']).'</span>' !!} </td>
                                    <td>
                                        <a href="{{ route('estimates.show',$estimate->uuid) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> {{ trans('application.view') }} </a>
                                        @if(hasPermission('edit_estimate'))
                                            <a href="{{ route('estimates.edit',$estimate->uuid) }}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> {{ trans('application.edit') }} </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/chart.js') }}"></script>

    <script>
        var income_data     = JSON.parse('<?php echo $yearly_income; ?>');
        var expense_data    = JSON.parse('<?php echo $yearly_expense; ?>');
        var lineChartData   = {
            labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            datasets : [{
                label               : "{{ trans('application.income') }}",
                fillColor           : "rgba(14,172,147,0.1)",
                strokeColor         : "rgba(14,172,147,1)",
                pointColor          : "rgba(14,172,147,1)",
                pointStrokeColor    : "#fff",
                pointHighlightFill  : "rgba(54,73,92,0.8)",
                pointHighlightStroke: "rgba(54,73,92,1)",
                data                : income_data
            },
                {
                    label               : "{{ trans('application.expenditure') }}",
                    fillColor           : "rgba(244,167,47,0)",
                    strokeColor         : "rgba(244,167,47,1)",
                    pointColor          : "rgba(217,95,6,1)",
                    pointStrokeColor    : "#fff",
                    pointHighlightFill  : "rgba(54,73,92,0.8)",
                    pointHighlightStroke: "rgba(54,73,92,1)",
                    data                : expense_data
                }
            ]
        };
        var pieData = [
            {
                value: '<?php echo $total_payments; ?>',
                color:"#2FB972",
                highlight: "#37D484",
                label: "{{ trans('application.amount_received') }}"
            },
            {
                value: '<?php echo $total_outstanding; ?>',
                color:"#C84135",
                highlight: "#EA5548",
                label: "{{ trans('application.outstanding_amount') }}"
            }
        ];

        $(function(){
            Chart.defaults.global.scaleFontSize = 12;
            var chartDiv = document.getElementById("yearly_overview_inner").getContext("2d");
            lineChart = new Chart(chartDiv).Line(lineChartData, {
                responsive: true
            });
            $('#yearly_overview').append(lineChart.generateLegend());
            var chartDiv = document.getElementById("payment_overview_inner").getContext("2d");
            pieChart = new Chart(chartDiv).Pie(pieData, {
                responsive : true
            });
            $('#payment_overview').append(pieChart.generateLegend());
        });
    </script>
@endsection