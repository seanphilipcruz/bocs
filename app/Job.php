<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'job_description',
        'level',
        'is_active'
    ];

    public function Employee() {
        return $this->hasMany(Employee::class);
    }

    public function Logs() {
        return $this->hasMany(EmployeeLogs::class);
    }
}
