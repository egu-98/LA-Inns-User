<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function inn(){
        return $this->belongsTo(Inn::class);
    }
}
