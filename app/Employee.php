<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Employee
 * @mixin Builder
 * @package App
 */

class Employee extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'date_of_birth',
        'nickname',
        'username',
        'password',
        'job_id',
        'is_active',
        'date_created'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function Job() {
        return $this->belongsTo(Job::class);
    }

    public function AccountExecutiveLogs() {
        return $this->hasMany(AccountExecutiveLogs::class, 'employee_id');
    }

    public function Logs() {
        return $this->hasMany(EmployeeLogs::class, 'employee_id');
    }

    public function Contract() {
        return $this->hasMany(Contract::class, 'ae');
    }
}
