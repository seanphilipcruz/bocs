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
                <div class="text-center">
                    Gross Sales: <div class="text-primary h3">{{ $gross_sales }}</div>
                </div>
            </div>
            <div class="card-body">
                <table id="monthlySalesReportTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Account Executive</th>
                        <th>Gross Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sales_report as $sales)
                        <tr>
                            <td>{{ $sales->year }}</td>
                            <td>{{ $sales->month }}</td>
                            <td>{{ $sales->Employee->first_name }} {{ $sales->Employee->last_name }}</td>
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
    executiveSR = $('#monthlySalesReportTable').DataTable({
        ajax: {
            url: '{{ route('sales.reports') }}',
            dataSrc: '',
            data: {
                'switch': 'executive',
                'refresh': true,
            }
        },
        columns: [
            { data: 'year' },
            { data: 'month' },
            { data: 'name' },
            { data: 'gross_sales' }
        ],
        order: [
            [ 0, 'desc' ],
            [ 1, 'desc']
        ]
    });

    setInterval(() => {
        executiveSR.ajax.reload(null, false);
    }, 3000);
</script>
