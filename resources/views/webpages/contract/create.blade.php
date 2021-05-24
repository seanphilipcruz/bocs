<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-left">
                <a href="{{ route('contracts') }}" id="contracts" navigation class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i>  Back</a>
            </div>
            <div class="fa-pull-right">
                <div class="btn-group">
                    <a href="#new-agency-modal" data-toggle="modal" class="btn btn-outline-dark"><i class="fas fa-user"></i>   New Agency</a>
                    <a href="#new-advertiser-modal" data-toggle="modal" class="btn btn-outline-dark"><i class="fas fa-building"></i>   New Advertiser</a>
                </div>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="row">
        <div class="col">
            <div class="lead mb-0"><small class="text-danger">via</small>  {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
        </div>
    </div>
    <div class="my-1"></div>
    <form id="add-contract-form" data-form="Contract" data-request="add" action="{{ route('contracts.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <label for="station" class="h3">Station</label>
                <div id="station" class="row text-center">
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="DWRX Manila;" name="station[]" id="Manila">
                            <label class="form-check-label" for="Manila">
                                Manila
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="DYBT Cebu;" name="station[]" id="Cebu">
                            <label class="form-check-label" for="Cebu">
                                Cebu
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="DXBT Davao;" name="station[]" id="Davao">
                            <label class="form-check-label" for="Davao">
                                Davao
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3"></div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="agency_id">Agency <span id="kbp_accreditation"></span></label>
                    <select id="agency_id" name="agency_id" class="custom-select">
                        @forelse($agencies as $agency)
                            <option value="{{ $agency->agency_code }}">{{ $agency->agency_name }}</option>
                        @empty
                            <option value>--</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="advertiser_id">Advertiser</label>
                    <select id="advertiser_id" name="advertiser_id" class="custom-select">
                        @forelse($advertisers as $advertiser)
                            <option value="{{ $advertiser->advertiser_code }}">{{ $advertiser->advertiser_name }}</option>
                        @empty
                            <option value>--</option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="product">Product</label>
                    <input type="text" id="product" name="product" class="form-control" placeholder="Product Name">
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="bo_type">BO Type</label>
                            <select class="custom-select" id="bo_type" name="bo_type">
                                <option value="normal">Normal</option>
                                <option value="parent">Parent</option>
                                <option value="child">Child</option>
                            </select>
                        </div>
                    </div>
                    <div id="select_parent_bo" class="col" hidden>
                        <div class="form-group">
                            <label for="parent_bo">Parent BO</label>
                            <select class="custom-select" id="parent_bo" name="parent_bo">
                                @foreach($parents as $key => $bo_number)
                                    <option value="{{ $bo_number }}">{{ $bo_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="bo_number">BO Number</label>
                            <input class="form-control" type="text" name="bo_number" id="bo_number" placeholder="BO Number">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="ce_number">CE Number</label>
                            <input class="form-control" type="text" name="ce_number" id="ce_number" placeholder="CE Number">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="bo_date">BO Date</label>
                            <input type="date" id="bo_date" name="bo_date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label for="commencement">Commencement</label>
                        <input type="date" id="commencement" name="commencement" class="form-control">
                    </div>
                    <div class="col">
                        <label for="end_of_broadcast">End of Broadcast</label>
                        <input type="date" id="end_of_broadcast" name="end_of_broadcast" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3"></div>
        <div class="row">
            <div class="col-12">
                <a class="btn btn-outline-dark btn-block" data-toggle="collapse" href="#template" role="button" aria-expanded="false" aria-controls="template">Show Template   <i class="fas fa-bars"></i></a>
                <div class="collapse" id="template">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <select id="template" class="custom-select">
                                        <option value></option>
                                        <option>One(1)</option>
                                        <option>Two(2)</option>
                                        <option>Three(3)</option>
                                        <option>Four(4)</option>
                                        <option>Five(5)</option>
                                        <option>Six(6)</option>
                                        <option>Seven(7)</option>
                                        <option>Eight(8)</option>
                                        <option>Nine(9)</option>
                                        <option>Ten(10)</option>
                                        <option>Bonus one(1)</option>
                                        <option>Bonus two(2)</option>
                                        <option>Bonus three(3)</option>
                                        <option>Bonus four(4)</option>
                                        <option>Bonus five(5)</option>
                                        <option>Bonus six(6)</option>
                                        <option>Bonus seven(7)</option>
                                        <option>Bonus eight(8)</option>
                                        <option>Bonus nine(9)</option>
                                        <option>Bonus ten(10)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <select id="template1" class="custom-select">
                                        <option value></option>
                                        <option>15's spots/day,</option>
                                        <option>30's spots/day,</option>
                                        <option>AOB's spots/day,</option>
                                        <option>15's/day,</option>
                                        <option>30's/day,</option>
                                        <option>45's/day,</option>
                                        <option>60's/day,</option>
                                        <option>AOB's/day</option>
                                        <option>Event Sponsorship</option>
                                        <option>Major Event Sponsorship</option>
                                        <option>Minor Event Sponsorship</option>
                                        <option>Movie Premiere Sponsorship</option>
                                        <option>News Sponsorship/day,</option>
                                        <option>Product Song Branded</option>
                                        <option>Product Song Unbranded</option>
                                        <option>Program Sponsorship</option>
                                        <option>Promo/day,</option>
                                        <option>Remote Feeds/Live Feeds,</option>
                                        <option>Song Sponsorships/day,</option>
                                        <option>Scripted Timechecks/day,</option>
                                        <option>Timechecks </option>
                                        <option>Spiel/day,</option>
                                        <option>Talkies/day,</option>
                                        <option>Tips/day,</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                    <select id="template2" class="custom-select">
                                        <option value></option>
                                        <option>Monday </option>
                                        <option>Tuesday </option>
                                        <option>Wednesday </option>
                                        <option>Thursday </option>
                                        <option>Friday </option>
                                        <option>Saturday </option>
                                        <option>Saturday Bonus </option>
                                        <option>Sunday </option>
                                        <option>Sunday Bonus </option>
                                        <option>DAILY </option>
                                        <option>M-W-F </option>
                                        <option>T-TH </option>
                                        <option>M-Fri </option>
                                        <option>M-Sat </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                    <select id="template3" class="custom-select">
                                        <option value></option>
                                        <option>and </option>
                                        <option>to </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                    <select id="template4" class="custom-select">
                                        <option value></option>
                                        <option>Monday </option>
                                        <option>Tuesday </option>
                                        <option>Wednesday </option>
                                        <option>Thursday </option>
                                        <option>Friday </option>
                                        <option>Saturday </option>
                                        <option>Sunday </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <select id="template5" class="custom-select">
                                        <option value></option>
                                        <option>for </option>
                                        <option>with OBB </option>
                                        <option>with CBB </option>
                                        <option>with OBB & CBB </option>
                                        <option>to follow </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                    <select id="template6" class="custom-select">
                                        <option value></option>
                                        @for($template = 0; $template <= 100; $template++)
                                            <option>{{ $template }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <select id="template7" class="custom-select">
                                        <option value></option>
                                        <option>day/s</option>
                                        <option>week/s</option>
                                        <option>month/s</option>
                                        <option>day/s,R.O.S.</option>
                                        <option>month/s, R.O.S.</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3"></div>
        <div class="row">
            <div class="col">
                <label for="detail">Type of Media</label>
                <textarea type="text" id="detail" name="detail" rows="10" class="form-control"></textarea>
            </div>
        </div>
        <div class="my-3"></div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="manila_cash">Manila Cash</label>
                                    <input type="number" id="manila_cash" name="manila_cash" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="cebu_cash">Cebu Cash</label>
                                    <input type="number" id="cebu_cash" name="cebu_cash" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="davao_cash">Davao Cash</label>
                                    <input type="number" id="davao_cash" name="davao_cash" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="total_cash">Total Cash</label>
                                    <input type="number" id="total_cash" name="total_cash" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="manila_ex">Manila Ex Deal</label>
                                    <input type="number" id="manila_ex" name="manila_ex" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="cebu_ex">Cebu Ex Deal</label>
                                    <input type="number" id="cebu_ex" name="cebu_ex" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="davao_ex">Davao Ex Deal</label>
                                    <input type="number" id="davao_ex" name="davao_ex" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="total_ex">Total Ex Deal</label>
                                    <input type="number" id="total_ex" name="total_ex" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center text-center">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="total_amount">Total Package Cost</label>
                                    <input type="number" id="total_amount" name="total_amount" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="row justify-content-center text-center">
                            <div class="col-4">
                                <label for="package_cost" class="mb-0">Package Cost</label>
                                <div id="package_cost">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="package_cost" id="gross" value="Package Cost(GROSS)">
                                        <label class="form-check-label" for="gross">
                                            Gross
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="package_cost" id="net" value="Package Cost(NET)">
                                        <label class="form-check-label" for="net">
                                            Net
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="row justify-content-center text-center">
                            <div class="col-4">
                                <label for="package_cost_vat" class="mb-0">Value Added Tax:</label>
                                <div id="package_cost_vat">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="package_cost_vat" id="vatinc" value="VATINC">
                                        <label class="form-check-label" for="vatinc">
                                            VAT INC.
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="package_cost_vat" id="nonvat" value="NONVAT">
                                        <label class="form-check-label" for="nonvat">
                                            NON-VAT
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="package_cost_vat" id="vatex" value="VATEX">
                                        <label class="form-check-label" for="vatex">
                                            VAT-EX
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="row justify-content-center text-center">
                            <div class="col-4">
                                <label for="package_cost_salesdc_input">Sales Discount (Optional)</label>
                                <div id="package_cost_salesdc_input" class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-percent"></i>
                                    </span>
                                    </div>
                                    <input type="number" id="package_cost_salesdc" name="package_cost_salesdc" class="form-control" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="my-3"></div>
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                                <button type="reset" id="reset_cash" class="btn btn-outline-dark btn-block">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3"></div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center text-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="manila_prod">Manila Prod</label>
                                    <input type="number" id="manila_prod" name="manila_prod" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="cebu_prod">Cebu Prod</label>
                                    <input type="number" id="cebu_prod" name="cebu_prod" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="davao_prod">Davao Prod</label>
                                    <input type="number" id="davao_prod" name="davao_prod" class="form-control" value="0.00" readonly onblur="findTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="total_prod">Total Production Cost</label>
                                    <input type="number" id="total_prod" name="total_prod" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="row justify-content-center text-center">
                            <div class="col-4">
                                <label for="prod_cost" class="mb-0">Package Cost</label>
                                <div id="prod_cost">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="prod_cost" id="prod_gross" value="Production Cost(GROSS)">
                                        <label class="form-check-label" for="prod_gross">
                                            Gross
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="prod_cost" id="prod_net" value="Production Cost(NET)">
                                        <label class="form-check-label" for="prod_gross">
                                            Net
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="row justify-content-center text-center">
                            <div class="col-4">
                                <label for="prod_cost_vat" class="mb-0">Value Added Tax:</label>
                                <div id="prod_cost_vat">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="prod_cost_vat" id="prod_vat_inc" value="VATINC">
                                        <label class="form-check-label" for="vatinc">
                                            VAT INC.
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="prod_cost_vat" id="prod_non_vat" value="NONVAT">
                                        <label class="form-check-label" for="nonvat">
                                            NON-VAT
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="prod_cost_vat" id="prod_vat_ex" value="VATEX">
                                        <label class="form-check-label" for="vatex">
                                            VAT-EX
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <label for="prod_cost_salesdc_input">Sales Discount (Optional)</label>
                                <div id="prod_cost_salesdc_input" class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-percent"></i>
                                    </span>
                                    </div>
                                    <input type="number" id="prod_cost_salesdc" name="prod_cost_salesdc" class="form-control" value="0.00">
                                </div>
                            </div>
                            <div class="my-3"></div>
                        </div>
                        <div class="my-3"></div>
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                                <button type="reset" id="reset_prod" class="btn btn-outline-dark btn-block">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-3"></div>
        <div class="row justify-content-center">
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark btn-block"><i class="fas fa-save"></i>  Save</button>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="new-agency-modal" tabindex="-1" role="dialog" aria-labelledby="new-agency-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Agency</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add-agency-form" data-form="Agency" data-request="add" action="{{ route('agencies.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="agency_name">Agency Name</label>
                            <input type="text" id="agency_name" name="agency_name" class="form-control" placeholder="Agency Name">
                        </div>
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Contact Number">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Address">
                        </div>
                        <div class="form-group">
                            <label for="kbp_accredited">KBP Status</label>
                            <select id="kbp_accredited" name="kbp_accredited" class="custom-select">
                                <option value="">--</option>
                                <option value="1">Accredited</option>
                                <option value="0">Non-Accredited</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-outline-dark"><i class="fas fa-save"></i></button>
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-advertiser-modal" tabindex="-1" role="dialog" aria-labelledby="new-advertiser-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Advertiser</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add-advertiser-form" data-form="Advertiser" data-request="add"  action="{{ route('advertisers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="advertiser_name">Advertiser Name</label>
                            <input type="text" id="advertiser_name" name="advertiser_name" class="form-control" placeholder="Advertiser Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-outline-dark"><i class="fas fa-save"></i></button>
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // for agency / advertiser select
    function fetchLatest(url, data) {
        getAsync(url, data, 'JSON', beforeSend, onSuccess);

        function beforeSend() {

        }

        function onSuccess(result) {
            if(url.includes('agencies')) {
                $('#agency_id').append(result.agencies);
            } else {
                $('#advertiser_id').append(result.advertisers);
            }
        }
    }

    $(document).on('submit', '#add-agency-form, #add-advertiser-form', function(event) {
        event.preventDefault();
        let type = $(this).attr('id')
        let url = $(this).attr('action');
        let formData = new FormData(this);

        postAsync(url, formData, 'JSON', beforeSend, onSuccess);

        function beforeSend() {
            $('button[type="submit"]').attr('disabled', 'disabled');
            manualToast.fire({
                icon: 'info',
                title: 'Please wait ...'
            });
        }

        function onSuccess(result) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.modal').modal('hide');

            Toast.fire({
                icon: result.status,
                title: result.message,
            });

            if(type.includes('agency')) {
                fetchLatest('{{ route('agencies') }}', { "select": "select" });
            } else {
                fetchLatest('{{ route('advertisers') }}', { "select": "select" });
            }
        }
    });
</script>
