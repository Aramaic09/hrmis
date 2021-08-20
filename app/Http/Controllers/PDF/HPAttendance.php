<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App;
use Carbon\Carbon;
use Auth;

class HPAttendance extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mon = date('F',mktime(0, 0, 0, request()->mon1, 10));

        //GET ALL STAFF

        $tr = "";
        foreach (getStaffDivision2(request()->division) as $value) {

            //LEAVES
            $leaveWholeDates = "";
            $leaveWhole = getLeave($value->id,1,request()->mon1,request()->year);
            $leaveWholeCtr = 0;
            foreach ($leaveWhole as $key => $values) {
                $leaveWholeCtr += $values->leave_deduction;
                $leaveWholeDates .= date('d',strtotime($values->leave_date_from)).",";
            }

            $leaveHalfDates = "";
            $leaveHalf = getLeave($value->id,0.5,request()->mon1,request()->year);
            $leaveHalfCtr = 0;
            foreach ($leaveHalf as $key => $values) {
                $leaveHalfCtr += $values->leave_deduction;
                $leaveHalfDates .= date('d',strtotime($values->leave_date_from)).",";
            }

            
            $total = $leaveWholeCtr + $leaveHalfCtr;
            $total = formatNull($total);

            $tr .= "<tr>
                        <td>".$value->lname.", ".$value->fname." ".$value->mname."</td>
                        <td>".$value->username."</td>
                        <td align='center'>".$leaveHalfDates."</td>
                        <td align='center'>".$leaveWholeDates."</td>
                        <td align='center'>".$total."</td>
                    </tr>";
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<!DOCTYPE html>
                            <html>
                            <head>
                              <title>HRMIS - Report</title>
                              <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                            </head>
                            <style type="text/css">
                               @page { margin: 20px; }
                                body
                                {
                                    font-family:Helvetica;
                                    margin: 0px; 
                                }
                                th,td
                                {
                                    border:1px solid #555;
                                    font-size:11px;
                                }
                            </style>
                            <body>
                                <center>
                                    <h4 style="font-size:12px">
                                        Republic of the Philippines<br/>
                                        PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES<br/>
                                        RESEARCH AND DEVELOPMENT<br/>
                                        Los Baños, Laguna
                                        <br>
                                        <br>
                                        <b>ATTENDANCE MONITORING SHEET (Subsitence Allowance)</b>
                                        <br>
                                        '.$mon.' '.request()->year.'
                                    </h4>
                                </center>
                                <table width="100%" cellspacing="0" cellpadding="5">
                                <tr>
                                  <td align="center" rowspan="2"><b>EMPLOYEE NAME</b></td>
                                  <td align="center" rowspan="2" style="width:10%"><b>EMPLOYEE CODE</b></td>
                                  <td align="center" colspan="2" style="width:50%"><b>NO. OF LEAVE</b></td>
                                  <td align="center" rowspan="2" style="width:10%"><b>TOTAL NO OF DAYS</b></td>
                                </tr>
                                <tr>
                                  <td align="center"><b>HALF DAY</b></td>
                                  <td align="center"><b>WHOLE</b></td>
                                </tr>
                                <tr>
                                    <td colspan="5"><b>Division : '.getDivision(request()->division).'</b></td>
                                </tr>
                                '.$tr.'
                                </table>
                                <br>
                                <br>
                                <br>

                                <table width="100%" cellspacing="0" cellpadding="5" style="font-size:15px!important">
                                <tr>
                                  <td style="width:50%;border: 1px solid #FFF">
                                    Prepared by : <br/>
                                    <b>'.getMarshal(request()->division).'</b>
                                  </td>
                                  <td style="border: 1px solid #FFF">
                                    Verified Correct : <br/>
                                    <b>'.getDirector(request()->division).'</b>
                                  </td>
                                </tr>
                                </table>
                            </body>
                            </html>')
        ->setPaper('legal', 'landscape');
        return $pdf->stream();
    }

    
}
