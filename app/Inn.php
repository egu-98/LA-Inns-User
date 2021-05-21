<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inn extends Model
{
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function books(){
        return $this->hasMany(Book::class);
    }

    public function waiters(){
        return $this->hasMany(Waiter::class);
    }

    public function plans(){
        return $this->hasMany(Plan::class);
    }
}
