<div class="container">
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="salesLogTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Sales Id</th>
                        <th>Action Taken</th>
                        <th>Employee Number</th>
                        <th>Date Updated</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $sales)
                            <tr>
                                <td>{{ $sales->Sales->id }}</td>
                                <td>{{ $sales->action }}</td>
                                <td>{{ $sales->Employee->first_name }} {{ $sales->Employee->last_name }}</td>
                                <td>{{ $sales->created_at }}</td>
                            </tr>
                        @empty
                            <tr id="tableBody">
                                <td colspan="9">
                                    <div class="alert alert-danger m-0 text-center">
                                        No Data Found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
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
    salesLogsTable = $('#salesLogTable').DataTable({
        order: [
            [ 0, 'desc' ],
        ]
    })
</script>
