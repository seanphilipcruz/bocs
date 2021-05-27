<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountExecutiveLogs
 * @mixin Builder
 * @package App
 */

class SalesLogs extends Model
{
    protected $table = 'sales_logs';

    protected $fillable = [
        'sales_id',
        'action',
        'bo_number',
        'type',
        'amount',
        'gross_amount',
        'employee_id'
    ];

    public function Sales() {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
