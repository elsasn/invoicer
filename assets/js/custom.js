$(document).ready(function () {
    $('form').validator();
        var t = $('.datatable').DataTable({
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]],
            "bLengthChange": true,
            "bInfo" : false,
            "filter" : true,
            "oLanguage": { "sSearch": ""}
        });
        $('div.dataTables_filter input').addClass('form-control input-sm');
        $('div.dataTables_length select').addClass('form-control input-sm');
        t.on('order.dt search.dt', function(){
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();

    //$('.datepicker').datepicker({format:'yyyy-mm-dd', autoclose:true});
    $('.datepicker').pikaday({ firstDay: 1, format:'YYYY-MM-DD', autoclose:true });
    $(document).ajaxStart(function() { Pace.restart(); });
    $(".chosen").chosen({ width: '100%' });
    if(isTouchDevice()===false) {
        $('[data-rel="tooltip"]').tooltip().click(function(e) {
            $(this).tooltip('toggle');
        });
    }
    $('[data-toggle="popover"]').popover();
    /*======================================
       CUSTOM SCRIPTS
    ========================================*/
    var $modal = $('#ajax-modal');
    $(document).on('click', '[data-toggle="ajax-modal"]', function(e){
        e.preventDefault();
        var element = $(this);
        var url = $(this).attr('href');
        if (url.indexOf('#') === 0) {
            $('#mainModal').modal('open');
        } else {
            $.get(url, function(data) {
                $modal.modal();
                $modal.html(data);
                $('.datepicker').pikaday({ firstDay: 1, format:'YYYY-MM-DD', autoclose:true });
                $('form').validator().on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                        return false;
                    }});
                $(".chosen").chosen({ width: '100%' });
                if(element.hasClass('ajaxNonReload')){
                    $modal.find('form').addClass('ajaxNonReload');
                }
                if(element.attr("data-element")) {
                    $modal.find('form').attr('data-element',element.attr("data-element"));
                }
            });
        }
    });
    $(document).on('submit', '.ajax-submit', function(e){
        e.preventDefault();
        var $form = $(this),$modal = $form.closest('.modal-dialog'),$modalBody = $form.find('.modal-body');
        $modalBody.find('.alert-danger').remove();
        var formData = new FormData(this);
        var ajaxNonReload = false;
        if($form.hasClass('ajaxNonReload')){
            ajaxNonReload = true;
            formData.append('ajaxNonReload', 'true');
        }
        $.ajax({
            type: "POST",
            url: $form.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend : function(){
                $modal.addClass('spinner');
            },
            success : function(data){
                if(ajaxNonReload){
                    if($form.attr("data-element")) {
                        var element = $form.attr("data-element");
                        $('#'+element).append('<option value="'+data.value+'">'+data.text+'</option>');
                        $('#'+element).val(data.value).trigger('chosen:updated');
                    }
                    $('#ajax-modal').modal('hide');
                }else{
                    window.location.reload();
                }
            },
            error : function(jqXhr, json, errorThrown){
                var errors = jqXhr.responseJSON;
                var errorStr = '';
                $.each( errors, function( key, value ) {
                    $('input[name="'+key+'"]').parents('.form-group').addClass("has-error");
                    errorStr += '- ' + value[0] + '<br/>';
                });
                var errorsHtml= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errorStr + '</div>';
                $modalBody.prepend(errorsHtml);
            },
            complete : function(){
                $modal.removeClass('spinner');
            }
        });
    });
    $(".animsition").animsition({
        inClass               :   'fade-in',
        outClass              :   'fade-out',
        inDuration            :    1500,
        outDuration           :    800,
        linkElement           :   '.animsition-link',
        loading               :    true,
        loadingParentElement  :   'body', //animsition wrapper element
        loadingClass          :   'animsition-loading',
        unSupportCss          : [ 'animation-duration', '-webkit-animation-duration', '-o-animation-duration'],
        //"unSupportCss" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
        //The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
        overlay               :   false,
        overlayClass          :   'animsition-overlay-slide',
        overlayParentElement  :   'body'
    });
    if($('#activation-modal').length == 1){
        $('#activation-modal').modal();
    }
});
function isTouchDevice(){
    return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
}
function checkLicense(){
    var usernameInput = $('#envato_username');
    var purchaseCodeInput = $('#purchase_code');
    $("#activation-modal .form-group").each(function(index) {
        $(this).removeClass("has-error");
    });
    if(usernameInput.val() == ''){
        usernameInput.parent().addClass("has-error");
    }else if(purchaseCodeInput.val().length < 9){
        purchaseCodeInput.parent().addClass("has-error");
    } else{
        var form = $('#verify_form');
        var formData = form.serialize();
        var modalBody = $('#activation-modal').find('.modal-body');
        $.ajax({
            url:form.attr('action'),
            type:"post",
            data:formData,
            beforeSend : function(){
                $('#activation-modal').find('.modal-dialog').addClass('spinner');
            },
            success:function(response){
                window.location.reload(true);
            },
            error : function(jqXhr, json, errorThrown){
                var response = jqXhr.responseJSON;
                var errorsHtml= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.error + '</div>';
                modalBody.prepend(errorsHtml);
            },
            complete : function(){
                $('#activation-modal').find('.modal-dialog').removeClass('spinner');
            }
        })
    }
}
/*--------------------------------------------------------------
 Template select navigation
 --------------------------------------------------------------*/
$(document).on('change', '#template_select', function(){
    window.location.href = this.value;
});
$(document).on('click', '#btn_add_row', function() {
    cloneRow('item_table');
});
$( document ).on('change', '#currency', function() {
    if ( $(this).val() != '') {
        $( '.currencySymbol' ).text( $( "[name='currency']").val() );
    }
});



      