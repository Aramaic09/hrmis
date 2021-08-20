<?php

namespace App\Http\Controllers\AttendanceMonitoring;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Carbon\Carbon;


class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function dt() 
    // {
    //     if($this->isWeekend("2021-02-11"))
    //     {
    //         return "YES";
    //     }
    //     else
    //     {
    //         return "NO"; 
    //     }
    // }

    // public function isWeekend($dt)
    // {
    //     $dt1 = strtotime($dt);
    //     $dt2 = date("l", $dt1);
    //     $dt3 = strtolower($dt2);
    //     if(($dt3 == "saturday" )|| ($dt3 == "sunday"))
    //         {
    //             return true;
    //         } 
    //     else
    //         {
    //             return false;
    //         }  
    // }

    public function index($type)
    {

        $err_msg = "";
    	switch ($type) {
    		case 'leave':
                $duration = explode(",", request()->Dates);

                if(count($duration) > 0)
                {
                    $deduc = 1;
                }
                else
                {
                    switch (request()->leave_time) {
                        case 'wholeday':
                                $deduc = 1;
                            break;
                        case 'AM':
                                $deduc = 0.5;
                            break;
                        case 'PM':
                                $deduc = 0.5;
                            break;

                    }
                }

                foreach ($duration as $values) {
                    $request = new App\Request_leave;
                    $request->user_id = Auth::user()->id;
                    $request->empcode = Auth::user()->username;
                    $request->user_div = Auth::user()->division;
                    $request->leave_date = $values;
                    $request->leave_id = request()->leave_id[++$loop];
                    $request->leave_action_status = 'Pending';
                    $request->leave_deduction = $deduc;
                    $request->leave_deduction_time = request()->leave_time[++$loop];
                    $request->save();
                }
                
    		break;
    	}
        
     return redirect('/');   
    }

public function pdf()
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<!DOCTYPE html>
                            <html>
                            <head>
                              <title>HRMIS - DTR</title>
                              <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                            </head>
                            <style type="text/css">
