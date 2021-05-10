<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesRevision extends Model
{
    protected $table = 'sales_revisions';

    protected $fillable = [
        'sales_id',
        'contract_id',
        'month',
        'year',
        'type',
        'amount_type',
        'amount',
        'gross_amount',
        'invoice_no',
        'date_created',
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
