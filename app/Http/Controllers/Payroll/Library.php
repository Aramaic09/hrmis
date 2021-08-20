<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Library extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = 
                [
                    "nav" => nav("payrolllib"),
                ];
        return view('payroll.library')->with("data",$data);
    }
}
