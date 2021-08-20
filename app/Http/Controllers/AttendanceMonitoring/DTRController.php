<?php

namespace App\Http\Controllers\AttendanceMonitoring;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App;
use Carbon\Carbon;
use Auth;

class DTRController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function icos($mon,$year)
    {
        // if(Auth::user()->usertype == 'Administrator')
        // {
        //     $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE MONTH(fldEmpDTRdate) = $mon AND YEAR(fldEmpDTRdate) = $year GROUP BY fldEmpCode,MONTH(fldEmpDTRdate),YEAR(fldEmpDTRdate)");
        // }
        // else
        // {
        //     $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE division = '".Auth::user()->division."' AND MONTH(fldEmpDTRdate) = $mon AND YEAR(fldEmpDTRdate) = $year GROUP BY division,fldEmpCode,MONTH(fldEmpDTRdate),YEAR(fldEmpDTRdate)");
        // }
        
        $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE division = '".Auth::user()->division."' AND MONTH(fldEmpDTRdate) = $mon AND YEAR(fldEmpDTRdate) = $year GROUP BY division,fldEmpCode,MONTH(fldEmpDTRdate),YEAR(fldEmpDTRdate)");
        
        $data = [
                    "list" => $list,
                    "nav" => nav("icos"),
                    "mon" => $mon,
                    "year" => $year,
                ];
        return view('dtr.icos')->with("data",$data);
    }
    
    public function icosmonth()
    {
        $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE division = '".Auth::user()->division."' GROUP BY division,MONTH(fldEmpDTRdate),YEAR(fldEmpDTRdate)");
        // $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE processed IS NULL GROUP BY fldEmpCode,MONTH(fldEmpDTRdate)");
        $data = [
                    "list" => $list,
                    "nav" => nav("icos"),
                ];
        return view('dtr.icos-months')->with("data",$data);
    }

    public function terminal()
    {
        return view('dtr.terminal');
    }
    
    public function password()
    {
        $data = [
                    "nav" => nav("icos"),
                ];
        return view('dtr.change-password')->with("data",$data);
    }

    public function edit()
    {

        if(request()->action == 'view')
        {
           $emp = App\User::where('id',request()->userid2)->first();
           $fullname = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
           $mon = request()->mon2;
           $yr = request()->yr2;
        }
        elseif(request()->action == 'new')
        {
            $emp = App\User::where('id',request()->userid)->first();

            //CHECK IF MAY TIME NA
            $dtr_check = App\Employee_dtr::whereDate('fldEmpDTRdate',request()->wfh_date)->where('user_id',$emp['id'])->first();


            if($dtr_check)
            {
                 switch (request()->dtrStatusTime) {
                    case 'AM':
                        $dtr_edit = App\Employee_dtr::where('id',$dtr_check['id'])
                                         ->update([
                                                    "fldEmpDTRamIn" => "8:00:00",
                                                    "fldEmpDTRamOut" => "12:00:00",
                                                    "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                                 ]);
                    break;

                    case 'PM':
                        $dtr_edit = App\Employee_dtr::where('id',$dtr_check['id'])
                                         ->update([
                                                    "fldEmpDTRpmIn" => "13:00:00",
                                                    "fldEmpDTRpmOut" => "17:00:00",
                                                    "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                                 ]);
                    break;

                    default:
                        $dtr_edit = App\Employee_dtr::where('id',$dtr_check['id'])
                                         ->update([
                                                    "fldEmpDTRamIn" => "8:00:00",
                                                    "fldEmpDTRamOut" => "12:00:00",
                                                    "fldEmpDTRpmIn" => "13:00:00",
                                                    "fldEmpDTRpmOut" => "17:00:00",
                                                    "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                                 ]);
                    break;
                }
            }
            else
            {
                $wfh = 0;
                if(request()->dtrStatus == 'WFH')
                {
                    $wfh = 1;
                }

                switch (request()->dtrStatusTime) {
                    case 'AM':
                            //ADD
                            $dtr = new App\Employee_dtr;
                            $dtr->user_id = $emp['id'];
                            $dtr->fldEmpCode = $emp['username'];
                            $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                            $dtr->division = $emp['division'];
                            $dtr->fldEmpDTRdate = request()->wfh_date;
                            $dtr->fldEmpDTRamIn = "8:00:00";
                            $dtr->fldEmpDTRamOut = "12:00:00";
                            $dtr->wfh = $wfh;
                            $dtr->dtr_remarks = request()->dtrStatus . " - ". request()->wfh_reason;
                            $dtr->save();
                        break;

                    case 'PM':
                            //ADD
                            $dtr = new App\Employee_dtr;
                            $dtr->user_id = $emp['id'];
                            $dtr->fldEmpCode = $emp['username'];
                            $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                            $dtr->division = $emp['division'];
                            $dtr->fldEmpDTRdate = request()->wfh_date;
                            $dtr->fldEmpDTRpmIn = "13:00:00";
                            $dtr->fldEmpDTRpmOut = "17:00:00";
                            $dtr->wfh = $wfh;
                            $dtr->dtr_remarks = request()->dtrStatus . " - ". request()->wfh_reason;
                            $dtr->save();
                        break;
                    
                    default:
                            //ADD
                            $dtr = new App\Employee_dtr;
                            $dtr->user_id = $emp['id'];
                            $dtr->fldEmpCode = $emp['username'];
                            $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                            $dtr->division = $emp['division'];
                            $dtr->fldEmpDTRdate = request()->wfh_date;
                            $dtr->fldEmpDTRamIn = "8:00:00";
                            $dtr->fldEmpDTRamOut = "12:00:00";
                            $dtr->fldEmpDTRpmIn = "13:00:00";
                            $dtr->fldEmpDTRpmOut = "17:00:00";
                            $dtr->wfh = $wfh;
                            $dtr->dtr_remarks = request()->wfh_reason;
                            $dtr->save();
                        break;
                }
                
            }

            $fullname = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
            $mon = request()->wfh_mon;
            $yr = request()->wfh_yr;
        }
        elseif(request()->action == 'edit')
        {
            $dtr = App\Employee_dtr::where('id',request()->dtr_id)
                                     ->update([
                                                request()->dtr_col => request()->dtr_val
                                             ]);

            $emp = App\User::where('id',request()->userid2)->first();
            $fullname = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
            $mon = request()->edit_mon;
            $yr = request()->edit_yr;

            //ADD HISTORY
            $this->addHistory();
        }

        $data = [
                    "emp" => $emp,
                    "fullname" => $fullname,
                    "yr" => $yr,
                    "mon" => $mon,
                ];
        return view('dtr.dtr-emp-edit')->with('data',$data);
    }

    public function edit2($userid,$mon,$yr)
    {
        $emp = App\User::where('id',$userid)->first();

        $data = [
                    "emp" => $emp,
                    "fullname" => $emp['lname'].', '.$emp['fname'].' '.$emp['mname'],
                    "yr" => $yr,
                    "mon" => $mon,
                ];
        return view('dtr.dtr-edit')->with('data',$data);
    }

    public function monitor()
    {
        $user = App\User::where('id',request()->userid2)->first();

        // return request()->yr2;

        if(checkifIcos(request()->userid2))
        {
            $dtr = App\Employee_icos_dtr::whereYear('fldEmpDTRdate',request()->yr2)->whereMonth('fldEmpDTRdate',request()->mon2)->where('user_id',request()->userid2)->get();
        }
        else
        {
            $dtr = App\Employee_dtr::whereYear('fldEmpDTRdate',request()->yr2)->whereMonth('fldEmpDTRdate',request()->mon2)->where('user_id',request()->userid2)->get();
        }

        // return $dtr;

        $data = [
                    'date' => date('F',mktime(0, 0, 0, request()->mon2, 10)).' '.request()->yr2,
                    'user' => $user['lname'] . ', ' . $user['fname'],
                    'dtr' => $dtr,
                ];
        return view('dtr.dtr-monitoring')->with('data',$data);
    }

    public function pdf()
    {
        // return request()->mon2;

        $emp = App\User::where('id',request()->userid)->first();

        $rows = "";
        
        $mon = date('m',strtotime(request()->mon2));
        $mon2 = date('F',mktime(0, 0, 0, request()->mon2, 10));
        $yr = request()->yr2;
        $date = $mon2 ."-" . request()->yr2;
        $month = ++$mon;

        $tUndertime = null;

        $tLates = null;

        $totalAb = null;

        $total = Carbon::parse($date)->daysInMonth;
                      $prevweek = 1;
                      $rows .= "<tr><td colspan='10' align='center'>  <b>WEEK 1 </b> </td></tr>";
                      $week_num = 2;
                      for($i = 1;$i <= $total;$i++)
                      {

                        
                          $weeknum = weekOfMonth(date($yr.'-'.request()->mon2.'-'.$i)) + 1;
                            if($weeknum == $prevweek)
                            {
                              
                            }
                            else
                            {
                              $prevweek = $weeknum;
                              $rows .= "<tr><td colspan='10' align='center'> <b>WEEK $week_num </b> </td></tr>";
                              $week_num++;
                            }


                            $dtr_date = date("Y-m-d",strtotime($yr.'-'.request()->mon2.'-'.$i));

                            $dayDesc = weekDesc($dtr_date);

                            $dtr = getDTRemp($dtr_date,$emp['id'],$emp['employment_id']);

                            
                                //UDERTIME
                                $under = null;
                                if(countUndertime($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut']))
                                {
                                    $undertime = explode("|", countUndertime($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut']));
                                    $under = $undertime[0];
                                    $tUndertime += $undertime[1];
                                }

                                //LATES
                                $lates = null;
                                if(computeLate($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn']))
                                {
                                    $late = explode("|",computeLate($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn']));
                                    $lates = $late[0];
                                    $tLates += $late[1];
                                }

                                switch ($dayDesc) {
                                    case 'Sat':
                                    case 'Sun':
                                        # code...
                                        break;
                                    
                                    default:
                                            if($dtr['fldEmpDTRamIn'] == null && $dtr['fldEmpDTRamOut'] == null && $dtr['fldEmpDTRpmIn'] == null && $dtr['fldEmpDTRpmOut'] == null)
                                            {
                                                $totalAb++;
                                            }
                                        break;
                                }


                                //CHECK WORK SCHUDULE
                                $ws = $dtr['dtr_option_id'];
                                    switch ($ws) {
                                        case 5:
                                        case 6:
                                        case 7:
                                               if(isset($dtr))
                                               {
                                                    if($dtr['wfh'] != 1)
                                                    {
                                                        if($dtr_date <= date('Y-m-d'))
                                                            if($dtr['id'] > 0)
                                                                if($dayDesc != 'Sat' && $dayDesc != 'Sun')
                                                                    $rows .=  "<tr><td style='width:10%'><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center' colspan = '9'>SKELETON WF</tr>";
                                                                else
                                                                    $rows .=  "<tr><td style='width:10%'><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center'></td><td align='center'></td></tr>"; 

                                                            else
                                                                $rows .=  "<tr><td style='width:10%'><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center'></td><td align='center'></td></tr>"; 
                                                        else
                                                        {
                                                           $rows .=  "<tr><td style='width:10%'><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center' style='width:8%'></td><td align='center'></td><td align='center'></td></tr>"; 
                                                        }
                                                    }
                                                    else
                                                    {
                                                        
                                                        $rows .=  "<tr><td style='width:10%'><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRamIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRamOut'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRpmIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRpmOut'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRotIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRotOut'])."</td><td align='center' style='width:8%'>".countTotalTime($dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_ot'],$dtr['fldEmpDTRotIn'],$dtr['fldEmpDTRotOut'],$dtr_date,$dayDesc)."</td><td align='center' style='width:8%'>".$lates." ".$under."</td><td align='center'>".$dtr['dtr_remarks']."</td></tr>";
                                                        
                                                    }
                                               }
                                            break;
                                        default:

                                             $rows .=  "<tr><td style='width:10%'><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRamIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRamOut'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRpmIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRpmOut'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRotIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRotOut'])."</td><td align='center' style='width:8%'>".countTotalTime($dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_ot'],$dtr['fldEmpDTRotIn'],$dtr['fldEmpDTRotOut'],$dtr_date,$dayDesc)."</td><td align='center' style='width:8%'>".$lates." ".$under."</td><td align='center'>".$dtr['dtr_remarks']."</td></tr>";
                                            
                                        break;

                                    }
                            
                      }
        //DISPLAY LATES
        $hourslate = floor($tLates / 60);
        $minuteslate = $tLates % 60;

        //DISPLAY UNDERTIME
        $hoursunder = floor($tUndertime / 60);
        $minutesunder = $tUndertime % 60;

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
                                    font-family:Helvetica;
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
                                    </h4>
                                </center>
                                <center><h3><b>DTR '.$mon2.'  '.$yr.'</b></h3></center>
                                <table width="100%" cellspacing="0" cellpadding="2">
                                    <tr>
                                        <th><b>Day</b></th><th><center><b>AM In</b></center></th><th><center><b>AM Out</b></center></th><th><center><b>PM In</b></center></th><th><center><b>PM Out</b></center></th><th><center><b>OT In</b></center></th><th><center><b>OT Out</b></center></th><th><center><b>Total Hours</b></center></th><th><center><b>Lates<br/>Undertime</b></center><th><center><b>Remarks</b></center></th>
                                    </tr>
                                    <tbody>
                                        '.$rows.'
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <br>
                                <table width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                  <td style="border : 1px solid #FFF;font-size:12px">
                                        <b>Total Lates : </b> '.$hourslate.'h '.$minuteslate.'m<br>
                                        <b>Total Undertime : </b>'.$hoursunder.'h '.$minutesunder.'m<br>
                                        <b>Total Absences : </b>'.$totalAb.'<br><br><br>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="border : 1px solid #FFF;font-size:15px" align="center">'.$emp['fname'].' '.$emp['mname'].' '.ucwords(strtolower($emp['lname'])).'<br><small><b>Name of Employee</b></small></td>
                                  <td style="border : 1px solid #FFF;font-size:15px" align="center">'.getDirector($emp['division']).'<br><small><b>Division Director</b></small></td>
                                <tr>
                                </table>
                            </body>
                            </html>')
        ->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    private function getDirector($div)
    {
        $division = App\Division::where('division_id',$div)->first();
        return $division['director'];
    }

    public function icosupdate()
    {
        $dtr = App\Employee_icos_dtr::where('id',request()->dtr_id)
                                     ->update([
                                                request()->dtr_col => request()->dtr_val 
       
                                             ]);

        $emp = App\User::where('id',request()->userid)->first();

        $data = [
                    "emp" => $emp,
                    "fullname" => $emp['lname'].', '.$emp['fname'].' '.$emp['mname'],
                    "yr" => request()->yr,
                    "mon" => request()->mon,
                ];

        //ADD HISTORY
        $this->addHistory();


        return redirect('dtr/edit/'.request()->userid.'/'.request()->mon.'/'.request()->yr);
    }

    public function icoswfh()
    {

        $emp = App\User::where('id',request()->user_id_wfh)->first();


        //CHECK IF MAY TIME NA
        $dtr_check = App\Employee_icos_dtr::whereDate('fldEmpDTRdate',request()->wfh_date)->where('user_id',$emp['id'])->first();

        if($dtr_check)
        {
             switch (request()->dtrStatusTime) {
                case 'AM':
                    $dtr_edit = App\Employee_icos_dtr::where('id',$dtr_check['id'])
                                     ->update([
                                                "fldEmpDTRamIn" => "8:00:00",
                                                "fldEmpDTRamOut" => "12:00:00",
                                                "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                             ]);
                break;

                case 'PM':
                    $dtr_edit = App\Employee_icos_dtr::where('id',$dtr_check['id'])
                                     ->update([
                                                "fldEmpDTRpmIn" => "13:00:00",
                                                "fldEmpDTRpmOut" => "17:00:00",
                                                "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                             ]);
                break;

                default:
                    $dtr_edit = App\Employee_icos_dtr::where('id',$dtr_check['id'])
                                     ->update([
                                                "fldEmpDTRamIn" => "8:00:00",
                                                "fldEmpDTRamOut" => "12:00:00",
                                                "fldEmpDTRpmIn" => "13:00:00",
                                                "fldEmpDTRpmOut" => "17:00:00",
                                                "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                             ]);
                break;
            }
        }
        else
        {

            switch (request()->dtrStatusTime) {
                case 'AM':
                        //ADD
                        $dtr = new App\Employee_icos_dtr;
                        $dtr->user_id = $emp['id'];
                        $dtr->fldEmpCode = $emp['username'];
                        $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                        $dtr->division = $emp['division'];
                        $dtr->fldEmpDTRdate = request()->wfh_date;
                        $dtr->fldEmpDTRamIn = "8:00:00";
                        $dtr->fldEmpDTRamOut = "12:00:00";
                        $dtr->dtr_remarks = request()->dtrStatus . " - ". request()->wfh_reason;
                        $dtr->save();
                    break;

                case 'PM':
                        //ADD
                        $dtr = new App\Employee_icos_dtr;
                        $dtr->user_id = $emp['id'];
                        $dtr->fldEmpCode = $emp['username'];
                        $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                        $dtr->division = $emp['division'];
                        $dtr->fldEmpDTRdate = request()->wfh_date;
                        $dtr->fldEmpDTRpmIn = "13:00:00";
                        $dtr->fldEmpDTRpmOut = "17:00:00";
                        $dtr->dtr_remarks = request()->dtrStatus . " - ". request()->wfh_reason;;
                        $dtr->save();
                    break;
                
                default:
                        //ADD
                        $dtr = new App\Employee_icos_dtr;
                        $dtr->user_id = $emp['id'];
                        $dtr->fldEmpCode = $emp['username'];
                        $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                        $dtr->division = $emp['division'];
                        $dtr->fldEmpDTRdate = request()->wfh_date;
                        $dtr->fldEmpDTRamIn = "8:00:00";
                        $dtr->fldEmpDTRamOut = "12:00:00";
                        $dtr->fldEmpDTRpmIn = "13:00:00";
                        $dtr->fldEmpDTRpmOut = "17:00:00";
                        $dtr->dtr_remarks = request()->dtrStatus;
                        $dtr->save();
                    break;
            }
            
        }

        

        $data = [
                    "emp" => $emp,
                    "fullname" => $emp['lname'].', '.$emp['fname'].' '.$emp['mname'],
                    "yr" => request()->yr,
                    "mon" => request()->mon,
                ];

        //ADD HISTORY

        return redirect('dtr/edit/'.request()->user_id_wfh.'/'.request()->wfh_mon.'/'.request()->wfh_yr);
    }

    public function editdtr()
    {

        $emp = App\User::where('id',request()->user_id_wfh)->first();


        //CHECK IF MAY TIME NA
        $dtr_check = App\Employee_dtrs::whereDate('fldEmpDTRdate',request()->wfh_date)->where('user_id',$emp['id'])->first();

        if($dtr_check)
        {
             switch (request()->dtrStatusTime) {
                case 'AM':
                    $dtr_edit = App\Employee_dtrs::where('id',$dtr_check['id'])
                                     ->update([
                                                "fldEmpDTRamIn" => "8:00:00",
                                                "fldEmpDTRamOut" => "12:00:00",
                                                "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                             ]);
                break;

                case 'PM':
                    $dtr_edit = App\Employee_dtrs::where('id',$dtr_check['id'])
                                     ->update([
                                                "fldEmpDTRpmIn" => "13:00:00",
                                                "fldEmpDTRpmOut" => "17:00:00",
                                                "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                             ]);
                break;

                default:
                    $dtr_edit = App\Employee_dtrs::where('id',$dtr_check['id'])
                                     ->update([
                                                "fldEmpDTRamIn" => "8:00:00",
                                                "fldEmpDTRamOut" => "12:00:00",
                                                "fldEmpDTRpmIn" => "13:00:00",
                                                "fldEmpDTRpmOut" => "17:00:00",
                                                "dtr_remarks" => request()->dtrStatus . " - ". request()->wfh_reason
                                             ]);
                break;
            }
        }
        else
        {
            $dtroption = showActiveWS();
            switch (request()->dtrStatusTime) {
                case 'AM':
                        //ADD
                        $dtr = new App\Employee_dtrs;
                        $dtr->user_id = $emp['id'];
                        $dtr->fldEmpCode = $emp['username'];
                        $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                        $dtr->division = $emp['division'];
                        $dtr->fldEmpDTRdate = request()->wfh_date;
                        $dtr->fldEmpDTRamIn = "8:00:00";
                        $dtr->fldEmpDTRamOut = "12:00:00";
                        $dtr->dtr_option_id = $dtroption;
                        $dtr->dtr_remarks = request()->dtrStatus . " - ". request()->wfh_reason;
                        $dtr->save();
                    break;

                case 'PM':
                        //ADD
                        $dtr = new App\Employee_dtrs;
                        $dtr->user_id = $emp['id'];
                        $dtr->fldEmpCode = $emp['username'];
                        $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                        $dtr->division = $emp['division'];
                        $dtr->fldEmpDTRdate = request()->wfh_date;
                        $dtr->fldEmpDTRpmIn = "13:00:00";
                        $dtr->fldEmpDTRpmOut = "17:00:00";
                        $dtr->dtr_option_id = $dtroption;
                        $dtr->dtr_remarks = request()->dtrStatus . " - ". request()->wfh_reason;;
                        $dtr->save();
                    break;
                
                default:
                        //ADD
                        $dtr = new App\Employee_dtrs;
                        $dtr->user_id = $emp['id'];
                        $dtr->fldEmpCode = $emp['username'];
                        $dtr->employee_name = $emp['lname'].', '.$emp['fname'].' '.$emp['mname'];
                        $dtr->division = $emp['division'];
                        $dtr->fldEmpDTRdate = request()->wfh_date;
                        $dtr->fldEmpDTRamIn = "8:00:00";
                        $dtr->fldEmpDTRamOut = "12:00:00";
                        $dtr->fldEmpDTRpmIn = "13:00:00";
                        $dtr->fldEmpDTRpmOut = "17:00:00";
                        $dtr->dtr_option_id = $dtroption;
                        $dtr->dtr_remarks = request()->dtrStatus;
                        $dtr->save();
                    break;
            }
            
        }

        

        $data = [
                    "emp" => $emp,
                    "fullname" => $emp['lname'].', '.$emp['fname'].' '.$emp['mname'],
                    "yr" => request()->yr,
                    "mon" => request()->mon,
                ];

        //ADD HISTORY

        return redirect('dtr/emp/'.request()->wfh_mon.'/'.request()->wfh_yr);
    }

    private function addHistory()
    {
        $history = new App\DTRHistory;
        $history->user_id = request()->userid;
        $history->dtr_id = request()->dtr_id;
        $history->dtr_tbl = request()->dtr_tbl;
        $history->dtr_col = request()->dtr_col;
        $history->time_orig = request()->dtr_orig;
        $history->time_new = request()->dtr_val;
        $history->acted_by = Auth::user()->lname . ', '. Auth::user()->fname;
        $history->save();
    }

    public function icosindex()
    {
        $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE division = '".Auth::user()->division."' GROUP BY division,MONTH(fldEmpDTRdate)");
        // $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE processed IS NULL GROUP BY fldEmpCode,MONTH(fldEmpDTRdate)");
        $data = [
                    "list" => $list,
                    "nav" => nav("icos"),
                ];
        return view('dtr.icos-months')->with("data",$data);
    }



    public function checkDayForPrinting($day)
    {
        if(date('d') >= 1 && date('d') <= 15)
        {
            if($day >= 1 && $day <= 15)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if($day >= 16 && $day <= 31)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }


    //EMPLOYEE DTR
    public function empdtr()
    {
        $list = DB::select("SELECT * FROM employee_dtrs WHERE YEAR(fldEmpDTRdate) = ".date('Y')." AND division = '".Auth::user()->division."' GROUP BY division,MONTH(fldEmpDTRdate),YEAR(fldEmpDTRdate)");
        // $list = DB::select("SELECT * FROM employee_icos_dtrs WHERE processed IS NULL GROUP BY fldEmpCode,MONTH(fldEmpDTRdate)");
        $data = [
                    "list" => $list,
                    "nav" => nav("empdtr"),
                ];
        return view('dtr.emp-months')->with("data",$data);
    }

    public function emp($mon,$year)
    {
        if(Auth::user()->usertype == 'Administrator')
        {
            $list = DB::select("SELECT * FROM employee_dtrs WHERE MONTH(fldEmpDTRdate) = $mon AND YEAR(fldEmpDTRdate) = $year GROUP BY fldEmpCode,MONTH(fldEmpDTRdate),YEAR(fldEmpDTRdate)");
        }
        else
        {
            // $list = DB::select("SELECT * FROM employee_dtrs WHERE division = '".Auth::user()->division."' AND MONTH(fldEmpDTRdate) = $mon AND YEAR(fldEmpDTRdate) = $year GROUP BY division,fldEmpCode,MONTH(fldEmpDTRdate),YEAR(fldEmpDTRdate)");
            $list = collect(App\User::where('division',Auth::user()->division)->where('employment_id',1)->orderBy('lname')->orderBy('fname')->get());
            $list = $list->all();
        }
        
        $data = [
                    "list" => $list,
                    "nav" => nav("empdtr"),
                    "mon" => $mon,
                    "year" => $year,
                ];

        return view('dtr.emp')->with("data",$data);
    }

    public function processDTR()
    {
        $data = [
                    "nav" => nav("empdtr"),
                    "mon" => request()->mon,
                    "year" => request()->year,
                ];
        return view('dtr.dtr-process-message')->with("data",$data);
    }

    public function finalprocessDTR2()
    {
        foreach (request()->check_request as $key => $value) {
            # code...
            echo $value."<br>";
        }

    }

    public function finalprocessDTR()
    {
        
        //GET ALL STAFF
        $staff = collect(App\View_user::select('id','lname','fname','username')->whereIn('id',request()->check_request)->where('usertype','!=','Administrator')->orderBy('lname')->orderBy('fname')->get());

        foreach ($staff->all() as $staffs) {
            $deficit = 0.000;

            $totaldecuction = 0.000;

            $vl = 0.000;
            $sl = 0.000;
            $pl = 0.000;
            $spl = 0.000;
            $cto = 0.000;
            $fl = 0.000;
            $MatL = 0.000;
            $PatL = 0.000;
            $StL = 0.000;
            $ReL = 0.000;
            $el = 0.000;
            $spec = 0.000;
            $ml = 0.000;
            $ua = 0.000;
            $slwop = 0.000;

            $remarks = "";

            $remarks .= "<b>".$staffs->lname.", ".$staffs->fname."</b><br/>---Current Leave Balances---<br/>";


            $collecleave = collect([]);

            //GET STAFF CURRENT LEAVE BALANCES
            foreach(showLeaves() AS $leaves){
                $lv = getLeaves($staffs->id,$leaves->id);

                $remarks .= $leaves->leave_desc." : <b>$lv</b><br>";

                $collecleave->put($leaves->leave_desc, $lv);
            }
            
            $remarks .= "<br/><br/>";


            //GET L.W.P
            $lwp = getLWP($staffs->id,request()->mon,request()->yr);

            $lwp = explode("|", $lwp);

            // return $lwp[0];

            $remarks .= "---Leave Without Pay---<br/>";

            if($lwp[0] >= 0)
            {
                //EARNED VL/SL
                $lwps = getLWPCount($lwp[0]);

                $remarks .= "LWP total : <b>".$lwp[0]."</b><br>";
            }

            $remarks .= "<br/>";

            $remarks .= "VL/SL earn : <b>".$lwps."</b><br><br>";


            $remarks .= "---Deduction---<br/>";
            //GET LATES/UNDERTIME
            $remarks .= $lwp[2]."<br/>Lates/Undertime Deduction : <b>".number_format((float)$lwp[1], 3, '.', '')."</b><br><br>";

            $totaldecuction += number_format((float)$lwp[1], 3, '.', '');


            //GET REQUEST
            $remarks .= "---Request---<br/>";
            $leave_req = collect(App\Request_leave::where('user_id',$staffs->id)->where('leave_action_status','Approved')->whereMonth('leave_date',request()->mon)->whereYear('leave_date',request()->yr)->whereNull('leave_processed')->get());
            if($leave_req)
            {
                $leave_req = $leave_req->all();

                foreach ($leave_req as $leaves) {
                    $remarks .= getLeaveInfo($leaves->leave_id)." - Date : ".$leaves->leave_date." - Deduction : ".$leaves->leave_deduction."<br>";
                    switch ($leaves->leave_id) {
                        case 1:
                        # code...
                                $vl += $leaves->leave_deduction;
                                $totaldecuction = $totaldecuction + $leaves->leave_deduction;
                            break;
                        case 2:
                            # code...
                                $sl += $leaves->leave_deduction;
                            break;
                        case 3:
                            # code...
                                $pl += $leaves->leave_deduction;
                            break;
                        case 4:
                            # code...
                                $spl += $leaves->leave_deduction;
                            break;
                        case 5:
                            # code...
                                $cto += $leaves->leave_deduction;
                            break;
                        case 6:
                            # code...
                                $fl += $leaves->leave_deduction;
                            break;
                        case 7:
                            # code...
                                $MatL += $leaves->leave_deduction;
                            break;
                        case 8:
                            # code...
                                $PatL += $leaves->leave_deduction;
                            break;
                        case 9:
                            # code...
                                $StL += $leaves->leave_deduction;
                            break;
                        case 10:
                            # code...
                                $ReL += $leaves->leave_deduction;
                            break;
                        case 11:
                            # code...
                                $el += $leaves->leave_deduction;
                            break;
                        case 12:
                            # code...
                                $spec += $leaves->leave_deduction;
                            break;
                        case 13:
                            # code...
                                $el += $leaves->leave_deduction;
                            break;
                        case 14:
                            # code...
                                $ua += $leaves->leave_deduction;
                            break;
                        case 15:
                            # code...
                                $slwop += $leaves->leave_deduction;
                            break;
                    }
                }
            }
            

            $remarks .= "<br/>---Updated Leave Balances---<br/>";

            foreach ($collecleave as $keybal => $valuebal) {
                
                switch ($keybal) {
                    case 'Vacation Leave':
                        # code...
                            $val = (($valuebal + $lwps) - ($vl + $totaldecuction));

                            if(($vl + $totaldecuction) > ($valuebal + $lwps))
                            {
                                $deficit = ($vl + $totaldecuction) - ($valuebal + $lwps);
                            }
                        break;
                    case 'Sick Leave':
                        # code...
                            $val = $valuebal - $sl;
                            $val = (($valuebal + $lwps) - $sl);
                        break;
                    case 'Privilege Leave':
                        # code...
                            $val = $valuebal - $pl;
                        break;
                    case 'Solo Parent Leave':
                        # code...
                            $val = $valuebal - $spl;
                        break;
                    case 'Compensatory Time-Off':
                        # code...
                            $val = $valuebal - $cto;
                        break;
                    case 'Force Leave':
                        # code...
                            $val = $valuebal - $fl;
                        break;
                    case 'Maternity Leave':
                        # code...
                            $val = $valuebal - $MatL;
                        break;
                    case 'Paternity Leave':
                        # code...
                            $val = $valuebal - $PatL;
                        break;
                    case 'Study Leave':
                        # code...
                            $val = $valuebal - $StL;
                        break;
                    case 'Rehabilitation Leave':
                        # code...
                            $val = $valuebal - $ReL;
                        break;
                    case 'Emergency Leave':
                        # code...
                            $val = $valuebal - $el;
                        break;
                    case 'Monetize Leave':
                        # code...
                            $val = $valuebal - $ml;
                        break;
                    case 'Special Leave (Magna Carta of Women)':
                        # code...
                            $val = $valuebal - $spec;
                        break;
                    case 'Unauthorized Absence':
                        # code...
                            $val = $valuebal - $ua;
                        break;
                    case 'Sick Leave Without Pay':
                        # code...
                            $val = $valuebal - $slwop;
                        break;
                }

                $remarks .= $keybal." : <b>".$val."</b><br/>";
            }
            $remarks .= "<br/>---Deficit---<br/>$deficit";

            //NO MORE VL
            // if($vl <= 0)
            // {

            // }
            // else
            // {

            // }

            echo $remarks."<hr/>";
        }

        // foreach (request()->check_request as $key => $value) {
        //     # code...
        //     echo $value."<br/>";
        // }
    }

}


