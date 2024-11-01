<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(){
        return view('backend.index');
    }
    public function vendor(){
        return view('backend.layouts.master');
    }
    public function customer(){
        return view('backend.layouts.master');
    }
}
