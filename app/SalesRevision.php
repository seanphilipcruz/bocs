<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesRevision extends Model
{
    protected $table = 'sales_revisions';

    protected $fillable = [
        'sales_id',
        'contract_id',
        'bo_number',
        'bo_type',
        'station',
        'month',
        'year',
        'type',
        'amount_type',
        'amount',
        'gross_amount',
        'agency_id',
        'advertiser_id',
        'ae',
        'invoice_no',
        'version'
    ];

    public function Sales() {
        return $this->belongsTo(Sales::class);
    }

    public function Contract() {
        return $this->belongsTo(Contract::class);
    }

    public function Logs() {
        return $this->hasMany(AccountExecutiveLogs::class);
    }
}
