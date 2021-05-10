<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'contract_id',
        'bo_number',
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
        'date_created'
    ];

    public function Contract() {
        return $this->belongsTo(Contract::class);
    }

    public function Agency() {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

    public function Advertiser() {
        return $this->belongsTo(Advertiser::class, 'advertiser_id');
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, 'ae');
    }

    public function Archive() {
        return $this->hasMany(SalesRevision::class);
    }

    public function Logs() {
        return $this->hasMany(AccountExecutiveLogs::class);
    }
}
