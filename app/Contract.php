<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'contract_number',
        'station',
        'agency_id',
        'advertiser_id',
        'product',
        'bo_type',
        'parent_bo',
        'bo_number',
        'ce_number',
        'bo_date',
        'commencement',
        'end_of_broadcast',
        'detail',
        'package_cost',
        'package_cost_vat',
        'package_cost_salesdc',
        'manila_cash',
        'cebu_cash',
        'davao_cash',
        'total_cash',
        'manila_ex',
        'cebu_ex',
        'davao_ex',
        'total_ex',
        'total_amount',
        'prod_cost',
        'prod_cost_vat',
        'prod_cost_salesdc',
        'manila_prod',
        'cebu_prod',
        'davao_prod',
        'total_prod',
        'ae',
        'is_printed',
        'is_active'
    ];

    public function Sales() {
        return $this->hasMany(Sales::class);
    }

    public function Archive() {
        return $this->hasMany(ContractRevision::class);
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, 'ae');
    }

    public function Agency() {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

    public function Advertiser() {
        return $this->belongsTo(Advertiser::class, 'advertiser_id');
    }

    public function Logs() {
        return $this->hasMany(AccountExecutiveLogs::class);
    }
}
