<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyAdvertiserLogs extends Model
{
    protected $table = 'agency_advertiser_logs';

    protected $fillable = [
        'advertiser_id',
        'agency_id',
        'action',
        'employee_id'
    ];

    public function Employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function Advertiser() {
        return $this->belongsTo(Advertiser::class, 'advertiser_id');
    }

    public function Agency() {
        return $this->belongsTo(Agency::class, 'agency_id');
    }
}
