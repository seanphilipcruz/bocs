<div class="container">
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-block d-md-block d-lg-block d-xl-block">
            <div class="card-body">
                <table id="advertiserLogsTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Advertiser Name</th>
                        <th>Action Taken</th>
                        <th>Employee Name</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $advertiser)
                        <tr>
                            <td>{{ $advertiser->id }}</td>
                            <td>{{ $advertiser->Advertiser->advertiser_name }}</td>
                            <td>{{ $advertiser->action }}</td>
                            <td>{{ $advertiser->Employee->first_name }} {{ $advertiser->Employee->last_name }}</td>
                            <td>{{ $advertiser->created_at }}</td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-block d-sm-none d-md-none d-lg-none d-xl-none">
            <div class="text-center h4 mb-0">
                Table display is not available for this device's resolution.
            </div>
        </div>
    </div>
</div>

<script>
    advertiserLogsTable = $('#advertiserLogsTable').DataTable({
        order: [
            [ 0, 'desc' ]
        ]
    });
</script>
