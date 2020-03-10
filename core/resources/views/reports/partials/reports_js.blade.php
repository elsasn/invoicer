<script src="{{ asset('assets/js/chart.js') }}"></script>
<script type="text/javascript">
    $(function() {
        general_summary();
    });

    //function to generate general summary report
    function general_summary() {
        $('#report-body').addClass('spinner');
        $.post("{{ url('reports/general') }}", {_token : '{{ csrf_token() }}'},'json').done(function(data){
            $('#report-body').html(data);
        }).always(function(){
            $('#report-body').removeClass('spinner');
        });
    }

    //function to generate payments summary report
    function payments_summary() {
        var client 		= $('#client_id').length ? $('#client_id').val() : 'all';
        var from_date 	= $('#from_date').length ? $('#from_date').val() : '';
        var to_date 	= $('#to_date').length ? $('#to_date').val() : '';

       $('#report-body').addClass('spinner');
       $.post("{{ url('reports/payment_summary') }}", {
                    client		: client,
                    from_date	: from_date,
                    to_date		: to_date,
                    _token      : '{{ csrf_token() }}'
                }, 'json').done(function(data){
                    $('#report-body').html(data);
                    $(".chosen").chosen({ width: '100%' });
                }).always(function(){
                    $('#report-body').removeClass('spinner');
        });
    }

    //function to get the clients statement
    function client_statement(){
        var client 		= $('#client_id').length ? $('#client_id').val() : 0;
        $('#report-body').addClass('spinner');
        $.post("{{ url('reports/client_statement') }}", {
            client		: client,
            _token      : '{{ csrf_token() }}'
        }, 'json').done(function(data){
            $('#report-body').html(data);
            $(".chosen").chosen({ width: '100%' });
        }).always(function(){
            $('#report-body').removeClass('spinner');
        });
    }

    //function to get the invoices report
    function invoices_report(){
        var client 		= $('#client_id').length ? $('#client_id').val() : 0;
        $('#report-body').addClass('spinner');
        $.post("{{ url('reports/invoices_report') }}", {
            client		: client,
            _token      : '{{ csrf_token() }}'
        }, 'json').done(function(data){
            $('#report-body').html(data);
            $(".chosen").chosen({ width: '100%' });
        }).always(function(){
            $('#report-body').removeClass('spinner');
        });
    }
    //function to get the expenses report
    function expenses_report(){
        var from_date 	= $('#from_date').length ? $('#from_date').val() : '';
        var to_date 	= $('#to_date').length ? $('#to_date').val() : '';
        var category 	= $('#category').length ? $('#category').val() : 0;
        $('#report-body').addClass('spinner');
        $.post("{{ url('reports/expenses_report') }}", {
            from_date	: from_date,
            to_date		: to_date,
            category	: category,
            _token      : '{{ csrf_token() }}'
        }, 'json').done(function(data){
            $('#report-body').html(data);
            $(".chosen").chosen({ width: '100%' });
        }).always(function(){
            $('#report-body').removeClass('spinner');
        });
    }
</script>
