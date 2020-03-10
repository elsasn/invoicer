<div class="col-md-3">
    <div class="form-group">
        <div class="form-group">
            {!! Form::label('client_id', trans('application.client')) !!}
            {!! Form::select('client',$clients,$client, ['class' => 'form-control input-sm chosen', 'id' => 'client_id', 'required']) !!}
        </div>
    </div>
</div>
<div class="col-md-3">
    <label> </label>
    <div class="form-group input-group" style="margin-left:0;">
        <a href="javascript: void(0);" onclick="javascript: client_statement();" class="btn btn-sm btn-success pull-right"  style="margin:6px">
            <i class="fa fa-check"></i> {{trans('application.generate_statement')}}
        </a>
    </div>
</div>
<div class="col-md-12">
    <table class="table table-hover table-striped table-bordered datatable">
        <thead>
        <tr class="table_header">
            <th>{{trans('application.date')}} </th>
            <th>{{trans('application.activity')}}</th>
            <th class="text-right">{{trans('application.invoices')}}</th>
            <th class="text-right">{{trans('application.payments')}}</th>
            <th class="text-right">{{trans('application.balance')}}</th>
        </tr>
        </thead>
        <tbody>
        @php ($total = 0)
        @if(!empty($statement))
            @foreach($statement as $record)
                @php ($total = ($record['transaction_type'] == 'payment') ? $total - currency_convert(getCurrencyId($record['currency']),$record['amount']) : $total + currency_convert(getCurrencyId($record['currency']),$record['amount']))
                <tr>
                    <td>{{ format_date($record['date']) }}</td>
                    <td>{{ $record['activity'] }}</td>
                    <td class="text-right text-red">{{ $record['transaction_type'] != 'payment' ? format_amount(currency_convert(getCurrencyId($record['currency']),$record['amount'])) : '' }}</td>
                    <td class="text-right text-green">{{ $record['transaction_type'] == 'payment' ? format_amount(currency_convert(getCurrencyId($record['currency']),$record['amount'])) : '' }}</td>
                    <td class="text-right text-bold">{{ format_amount($total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-bold">{{ trans('application.total') }}</td>
                <td class="text-right text-bold text-red" colspan="4">{{ defaultCurrency().' '.format_amount($total) }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
