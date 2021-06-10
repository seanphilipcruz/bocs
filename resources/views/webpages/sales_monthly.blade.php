<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-right">
                <a href="{{ route('sales.reports') }}" id="sales_report" class="btn btn-outline-dark" navigation><i class="fas fa-exchange-alt"></i>  Sorting</a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-header">
                <div id="gross_sales_amount" class="text-center">
                    {{ date('F') }} Gross Sales: <div class="text-primary h3">{{ $gross_sales }}</div>
                </div>
            </div>
            <div class="card-body">
                <table id="monthlySalesReportTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Station</th>
                        <th>Gross Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sales_report as $sales)
                        <tr>
                            <td>{{ $sales->year }}</td>
                            <td>{{ $sales->month }}</td>
                            <td>{{ $sales->station }}</td>
                            <td>{{ $sales->gross_sales }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
            <div class="text-center h4 mb-0">
                Table display is not available for this device's resolution.
            </div>
        </div>
    </div>
</div>

<script>
    monthlySR = $('#monthlySalesReportTable').DataTable({
        ajax: {
            url: '{{ route('sales.reports') }}',
            dataSrc: 'sales_reports',
            data: {
                'switch': 'monthly',
                'refresh': true
            }
        },
        columns: [
            { data: 'year' },
            { data: 'month' },
            { data: 'station' },
            { data: 'gross_sales' },
        ],
        order: [
            [ 0, 'desc' ],
            [ 1, 'desc']
        ]
    });

    setInterval(() => {
        monthlySR.ajax.reload(null, false);

        getAsync('{{ route('sales.reports') }}', { 'switch': 'monthly', 'refresh': true }, 'JSON', beforeSend, onSuccess);

        function beforeSend() {

        }

        function onSuccess(result) {
            $('#gross_sales_amount').empty().append(result.gross_sales);
        }
    }, 5500);
</script>
