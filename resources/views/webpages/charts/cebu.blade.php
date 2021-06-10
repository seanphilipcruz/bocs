<div class="my-3"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="chart-container">
                    <canvas id="cebu"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="my-3"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="chart-container-small">
                    <canvas id="cebu_ae"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="my-3"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="chart-container-small">
                    <canvas id="cebu_yearly"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    cebuSales = $('#cebu');

    cebuSalesLabel = {!! json_encode($data['cebuMonths']) !!};
    cebuGrossSales = {!! json_encode($data['cebuGrossSales']) !!};

    let cebuSalesConfig = {
        animations: {
            tension: {
                duration: 2500,
                easing: 'linear',
                from: 0.4,
                to: 0.3,
                loop: true
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Cebu Gross Sales'
            }
        }
    }

    let cebuSalesDataset = {
        labels: cebuSalesLabel,
        datasets: [{
            label: 'Cebu Sales',
            data: cebuGrossSales,
            fill: false,
            borderColor: 'rgb(153, 102, 255)',
        }]
    }

    cebuChart = new Chart(cebuSales, {
        type: 'line',
        data: cebuSalesDataset,
        options: cebuSalesConfig
    });
    // end

    // second chart
    cebuAESales = $('#cebu_ae');

    cebuExecutiveSalesLabel = {!! json_encode($data['cebuExecutives']) !!};
    cebuExecutiveSales = {!! json_encode($data['cebuAESales']) !!};

    let cebuAEChartConfig = {
        scales: {
            y: {
                beginAtZero: true,
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Cebu AE Sales'
            }
        }
    }

    let cebuAEChartDataset = {
        labels: cebuExecutiveSalesLabel,
        datasets: [
            {
                label: 'Sale',
                data: cebuExecutiveSales,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 205, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(54, 162, 235)',
                    'rgba(153, 102, 255)',
                    'rgba(201, 203, 207)'
                ]
            }
        ]
    };

    cebuAEChart = new Chart(cebuAESales, {
        type: 'bar',
        data: cebuAEChartDataset,
        options: cebuAEChartConfig,
    });
    // end

    // third chart or the yearly sales chart
    cebuYearlySales = $('#cebu_yearly');

    cebuYearlySalesLabel = {!! json_encode($data['cebuYears']) !!};
    cebuYearlyGrossSales = {!! json_encode($data['cebuYearlyGrossSales']) !!};

    let cebuYearlySalesConfig = {
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Cebu Yearly Sales'
            }
        }
    }

    let cebuYearlySalesDataset = {
        labels: cebuYearlySalesLabel,
        datasets: [{
            label: 'Yearly Sales',
            data: cebuYearlyGrossSales,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132)',
                'rgba(255, 159, 64)',
                'rgba(255, 205, 86)',
                'rgba(75, 192, 192)',
                'rgba(54, 162, 235)',
                'rgba(153, 102, 255)',
                'rgba(201, 203, 207)'
            ]
        }],
    }

    cebuYearlySalesChart = new Chart(cebuYearlySales, {
        type: 'bar',
        data: cebuYearlySalesDataset,
        options: cebuYearlySalesConfig
    });
    // end
</script>
