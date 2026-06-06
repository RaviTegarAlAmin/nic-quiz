<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function teaching(){
        return $this->belongsTo(Teaching::class);
    }
}
