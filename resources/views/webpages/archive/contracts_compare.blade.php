<div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <tr>
                    <th>Name</th>
                    <th>Old Version</th>
                    <th>New Version</th>
                </tr>
                <tr>
                    <td>Contract Number</td>
                    @if($archive->Contract->contract_number !== $archive->contract_number)
                        <td class="text-primary">{{ $archive->Contract->contract_number }}</td>
                        <td class="text-primary">{{ $archive->contract_number }}</td>
                    @else
                        <td>{{ $archive->Contract->contract_number }}</td>
                        <td>{{ $archive->contract_number }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Station</td>
                    @if($archive->Contract->station !== $archive->station)
                        <td class="text-primary">{{ $archive->Contract->station }}</td>
                        <td class="text-primary">{{ $archive->station }}</td>
                    @else
                        <td>{{ $archive->Contract->station }}</td>
                        <td>{{ $archive->station }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Agency</td>
                    @if($archive->Contract->agency_id !== $archive->agency_id)
                        <td class="text-primary">{{ $archive->Contract->Agency->agency_name }}</td>
                        <td class="text-primary">{{ $archive->Agency->agency_name }}</td>
                    @else
                        <td>{{ $archive->Contract->Agency->agency_name }}</td>
                        <td>{{ $archive->Agency->agency_name }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Advertiser</td>
                    @if($archive->Contract->advertiser_id !== $archive->advertiser_id)
                        <td class="text-primary">{{ $archive->Contract->Advertiser->advertiser_name }}</td>
                        <td class="text-primary">{{ $archive->Advertiser->advertiser_name }}</td>
                    @else
                        <td>{{ $archive->Contract->Advertiser->advertiser_name }}</td>
                        <td>{{ $archive->Advertiser->advertiser_name }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Product</td>
                    @if($archive->Contract->product !== $archive->product)
                        <td class="text-primary">{{ $archive->Contract->product }}</td>
                        <td class="text-primary">{{ $archive->product }}</td>
                    @else
                        <td>{{ $archive->Contract->product }}</td>
                        <td>{{ $archive->product }}</td>
                    @endif
                </tr>
                <tr>
                    <td>BO Type</td>
                    @if($archive->Contract->bo_type !== $archive->bo_type)
                        <td class="text-primary">{{ $archive->Contract->bo_type }}</td>
                        <td class="text-primary">{{ $archive->bo_type }}</td>
                    @else
                        <td>{{ $archive->Contract->bo_type }}</td>
                        <td>{{ $archive->bo_type }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Parent BO</td>
                    @if($archive->Contract->parent_bo !== $archive->parent_bo)
                        <td class="text-primary">{{ $archive->Contract->parent_bo }}</td>
                        <td class="text-primary">{{ $archive->parent_bo }}</td>
                    @else
                        <td>{{ $archive->Contract->parent_bo }}</td>
                        <td>{{ $archive->parent_bo }}</td>
                    @endif
                </tr>
                <tr>
                    <td>BO Number</td>
                    @if($archive->Contract->bo_number !== $archive->bo_number)
                        <td class="text-primary">{{ $archive->Contract->bo_number }}</td>
                        <td class="text-primary">{{ $archive->bo_number }}</td>
                    @else
                        <td>{{ $archive->Contract->bo_number }}</td>
                        <td>{{ $archive->bo_number }}</td>
                    @endif
                </tr>
                <tr>
                    <td>CE Number</td>
                    @if($archive->Contract->ce_number !== $archive->ce_number)
                        <td class="text-primary">{{ $archive->Contract->ce_number }}</td>
                        <td class="text-primary">{{ $archive->ce_number }}</td>
                    @else
                        <td>{{ $archive->Contract->ce_number }}</td>
                        <td>{{ $archive->ce_number }}</td>
                    @endif
                </tr>
                <tr>
                    <td>BO Date</td>
                    @if($archive->Contract->bo_date !== $archive->bo_date)
                        <td class="text-primary">{{ $archive->Contract->bo_date }}</td>
                        <td class="text-primary">{{ $archive->bo_date }}</td>
                    @else
                        <td>{{ $archive->Contract->bo_date }}</td>
                        <td>{{ $archive->bo_date }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Commencement</td>
                    @if($archive->Contract->commencement !== $archive->commencement)
                        <td class="text-primary">{{ $archive->Contract->commencement }}</td>
                        <td class="text-primary">{{ $archive->commencement }}</td>
                    @else
                        <td>{{ $archive->Contract->commencement }}</td>
                        <td>{{ $archive->commencement }}</td>
                    @endif
                </tr>
                <tr>
                    <td>End of Broadcast</td>
                    @if($archive->Contract->end_of_broadcast !== $archive->end_of_broadcast)
                        <td class="text-primary">{{ $archive->Contract->end_of_broadcast }}</td>
                        <td class="text-primary">{{ $archive->end_of_broadcast }}</td>
                    @else
                        <td>{{ $archive->Contract->end_of_broadcast }}</td>
                        <td>{{ $archive->end_of_broadcast }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Detail</td>
                    @if($archive->Contract->detail !== $archive->detail)
                        <td class="text-primary">{{ $archive->Contract->detail }}</td>
                        <td class="text-primary">{{ $archive->detail }}</td>
                    @else
                        <td>{{ $archive->Contract->detail }}</td>
                        <td>{{ $archive->detail }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Package Cost</td>
                    @if($archive->Contract->package_cost !== $archive->package_cost)
                        <td class="text-primary">{{ $archive->Contract->package_cost }}</td>
                        <td class="text-primary">{{ $archive->package_cost }}</td>
                    @else
                        <td>{{ $archive->Contract->package_cost }}</td>
                        <td>{{ $archive->package_cost }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Vat</td>
                    @if($archive->Contract->package_cost_vat !== $archive->package_cost_vat)
                        <td class="text-primary">{{ $archive->Contract->package_cost_vat }}</td>
                        <td class="text-primary">{{ $archive->package_cost_vat }}</td>
                    @else
                        <td>{{ $archive->Contract->package_cost_vat }}</td>
                        <td>{{ $archive->package_cost_vat }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Sales Discount</td>
                    @if($archive->Contract->package_cost_salesdc !== $archive->package_cost_salesdc)
                        <td class="text-primary">{{ $archive->Contract->package_cost_salesdc }}</td>
                        <td class="text-primary">{{ $archive->package_cost_salesdc }}</td>
                    @else
                        <td>{{ $archive->Contract->package_cost_salesdc }}</td>
                        <td>{{ $archive->package_cost_salesdc }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Manila</td>
                    @if($archive->Contract->manila_cash !== $archive->manila_cash)
                        <td class="text-primary">{{ $archive->Contract->manila_cash }}</td>
                        <td class="text-primary">{{ $archive->manila_cash }}</td>
                    @else
                        <td>{{ $archive->Contract->manila_cash }}</td>
                        <td>{{ $archive->manila_cash }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Cebu</td>
                    @if($archive->Contract->cebu_cash !== $archive->cebu_cash)
                        <td class="text-primary">{{ $archive->Contract->cebu_cash }}</td>
                        <td class="text-primary">{{ $archive->cebu_cash }}</td>
                    @else
                        <td>{{ $archive->Contract->cebu_cash }}</td>
                        <td>{{ $archive->cebu_cash }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Davao</td>
                    @if($archive->Contract->davao_cash !== $archive->davao_cash)
                        <td class="text-primary">{{ $archive->Contract->davao_cash }}</td>
                        <td class="text-primary">{{ $archive->davao_cash }}</td>
                    @else
                        <td>{{ $archive->Contract->davao_cash }}</td>
                        <td>{{ $archive->davao_cash }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Total</td>
                    @if($archive->Contract->total_cash !== $archive->total_cash)
                        <td class="text-primary">{{ $archive->Contract->total_cash }}</td>
                        <td class="text-primary">{{ $archive->total_cash }}</td>
                    @else
                        <td>{{ $archive->Contract->total_cash }}</td>
                        <td>{{ $archive->total_cash }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Manila Ex</td>
                    @if($archive->Contract->manila_ex !== $archive->manila_ex)
                        <td class="text-primary">{{ $archive->Contract->manila_ex }}</td>
                        <td class="text-primary">{{ $archive->manila_ex }}</td>
                    @else
                        <td>{{ $archive->Contract->manila_ex }}</td>
                        <td>{{ $archive->manila_ex }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Cebu Ex</td>
                    @if($archive->Contract->cebu_ex !== $archive->cebu_ex)
                        <td class="text-primary">{{ $archive->Contract->cebu_ex }}</td>
                        <td class="text-primary">{{ $archive->cebu_ex }}</td>
                    @else
                        <td>{{ $archive->Contract->cebu_ex }}</td>
                        <td>{{ $archive->cebu_ex }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Davao Ex</td>
                    @if($archive->Contract->davao_ex !== $archive->davao_ex)
                        <td class="text-primary">{{ $archive->Contract->davao_ex }}</td>
                        <td class="text-primary">{{ $archive->davao_ex }}</td>
                    @else
                        <td>{{ $archive->Contract->davao_ex }}</td>
                        <td>{{ $archive->davao_ex }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Total Ex</td>
                    @if($archive->Contract->total_ex !== $archive->total_ex)
                        <td class="text-primary">{{ $archive->Contract->total_ex }}</td>
                        <td class="text-primary">{{ $archive->total_ex }}</td>
                    @else
                        <td>{{ $archive->Contract->total_ex }}</td>
                        <td>{{ $archive->total_ex }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Total Amount</td>
                    @if($archive->Contract->total_amount !== $archive->total_amount)
                        <td class="text-primary">{{ $archive->Contract->total_amount }}</td>
                        <td class="text-primary">{{ $archive->total_amount }}</td>
                    @else
                        <td>{{ $archive->Contract->total_amount }}</td>
                        <td>{{ $archive->total_amount }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Production</td>
                    @if($archive->Contract->prod_cost !== $archive->prod_cost)
                        <td class="text-primary">{{ $archive->Contract->prod_cost }}</td>
                        <td class="text-primary">{{ $archive->prod_cost }}</td>
                    @else
                        <td>{{ $archive->Contract->prod_cost }}</td>
                        <td>{{ $archive->prod_cost }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Production Vat</td>
                    @if($archive->Contract->prod_cost_vat !== $archive->prod_cost_vat)
                        <td class="text-primary">{{ $archive->Contract->prod_cost_vat }}</td>
                        <td class="text-primary">{{ $archive->prod_cost_vat }}</td>
                    @else
                        <td>{{ $archive->Contract->prod_cost_vat }}</td>
                        <td>{{ $archive->prod_cost_vat }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Prod Sales Discount</td>
                    @if($archive->Contract->prod_cost_salesdc !== $archive->prod_cost_salesdc)
                        <td class="text-primary">{{ $archive->Contract->prod_cost_salesdc }}</td>
                        <td class="text-primary">{{ $archive->prod_cost_salesdc }}</td>
                    @else
                        <td>{{ $archive->Contract->prod_cost_salesdc }}</td>
                        <td>{{ $archive->prod_cost_salesdc }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Manila Prod</td>
                    @if($archive->Contract->manila_prod !== $archive->manila_prod)
                        <td class="text-primary">{{ $archive->Contract->manila_prod }}</td>
                        <td class="text-primary">{{ $archive->manila_prod }}</td>
                    @else
                        <td>{{ $archive->Contract->manila_prod }}</td>
                        <td>{{ $archive->manila_prod }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Cebu Prod</td>
                    @if($archive->Contract->cebu_prod !== $archive->cebu_prod)
                        <td class="text-primary">{{ $archive->Contract->cebu_prod }}</td>
                        <td class="text-primary">{{ $archive->cebu_prod }}</td>
                    @else
                        <td>{{ $archive->Contract->cebu_prod }}</td>
                        <td>{{ $archive->cebu_prod }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Davao Prod</td>
                    @if($archive->Contract->davao_prod !== $archive->davao_prod)
                        <td class="text-primary">{{ $archive->Contract->davao_prod }}</td>
                        <td class="text-primary">{{ $archive->davao_prod }}</td>
                    @else
                        <td>{{ $archive->Contract->davao_prod }}</td>
                        <td>{{ $archive->davao_prod }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Total Prod</td>
                    @if($archive->Contract->total_prod !== $archive->total_prod)
                        <td class="text-primary">{{ $archive->Contract->total_prod }}</td>
                        <td class="text-primary">{{ $archive->total_prod }}</td>
                    @else
                        <td>{{ $archive->Contract->total_prod }}</td>
                        <td>{{ $archive->total_prod }}</td>
                    @endif
                </tr>
                <tr>
                    <td>Account Executive</td>
                    @if($archive->Contract->ae !== $archive->ae)
                        <td class="text-primary">{{ $archive->Contract->Employee->first_name }} {{ $archive->Contract->Employee->last_name }}</td>
                        <td class="text-primary">{{ $archive->Employee->first_name }} {{ $archive->Employee->last_name }}</td>
                    @else
                        <td>{{ $archive->Contract->Employee->first_name }} {{ $archive->Contract->Employee->last_name }}</td>
                        <td>{{ $archive->Employee->first_name }} {{ $archive->Employee->last_name }}</td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
    <div class="text-center h4 mb-0">
        Table display is not available for this device's resolution.
    </div>
</div>
