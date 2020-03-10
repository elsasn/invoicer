<div class="col-md-12">
<table class="table table-hover table-bordered ">
    <thead>
    <tr class="table_header">
        <th>{{ trans('application.status') }}</th>
        <th>{{ trans('application.invoice_number') }}</th>
        <th>{{ trans('application.date') }} </th>
        <th>{{ trans('application.client') }}</th>
        <th class="text-right">{{trans('application.amount')}}</th>
        <th class="text-right">{{trans('application.paid')}}</th>
        <th class="text-right">{{trans('application.amount_due')}}</th>
    </tr>
    </thead>
    <tbody>
    @php($total_invoiced = 0)
    @php($total_paid = 0)
    @php($total_due = 0)
    @foreach($invoices as $invoice)
        @php ($total_invoiced += currency_convert(getCurrencyId($invoice->currency),$invoice->totals['grandTotal']))
        @php ($total_paid += currency_convert(getCurrencyId($invoice->currency),$invoice->totals['paidFormatted']))
        @php ($total_due += currency_convert(getCurrencyId($invoice->currency),$invoice->totals['amountDue']))
        <tr>
            <td><span class="label {{ statuses()[$invoice->status]['class'] }}">{{ strtoupper(statuses()[$invoice->status]['label']) }}</span></td>
            <td><a href="{{ route('invoices.show', $invoice->uuid) }}">{{ $invoice->number }}</a></td>
            <td>{{ format_date($invoice->invoice_date) }}</td>
            <td><a href="{{ route('clients.show', $invoice->client_id ) }}">{{ $invoice->client->name }}</a></td>
            <td class="text-right">{{  defaultCurrency().' '.format_amount(currency_convert(getCurrencyId($invoice->currency),$invoice->totals['grandTotal'])) }} </td>
            <td class="text-right">{{  defaultCurrency().' '.format_amount(currency_convert(getCurrencyId($invoice->currency),$invoice->totals['paidFormatted'])) }} </td>
            <td class="text-right">{{  defaultCurrency().' '.format_amount(currency_convert(getCurrencyId($invoice->currency),$invoice->totals['amountDue'])) }} </td>
        </tr>
    @endforeach
    <tr>
        <td class="text-bold" colspan="4">{{ trans('application.total') }}</td>
        <td class="text-bold text-right">{{ defaultCurrency().' '.format_amount($total_invoiced) }}</td>
        <td class="text-bold text-right">{{ defaultCurrency().' '.format_amount($total_paid) }}</td>
        <td class="text-right text-bold text-red" colspan="4">{{ defaultCurrency().' '.format_amount($total_due) }}</td>
    </tr>
    </tbody>
</table>
</div>