@page {
  size: 21cm 29.7cm;
  margin: 20;
}
                                body
                                {
                                    font-family: DejaVu Sans;
                                }
                                th,td
                                {
                                    border:1px solid #555;
                                    font-size:11px;
                                }
                            </style>
                            <body>

                            <table width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                  <td style="border : 1px solid #FFF;width:20%" align="right">
                                    <img src="'.url('img/DOST.png').'" style="width:100px">
                                  </td>
                                  <td style="border : 1px solid #FFF;font-size:12px;" align="center">
                                        Republic of the Philippines<br/>
                                        PHILIPPINE COUNCIL FOR AGRICULTURE, AQUATIC AND NATURAL RESOURCES
                                        RESEARCH AND DEVELOPMENT<br/>
                                        Los Baños, Laguna
                                  </td>
                                  <td style="border : 1px solid #FFF;font-size:12px;width:20%" >

                                  </td>
                                </tr>
                            </table>
                                    <center><h4><b>APPLICATION FOR LEAVE</b></h4></center>

                            <table width="100%" cellspacing="0" cellpadding="2" border="1">
                                <tr>
                                  <td style="width:33%">
                                    1. OFFICE/DEPARTMENT
                                  </td>
                                  <td style="border-right : 1px solid #FFF">
                                    2. NAME
                                  </td>
                                  <td align="center" style="border-left : 1px solid #FFF;border-right : 1px solid #FFF">
                                    <small>(Last)</small>
                                  </td>
                                  <td align="center" style="border-left : 1px solid #FFF;border-right : 1px solid #FFF">
                                    <small>(First)</small>
                                  </td>
                                  <td align="center" style="border-left : 1px solid #FFF">
                                    <small>(Middle)</small>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    3. DATE OF FILLING
                                  </td>
                                  <td colspan="2">
                                    4. POSITION
                                  </td>
                                  <td colspan="2">
                                    5. SALARY
                                  </td>
                                </tr>
                                <tr>
                                  <td align="center" colspan="5">
                                    6.  DETAILS OF APPLICATION
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="3" style="vertical-align: top;">
                                    6.A  TYPE OF LEAVE TO BE AVAILED OF
                                    <br/>
                                    &emsp; &#9744 <small>Vacation Leave <small>(Sec 15, Rule XVII, Omnibus Rules Implimenting E.O No. 292)</small></small><br>
                                    &emsp; &#9744 <small>Mandatory/Force Leave <small>(Sec 25, Rule XVII, Omnibus Rules Implimenting E.O No. 292)</small></small><br>
                                    &emsp; &#9744 <small>Sick Leave <small>(Sec 43, Rule XVII, Omnibus Rules Implimenting E.O No. 292)</small></small><br>
                                    &emsp; &#9744 <small>Maternity Leave<small>(R.A No. 11210/ IRR issued by CSC DOLE and SSS)</small></small><br>
                                    &emsp; &#9744 <small>Paternity Leave<small>(R.A No. 8187/ CSC MC No 71, s. 1998 as amended)</small></small><br>
                                    &emsp; &#9744 <small>Special Priviledge Leave<small>(Sec 21, Rule XVII, Omnibus Rules Implimenting E.O No. 292)</small></small><br>
                                    &emsp; &#9744 <small>Solo Parent Leave<small>(RA No. 8972/CSC MC NO. 8, s. 2004)</small></small><br>
                                    &emsp; &#9744 <small>Study Leave<small>(Sec 68, Rule XVII, Omnibus Rules Implimenting E.O No. 292)</small></small><br>
                                    &emsp; &#9744 <small>10-Day VAWC<small>(RA No. 9262/CSC MC NO. 15, s. 2005)</small></small><br>
                                    &emsp; &#9744 <small>Rehabilitation Priviledge<small>(Sec 55, Rule XVII, Omnibus Rules Implimenting E.O No. 292)</small></small><br>
                                    &emsp; &#9744 <small>Special Leave Benefits for Women<small>(RA No. 9710/CSC MC NO. 25, s. 2010)</small></small><br>
                                    &emsp; &#9744 <small>Special Emergency(Calamity) Leave<small>(CSC MC NO. 2, s. 2012, as amended)</small></small><br>
                                    &emsp; &#9744 <small>Adoption Leave<small>(RA No. 8552)</small></small><br>
                                    <br>
                                    <br>
                                    &emsp;<i>Others</i>
                                    <br>
                                    <br>
                                    <br>
                                  </td>
                                  <td align="left" colspan="2" style="vertical-align: top;">
                                    6.B  DETAILS OF LEAVE
                                    <br/>
                                    <i>In case of Vacation/Special Priviledge Leave:</i>
                                    &emsp; &#9744 <small>Within the Phillipines:</small><br>
                                    &emsp; &#9744 <small>Abroad (Specify): </small><br>
                                    <br/>
                                    <i>In case of Sick Leave:</i>
                                    <br/>
                                    &emsp; &#9744 <small>In Hospital (Specify Illness):</small><br>
                                    &emsp; &#9744 <small>Out-Patient (Specify Illness): </small><br>
                                    <br>
                                    <i>In case of Study Leave:</i><br>
                                    &emsp; &#9744 <small>Complition of Master`s Degree:</small><br>
                                    &emsp; &#9744 <small>BAR/Board Exam Review: </small><br>
                                    <br>
                                    <i>Other purpose:</i><br>
                                    &emsp; &#9744 <small>Monetization of Leave Credits:</small><br>
                                    &emsp; &#9744 <small>Terminal Leave: </small><br>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="3" style="vertical-align: top;">
                                  6.C NUMBER OF WORKING DAYS APPLIED FOR

                                  <br>
                                  <br>
                                  &emsp; INCLUSIVE DATES
                                  </td>

                                  <td align="left" colspan="2" style="vertical-align: top;">
                                  6.D COMMUTATION<br>
                                    &emsp; &#9744 <small>Not Requested</small><br>
                                    &emsp; &#9744 <small>Requested</small><br>

                                    <center>
                                    <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br/></u>
                                    (Signature of Applicant)
                                    </center>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="3" style="vertical-align: top;border-bottom:1px solid #FFF">
                                  7.A CERtiFICATION OF LEAVE CREDITS
                                  <br/>
                                  <center>As of : </center>

                                  <table width="100%" border="1" cellspacing="0">
                                  <tr>
                                    <td></td>
                                    <td align="center">Vacation Leave</td>
                                    <td align="center">Sick Leave</td>
                                  </tr>
                                  <tr>
                                    <td>Total Earned</td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>Less this Application</td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>Balance</td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  </table>
                                  </td>

                                  <td align="left" colspan="2" style="vertical-align: top;border-bottom:1px solid #FFF">
                                  7.B RECOMMENDATION<br>
                                    &emsp; &#9744 <small>For Approval:</small><br>
                                    &emsp; &#9744 <small>For Disapproval due to:</small><br>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="3" style="vertical-align: top;border-top:1px solid #FFF">
                                    <center>
                                    <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br/></u>
                                    (Authorized Officer)
                                    </center>
                                  </td>

                                  <td align="left" colspan="2" style="vertical-align: top;border-top:1px solid #FFF">
                                    <center>
                                    <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br/></u>
                                    (Authorized Officer)
                                    </center>
                                    </center>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" colspan="3" style="vertical-align: top;border-right:1px solid #FFF;border-bottom:1px solid #FFF">
                                  7.C APPROVED FOR<br>
                                  &emsp; <u>&emsp;&emsp;</u> days with pay<br/>
                                  &emsp; <u>&emsp;&emsp;</u> days without pay<br/>
                                  &emsp; <u>&emsp;&emsp;</u> others (specify)<br/>
                                  </td>

                                  <td align="left" colspan="2" style="vertical-align: top;border-left:1px solid #FFF;border-bottom:1px solid #FFF">
                                  7.D DISAPPOVED DUE TO<br>
                                  </td>
                                </tr>
                                <tr>
                                <td align="left" colspan="5" style="vertical-align: top;border-top:1px solid #FFF">
                                    <center>
                                    <u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<br/></u>
                                    (Authorized Officer)
                                    </center>
                                    </center>
                                  </td>
                                </tr>

                            </table>
                            </body>
                            </html>')
        ->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
