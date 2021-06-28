<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-left btn-group">
                <a href="#" data-link="{{ route('sales.reports') }}" data-action="switch" data-switch="monthly" class="btn btn-outline-dark"><i class="fas fa-exchange-alt"></i>  Monthly View</a>
                <a href="#" data-link="{{ route('sales.reports') }}" data-action="switch" data-switch="executive" class="btn btn-outline-dark"><i class="fas fa-user-alt"></i>  Executives View</a>
            </div>
            <div class="fa-pull-right">
                <a href="#sort-modal" data-toggle="modal" class="btn btn-outline-dark"><i class="fas fa-wrench"></i>  Sort</a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-header">
                <div class="text-center">
                    {{ $month }} Gross Sales: <div class="text-primary h3">{{ $gross_sales }}</div>
                </div>
            </div>
            <div id="sr_table_container" class="card-body">
                <table id="salesReportTable" class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Contract Number</th>
                            <th>BO Number</th>
                            <th>Advertiser</th>
                            <th>Station</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Gross Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_report as $sales)
                            <tr>
                                <td>{{ $sales->year }}</td>
                                <td>{{ $sales->month }}</td>
                                <td>{{ $sales->Contract->contract_number }}</td>
                                <td>{{ $sales->Contract->bo_number }}</td>
                                <td>{{ $sales->Contract->Advertiser->advertiser_name }}</td>
                                <td>{{ $sales->station }}</td>
                                <td>{{ $sales->type }}</td>
                                <td>{{ $sales->amount }}</td>
                                <td>{{ $sales->gross_amount }}</td>
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

<!-- Modal -->
<div class="modal fade" id="sort-modal" tabindex="-1" role="dialog" aria-labelledby="sort-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sort Table</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="sort_form" action="{{ route('sales.reports') }}" method="GET">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="sort_by">Sort by:</label>
                                <select id="sort_by" name="sort_by" class="custom-select">
                                    <option value>All</option>
                                    <option value="month">Month</option>
                                    <option value="quarter">Quarter</option>
                                    <option value="year">Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="ae">Account Executive:</label>
                                <select id="ae" name="employee_id" class="custom-select">
                                    <option value>All</option>
                                    @foreach($executives as $executive)
                                        <option value="{{ $executive->id }}">{{ $executive->first_name }} {{ $executive->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="station">Station:</label>
                                <select id="station" name="station" class="custom-select">
                                    <option value>All</option>
                                    <option value="manila">Manila</option>
                                    <option value="cebu">Cebu</option>
                                    <option value="davao">Davao</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="advertiser">Advertiser:</label>
                                <select id="advertiser" name="advertiser_id" class="custom-select">
                                    <option value>All</option>
                                    @foreach($advertisers as $advertiser)
                                        <option value="{{ $advertiser->advertiser_code }}">{{ $advertiser->advertiser_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="agency">Agency:</label>
                                <select id="agency" name="agency_id" class="custom-select">
                                    <option value>All</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->agency_code }}">{{ $agency->agency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="date_sorter">
                        <div id="month_row" class="row" hidden>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month">Month:</label>
                                    <select id="month" name="month" class="custom-select">
                                        <option value>--</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month_year">Year:</label>
                                    <select id="month_year" name="month_year" class="custom-select">
                                        <option value>--</option>
                                        @forelse($yearly_sales as $years)
                                            <option value="{{ $years }}">{{ $years }}</option>
                                        @empty
                                            <option value="{{ $years }}">{{ $years }}</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="quarter_row" class="row" hidden>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quarter">Quarter:</label>
                                    <select id="quarter" name="quarter" class="custom-select">
                                        <option value>--</option>
                                        <option value="1">First</option>
                                        <option value="2">Second</option>
                                        <option value="3">Third</option>
                                        <option value="4">Quarter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="quarter_year">Year:</label>
                                <select id="quarter_year" name="quarter_year" class="custom-select">
                                    <option value>--</option>
                                    @forelse($yearly_sales as $years)
                                        <option value="{{ $years }}">{{ $years }}</option>
                                    @empty
                                        <option value="{{ $years }}">{{ $years }}</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div id="year_row" class="row" hidden>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <select id="year" name="year" class="custom-select">
                                        <option value>--</option>
                                        @forelse($yearly_sales as $years)
                                            <option value="{{ $years }}">{{ $years }}</option>
                                        @empty
                                            <option value="{{ $years }}">{{ $years }}</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-outline-dark"><i class="fas fa-search"></i>  Sort</button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    srTable = $('#salesReportTable').DataTable({
        order: [
            [ 0, 'desc' ],
            [ 1, 'desc' ],
            [ 4, 'asc' ]
        ]
    });
</script>
