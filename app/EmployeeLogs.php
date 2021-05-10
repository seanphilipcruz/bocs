<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLogs extends Model
{
    protected $fillable = [
        'action',
        'employee_id',
        'user_id',
        'job_id'
    ];

    public function User() {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function Job() {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
