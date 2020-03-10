<script type="text/javascript">
$(function(){
    $('tr.item select').chosen({width:'100%'});
    $('.text_editor').wysihtml5({image:false,link:false});
    $( document ).on("click change paste keyup", ".calcEvent", function() {
        calcTotals();
    });
    $(document).on('click', '.delete_row', function(){
        $(this).parents('tr').remove();
        calcTotals();
    });
    $( document ).on('click', '.deleteItem', function() {
        var $this = $(this);
        BootstrapDialog.show({
            title: '{{ trans('application.deleting_record') }}',
            message: '{{ trans('application.delete_confirmation_msg') }}',
            buttons: [ {
                icon: 'fa fa-check',
                label: ' Yes',
                cssClass: 'btn-success btn-xs',
                action: function(dialogItself){
                    $.post("{{url('invoices/deleteItem') }}", { "_token": "{{ csrf_token() }}", id : $this.attr('data-id') } , 'json').done(function(data){
                        $this.parents('tr').remove();
                        calcTotals();
                    }).fail(function(jqXhr, json, errorThrown){
                    }).always(function(){
                        dialogItself.close();
                    });
                }
            }, {
                icon: 'fa fa-remove',
                label: 'No',
                cssClass: 'btn-danger btn-xs',
                action: function(dialogItself){
                    dialogItself.close();
                }
            }]
        });
    });
    $('#btn_product_list_modal').click(function() {
        $('.invoice').addClass('spinner');
        var $modal = $('#ajax-modal');
        $.get('{{url("products_modal")}}', function(data) {
            $modal.modal();
            $modal.html(data);
            $('.invoice').removeClass('spinner');
            var t = $('.datatable').DataTable({
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]],
                "bLengthChange": false,
                "bInfo" : false,
                "filter" : true,
                'paging': true,
                "oLanguage": { "sSearch": ""}
            });
            $('div.dataTables_filter input').addClass('form-control input-sm');
            $('[data-toggle="popover"]').popover();
        });
    });
    $('#invoice_form').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            $('.invoice').addClass('spinner');
            $('.invoice .alert-danger').remove();
            var $form = $('#invoice_form');
            var data = $('#invoice_form select, input, textarea').not('#item_name,#item_description, #tax, #quantity, #price, #itemId').serializeArray();
            var items = [];
            var item_order = 1;
            $('table tr.item').each(function() {
                var row = {};
                $(this).find('input,select,textarea').each(function()
                {
                    if($(this).attr('name')) row[$(this).attr('name')] = $(this).val();
                });
                items.push(row);
            });
            data.push({name : 'items', value: JSON.stringify(items)});
            $.post($form.attr('action'), data , 'json').done(function(data){
                if(data.errors)
                {
                    return;
                }
                if(data.redirectTo){
                    window.location = data.redirectTo;
                }else {
                    window.location.reload();
                }
                // Refresh page, or redirect if url has been passed
            }).fail(function(jqXhr, json, errorThrown){
                var errors = jqXhr.responseJSON;
                var errorStr = '';
                $.each( errors, function( key, value ) {
                    $('#'+key).parents('.form-group').addClass('has-error');
                    $('.'+key).parents('.form-group').addClass('has-error');
                    errorStr += '- ' + value[0] + '<br/>';
                });
                var errorsHtml= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errorStr + '</div>';
                $('.invoice').prepend(errorsHtml);
            }).always(function(){
                $('.invoice').removeClass('spinner');
            });
            return false;
        }
    });
    /* ----------------------------------------------------------------------------------------------------
    ADDING SELECTED PRODUCTS TO THE INVOICE
    --------------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#select-products-confirm', function()
    {
        var products_lookup_ids = [];
        $("input[name='products_lookup_ids[]']:checked").each(function ()
        {
            products_lookup_ids.push($(this).val());
        });
        $.post("{{ url('process_products_selections') }}", {
            products_lookup_ids : products_lookup_ids,_token:'{{ csrf_token() }}'
        }).done(function(data){
            var products = data.products;
            for(var key in products) {
                //noinspection JSJQueryEfficiency
                var last_row = $('#item_table tr:last');
                if (last_row.find('input[name=item_name]').val() !== '')
                {
                    cloneRow('item_table');
                    var last_row = $('#item_table tr:last');
                    last_row.find('input[name=item_name]').val(products[key].name);
                    last_row.find('textarea[name=item_description]').val(products[key].description);
                    last_row.find('input[name=price]').val(products[key].price);
                    last_row.find('input[name=quantity]').val('1');
                }
                else
                {
                    last_row.find('input[name=item_name]').val(products[key].name);
                    last_row.find('textarea[name=item_description]').val(products[key].description);
                    last_row.find('input[name=price]').val(products[key].price);
                    last_row.find('input[name=quantity]').val('1');
                }
                $('#modal-choose-products').modal('hide');
                calcTotals();
            }
        }).always(function(){
            $('#ajax-modal').modal('toggle');
        });
    });

    $(document).on('click', '#change_invoice_num', function(){
        $("#number").prop("readonly", false);
    });
});
function calcTotals(){
        var subTotal    = 0;
        var total       = 0;
        var amountDue   = 0;
        var totalTax    = 0;
        $('tr.item').each(function(){
            var quantity    = parseFloat($(this).find("[name='quantity']").val());
            var price        = parseFloat($(this).find("[name='price']").val());
            var itemTax     = $(this).find("[name='tax']").val();
            var itemTotal   = parseFloat(quantity * price) > 0 ? parseFloat(quantity * price) : 0;
            var taxValue    = $(this).find("[name='tax'] option[value='" + itemTax + "']").attr('data-value');
            subTotal        += parseFloat(price * quantity) > 0 ? parseFloat(price * quantity) : 0;
            totalTax        += parseFloat(price * quantity * taxValue/100) > 0 ? parseFloat(price * quantity * taxValue/100) : 0;
            $(this).find(".itemTotal").text( itemTotal.toFixed(2) );
        });
        var discount_mode = parseInt($("[name='discount_mode']").val());
        var discount    = parseFloat($("[name='discount']").val()) > 0 ? parseFloat($("[name='discount']").val()) : 0;
        var paid        = parseFloat($("#paidAmount").val()) > 0 ? parseFloat($("#paidAmount").val()) : 0;
        var discount_amount = discount_mode == 1 ? subTotal * (discount/100) : discount;
        total           += parseFloat(subTotal+totalTax-discount_amount);
        amountDue       += parseFloat(subTotal+totalTax-discount_amount-paid);
        $( '#subTotal' ).text( subTotal.toFixed(2) );
        $( '#taxTotal' ).text( totalTax.toFixed(2) );
        $( '#grandTotal' ).text( total.toFixed(2) );
        $( '#amountDue' ).text( amountDue.toFixed(2) );
}
var count = "1";
function cloneRow(in_tbl_name)
{
        var tbody = document.getElementById(in_tbl_name).getElementsByTagName("tbody")[0];
        // create row
        var row = document.createElement("tr");
        // create table cell 1
        var td1 = document.createElement("td");
        var strHtml1 = "<span class='btn btn-danger btn-xs delete_row'><i class='fa fa-minus'></i></span> ";
        td1.innerHTML = strHtml1.replace(/!count!/g,count);
        // create table cell 2
        var td2 = document.createElement("td");
        var strHtml2 = '<div class="form-group">{!! Form::text("item_name",null, ["class" => "form-control input-sm item_name", "id"=>"item_name" , "required"]) !!}</div>';
        td2.innerHTML = strHtml2.replace(/!count!/g,count);
        // create table cell 3
        var td3 = document.createElement("td");
        var strHtml3 = '<div class="form-group">{!! Form::textarea("item_description",null, ["class" => "form-control item_description input-sm", "id"=>"item_description" ,"rows"=>"1",'style'=>'resize: vertical;text-transform: capitalize;' ]) !!}</div>';
        td3.innerHTML = strHtml3.replace(/!count!/g,count);
        // create table cell 4
        var td4 = document.createElement("td");
        var strHtml4 = '<div class="form-group">{!! Form::input("number","quantity",null, ["class" => "form-control input-sm calcEvent quantity", "id"=>"quantity" , "required", "step" => "any", "min" => "0"]) !!}</div> ';
        td4.innerHTML = strHtml4.replace(/!count!/g,count);
        // create table cell 5
        var td5 = document.createElement("td");
        var strHtml5 = '<div class="form-group">{!! Form::input("number","price",null, ["class" => "form-control input-sm calcEvent price", "id"=>"price", "required","step" => "any", "min" => "0"]) !!}</div> ';
        td5.innerHTML = strHtml5.replace(/!count!/g,count);
        // create table cell 6
        var td6 = document.createElement("td");
        var strHtml6 = '<div class="form-group">{!! Form::customSelect("tax",$taxes['options'],$taxes['default'], ["class" => "form-control input-sm calcEvent tax", "id"=>"tax"]) !!}</div> ';
        td6.innerHTML = strHtml6.replace(/!count!/g,count);
        // create table cell 7
        var td7 = document.createElement("td");
        var strHtml7 = '<span class="itemTotal">0.00</span> ';
        td7.innerHTML = strHtml7.replace(/!count!/g,count);
        td7.className = 'text-right';
        // append data to row
        row.appendChild(td1);
        row.appendChild(td2);
        row.appendChild(td3);
        row.appendChild(td4);
        row.appendChild(td5);
        row.appendChild(td6);
        row.appendChild(td7);
        // add to count variable
        count = parseInt(count) + 1;
        // append row to table
        tbody.appendChild(row);
        row.className = 'item';
        $('tr.item:last select').chosen({width:'100%'});
}
</script>

