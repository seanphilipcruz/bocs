<div class="my-3"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="chart-container">
                    <canvas id="manila"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="my-3"></div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-container-small">
                    <canvas id="manila_ae"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div id="chart-container-small">
                    <canvas id="manila_yearly"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // charts.js configuration for manila

    // first chart
    manilaSales = $('#manila');

    let grossSalesLabels = {!! json_encode($data['manilaMonths']) !!};
    let grossSales = {!! json_encode($data['manilaGrossSales']) !!};

    let config = {
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
                text: 'Manila Gross Sales'
            }
        }
    }

    // datasets for the sales across the stations
    let grossSalesDataset = {
        labels: grossSalesLabels,
        datasets: [{
            label: 'Manila Sales',
            data: grossSales,
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
        }]
    }

    // charts
    manilaChart = new Chart(manilaSales, {
        type: 'line',
        data: grossSalesDataset,
        options: config
    });
    // end

    // second chart
    aeSales = $('#manila_ae');

    executiveSalesLabel = {!! json_encode($data['manilaExecutives']) !!};
    executiveSales = {!! json_encode($data['manilaAESales']) !!};

    let aeChartConfig = {
        indexAxis: 'y',
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
                text: 'Manila AE Sales'
            }
        }
    }

    let aeChartDataset = {
        labels: executiveSalesLabel,
        datasets: [
            {
                label: 'Sale',
                data: executiveSales,
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

    aeChart = new Chart(aeSales, {
        type: 'bar',
        data: aeChartDataset,
        options: aeChartConfig,
    });
    // end

    // third chart or the yearly sales chart
    yearlySales = $('#manila_yearly');

    yearlySalesLabel = {!! json_encode($data['manilaYears']) !!};
    yearlyGrossSales = {!! json_encode($data['manilaYearlyGrossSales']) !!};

    let yearlySalesConfig = {
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Manila Yearly Sales'
            }
        }
    }

    let yearlySalesDataset = {
        labels: yearlySalesLabel,
        datasets: [{
            label: 'Yearly Sales',
            data: yearlyGrossSales,
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

    yearlySalesChart = new Chart(yearlySales, {
        type: 'pie',
        data: yearlySalesDataset,
        options: yearlySalesConfig
    });
    // end
</script>
