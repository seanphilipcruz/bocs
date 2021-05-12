<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountExecutiveLogs
 * @mixin Builder
 * @package App
 */

class AccountExecutiveLogs extends Model
{
    protected $table = 'account_executive_logs';

    protected $fillable = [
        'action',
        'contract_id',
        'bo_number',
        'employee_id'
    ];

    public function Contract() {
        return $this->belongsTo(Contract::class, 'ae');
    }

    public function Employee() {
        return $this->belongsTo(Employee::class);
    }
}
