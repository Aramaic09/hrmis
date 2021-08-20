<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Carbon\Carbon;
use Auth;

class PDFController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myPayslip()
    {
    	$date = request()->payslip_mon .' '.request()->payslip_year;

    	if(Auth::user()->employment_id == 1)
    	{
    		$emp = App\View_user::where('id',Auth::user()->id)->first();
    	}
    	else
    	{
    		$emp = App\View_users_temp::where('id',Auth::user()->id)->first();
    	}


    	$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML('<!DOCTYPE html>
							<html>
							<head>
							  <title>HRMIS - MY PAYSLIP</title>
							  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
							</head>
							<style type="text/css">
								body
								{
									font-family:Helvetica;
								}
								th,td
								{
									border:0px solid #555;
									font-size:11px;
								}

								.payslip
								{
									font-size : 10px;
									border:1px solid #999;
									padding:5px;
									width: 100%;
								}
							</style>
							<body>
								<div class="payslip">
									<spanborder="0" style="font-size:9px">Date Printed : '.Carbon::now().'</span>
									<center><h3><b>PCAARRD PAYSLIP FOR THE MONTH OF : '.strtoupper(date('F Y',strtotime($date))).'</b></h3></center
								
								<table width="75%" style="position:relative;left:15%">
									<tr><td>'.$emp['username'].'</td><td>'.$emp['lname'].', '.$emp['fname'].' '.$emp['mname'].' '.$emp['exname'].'</td><td>'.$emp['division_acro'].'</td><td>'.$emp['position_desc'].'</td></tr>
								</table>

								<table width="100%">
									<tr>
										<td style="width:33%"><b>GROSS PAY</b></td>
										<td style="width:33%"><b>DEDUCTIONS</b></td>
										<td></td>
									</tr>
									<tbody>
										<tr>
											<td>
												SALARY - <br>
												PERA -
											</td>
											<td>
												BIR - <br/>
												SIC - <br/>
												MED - <br/>
												HDMF - <br/>
											</td>
											<td></td>
										</tr>
										<tr>
											<td><b>TOTAL</b> - </td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><b>NET SALARY</b> - </td>
											<td><b>PER WEEK - </b></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td>Certified by : <u>&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160	&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160&#160</u></td>
										</tr>
									</tbody>
								</table>

								</div>
							</body>
							</html>')
		->setPaper('a4', 'portrait');
		return $pdf->stream();
    }
}
