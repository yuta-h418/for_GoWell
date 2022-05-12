<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseFormController extends Controller
{
    public function formView(){
        return view('register.form');
    }
}
