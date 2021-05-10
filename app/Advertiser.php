<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    protected $primaryKey = 'advertiser_code';

    protected $fillable = [
        'advertiser_name',
        'is_active',
    ];

    public function Contract() {
        return $this->hasMany(Contract::class);
    }
}
