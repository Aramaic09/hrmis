<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Report extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = 
                [
                    "nav" => nav("payrollreport"),
                ];
        return view('payroll.reports')->with("data",$data);
    }
}
