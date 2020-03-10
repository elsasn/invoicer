<form action="{{$paypal_url}}" method="post" name="frmTransaction" id="frmTransaction">
    <input type="hidden" name="business" value="{{$paypal_id}}"/>
    <input type="hidden" name="cmd" value="_xclick"/>
    <input type="hidden" name="item_name" value="Invoice No. {{$invoice->number}}"/>
    <input type="hidden" name="item_number" value="{{$invoice->uuid}}">
    <input type="hidden" name="amount" value="{{currency_convert(getCurrencyId($invoice->currency),$invoice_totals['amountDue'])}}"/>
    <input type="hidden" name="currency_code" value="{{defaultCurrencyCode()}}"/>
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="notify_url" value="{{route('paypal_notify')}}"/>
    <input type="hidden" name="cancel_return" value="{{route('getCancel',$invoice->uuid)}}"/>
    <input type="hidden" name="return" value="{{route('getDone')}}"/>
</form>
<script>document.frmTransaction.submit();</script>