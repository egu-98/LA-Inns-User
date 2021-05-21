<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function admin_home(){
        return view( 'home' );
    }
}
