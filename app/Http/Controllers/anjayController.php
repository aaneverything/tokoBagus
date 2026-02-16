<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class anjayController extends Controller
{
    function index()
    {
        return "bajingan cok";
    }

    function cobaaja(){
        $namanya = "konting we";
        return view('cobaaja', ['nama'=>$namanya]);
    }
}
