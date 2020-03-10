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
    <div class="form-group">
        {!! Form::label('category', trans('application.category')) !!}
        {!! Form::select('category',$categories,$category, ['class' => 'form-control input-sm chosen', 'id' => 'category', 'required']) !!}
    </div>
</div>
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
        <a href="javascript: void(0);" onclick="javascript: expenses_report();" class="btn btn-large btn-sm btn-success"  style="margin:6px"><i class="fa fa-check"></i> {{ trans('application.generate_report') }}</a>
    </div>
</div>

<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
        <tr class="table_header">
            <th>{{trans('application.name')}}</th>
            <th>{{trans('application.date')}}</th>
            <th>{{trans('application.category')}}</th>
            <th class="text-right">{{trans('application.amount')}}</th>
        </tr>
        </thead>
        <tbody>
        @php ($total = 0)
        @foreach($expenses as $expense)
            @php ($expense_amount_converted = currency_convert(getCurrencyId($expense->currency),$expense->amount))
            @php ($total += $expense_amount_converted)
            <tr>
                <td>{{ $expense->name }} </td>
                <td>{{ format_date($expense->expense_date) }} </td>
                <td>{{ $expense->category_name }} </td>
                <td class="text-right">{{ format_amount($expense_amount_converted) }} </td>
            </tr>
        @endforeach
        <tr>
            <td class="text-bold">{{ trans('application.total') }}</td>
            <td class="text-right text-bold text-green" colspan="3">{{ defaultCurrency().' '.format_amount($total) }}</td>
        </tr>
        </tbody>
    </table>
</div>