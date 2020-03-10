@extends('app')
@section('content')
<div class="col-md-12 content-header" >
    <h1><i class="fa fa-line-chart"></i> {{trans('application.reports')}}</h1>
</div>
<link rel="stylesheet" href="{{ asset('assets/css/morris.min.css') }}">
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-danger btn-sm reports-button" onclick="javascript: general_summary();">{{trans('application.general_summary')}}</button>
                        <button type="button" class="btn btn-primary btn-sm reports-button" onclick="javascript: payments_summary();">{{trans('application.payments_summary')}}</button>
                        <button type="button" class="btn btn-info btn-sm reports-button" onclick="javascript: client_statement();">{{trans('application.client_statement')}}</button>
                        <button type="button" class="btn btn-success btn-sm reports-button" onclick="javascript: invoices_report();">{{trans('application.invoice_report')}}</button>
                        <button type="button" class="btn btn-warning btn-sm reports-button" onclick="javascript: expenses_report();">{{trans('application.expense_report')}}</button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row" id="report-body" style="height:700px"></div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('scripts')
    @include('reports.partials.reports_js')
@endsection