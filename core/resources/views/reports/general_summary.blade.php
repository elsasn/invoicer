<div class="col-md-6 text-center">
    <div id="yearly_overview">
        <h4>{{trans('application.yearly_overview')}}</h4>
        <canvas id="yearly_overview_inner"></canvas>
    </div>
</div>
<div class="col-md-6 text-center">
    <div id="payment_overview">
        <h4>{{trans('application.payment_overview')}}</h4>
        <canvas id="payment_overview_inner"></canvas>
    </div>
</div>
<script>
    var income_data     = '{{ $yearly_income }}';
    var expense_data    = '{{ $yearly_expense }}';
    income_data = JSON.parse(income_data.replace(/&quot;/g, '\"'));
    expense_data = JSON.parse(expense_data.replace(/&quot;/g, '\"'));
    var lineChartData   = {
        labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        datasets : [{
            label               : "Income",
            fillColor           : "rgba(14,172,147,0.1)",
            strokeColor         : "rgba(14,172,147,1)",
            pointColor          : "rgba(14,172,147,1)",
            pointStrokeColor    : "#fff",
            pointHighlightFill  : "rgba(54,73,92,0.8)",
            pointHighlightStroke: "rgba(54,73,92,1)",
            data                : income_data
        },
            {
                label               : "Expenditure",
                fillColor           : "rgba(244,167,47,0)",
                strokeColor         : "rgba(244,167,47,1)",
                pointColor          : "rgba(217,95,6,1)",
                pointStrokeColor    : "#fff",
                pointHighlightFill  : "rgba(54,73,92,0.8)",
                pointHighlightStroke: "rgba(54,73,92,1)",
                data                : expense_data
            }
        ]
    }
    var pieData = [
        {
            value: '{{ $total_payments }}',
            color:"#2FB972",
            highlight: "#37D484",
            label: "Amount Received"
        },
        {
            value: '{{ $total_outstanding }}',
            color:"#C84135",
            highlight: "#EA5548",
            label: "Outstanding Amount"
        },
    ];
    $(function() {
        Chart.defaults.global.scaleFontSize = 12;
        var chartDiv = document.getElementById("yearly_overview_inner").getContext("2d");
        lineChart = new Chart(chartDiv).Line(lineChartData, {
            responsive: true
        });
        $('#yearly_overview').append( lineChart.generateLegend() );
        var chartDiv = document.getElementById("payment_overview_inner").getContext("2d");
        pieChart = new Chart(chartDiv).Pie(pieData, {
            responsive : true
        });
        $('#payment_overview').append( pieChart.generateLegend() );
    });
</script>