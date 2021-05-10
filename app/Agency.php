<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $primaryKey = 'agency_code';

    protected $fillable = [
        'agency_name',
        'contact_number',
        'address',
        'kbp_accredited',
        'is_active'
    ];

    public function Contract() {
        return $this->hasMany(Contract::class);
    }
}
