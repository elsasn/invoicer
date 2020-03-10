<script type="text/javascript">
    $(function() {
        $('.date').pikaday({ firstDay: 1, format:'YYYY-MM-DD', autoclose:true });
        $(".date").pikaday({ firstDay: 1, format:'YYYY-MM-DD', autoclose:true });
        $('.datatable').DataTable({
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]],
            "bLengthChange": false,
            "bInfo" : false,
            "filter" : true,
            "oLanguage": { "sSearch": ""}
        });
        $('div.dataTables_filter input').addClass('form-control input-sm');
    });
</script>
<div class="col-md-3">
    <label>{{ trans('application.from') }} : </label>
    <div class="form-group input-group">
        <input class="form-control input-sm date" size="16" type="text" name="from_date" readonly id="from_date"/>
        <span class="input-group-addon input-sm add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
    </div>
</div>
<div class="col-md-3">
    <label>{{ trans('application.to') }} : </label>
    <div class="form-group input-group" style="margin-left:0;">
        <input class="form-control input-sm date" size="16" type="text" name="to_date" readonly id="to_date"/>
        <span class="input-group-addon input-sm add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
    </div>
</div>
<div class="col-md-3">
    <label> </label>
    <div class="form-group">
        <a href="javascript: void(0);" onclick="javascript: payments_summary();" class="btn btn-large btn-sm btn-success"  style="margin:6px"><i class="fa fa-check"></i> {{ trans('application.generate_report') }}</a>
    </div>
</div>
<div class="col-md-12">
    <table class="table datatable dataTable table-bordered">
        <thead>
        <tr class="table_header">
            <th>{{ trans('application.date') }} </th>
            <th>{{ trans('application.invoice_number') }}</th>
            <th>{{ trans('application.payment_method') }}</th>
            <th>{{ trans('application.client') }}</th>
            <th class="text-right">{{ trans('application.amount') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ format_date($payment->payment_date) }}</td>
                <td><a href="{{ route('invoices.show', $payment->invoice_id) }}">{{ $payment->number }}</a></td>
                <td>{{ $payment->method_name }}</td>
                <td><a href="{{ route('clients.show', $payment->client_id) }}">{{ $payment->client_name }}</a></td>
                <td class="text-right">{{ defaultCurrency().' '.format_amount(currency_convert(getCurrencyId($payment->currency),$payment->amount)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>