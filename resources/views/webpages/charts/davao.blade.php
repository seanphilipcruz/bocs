<div class="my-3"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="chart-container">
                    <canvas id="davao"></canvas>
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
                    <canvas id="davao_ae"></canvas>
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
                    <canvas id="davao_yearly"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    davaoSales = $('#davao');

    davaoSalesLabel = {!! json_encode($data['davaoMonths']) !!};
    davaoGrossSales = {!! json_encode($data['davaoGrossSales']) !!};

    let davaoSalesConfig = {
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
                text: 'Davao Gross Sales'
            }
        }
    }

    let davaoSalesDataset = {
        labels: davaoSalesLabel,
        datasets: [{
            label: 'Davao Sales',
            data: davaoGrossSales,
            fill: false,
            borderColor: 'rgb(166, 87, 142)',
        }]
    }

    davaoChart = new Chart(davaoSales, {
        type: 'line',
        data: davaoSalesDataset,
        options: davaoSalesConfig
    });
    // end

    // second chart
    davaoAESales = $('#davao_ae');

    davaoExecutiveSalesLabel = {!! json_encode($data['davaoExecutives']) !!};
    davaoExecutiveSales = {!! json_encode($data['davaoAESales']) !!};

    let davaoAEChartConfig = {
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
                text: 'Davao AE Sales'
            }
        }
    }

    let davaoAEChartDataset = {
        labels: davaoExecutiveSalesLabel,
        datasets: [
            {
                label: 'Sale',
                data: davaoExecutiveSales,
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

    davaoAEChart = new Chart(davaoAESales, {
        type: 'bar',
        data: davaoAEChartDataset,
        options: davaoAEChartConfig,
    });
    // end

    // third chart or the yearly sales chart
    davaoYearlySales = $('#davao_yearly');

    davaoYearlySalesLabel = {!! json_encode($data['davaoYears']) !!};
    davaoYearlyGrossSales = {!! json_encode($data['davaoYearlyGrossSales']) !!};

    let davaoYearlySalesConfig = {
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Davao Yearly Sales'
            }
        }
    }

    let davaoYearlySalesDataset = {
        labels: davaoYearlySalesLabel,
        datasets: [{
            label: 'Yearly Sales',
            data: davaoYearlyGrossSales,
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

    davaoYearlySalesChart = new Chart(davaoYearlySales, {
        type: 'bar',
        data: davaoYearlySalesDataset,
        options: davaoYearlySalesConfig
    });
    // end
</script>
