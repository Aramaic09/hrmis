<?php

namespace App\Http\Controllers\AttendanceMonitoring;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App;
use Carbon\Carbon;
use Auth;

class FinalProcess extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        //GET ALL STAFF
        $staff = collect(App\View_user::whereIn('id',request()->check_request)->where('usertype','!=','Administrator')->orderBy('lname')->orderBy('fname')->get());

        $data = collect([]);

        
        foreach ($staff->all() as $staffs)
        {

            if(!checkIfProcess($staffs->id,request()->mon,request()->yr))
            {
                
            $deficit = 0.000;

            $totaldeduction = 0.000;
            $totalvldeduction = 0.000;

            $vl_ctr = 0;

            $remarks = "";

            $remarks .= "<b>".$staffs->lname.", ".$staffs->fname."</b><br/>---Current Leave Balances---<br/>";


            $collecleave = collect([]);

            //LEAVE
            $orig_vl = 0.000;
            $orig_sl = 0.000;
            $orig_pl = 0.000;
            $orig_spl = 0.000;
            $orig_cto = 0.000;
            $orig_fl = 0.000;
            $orig_MatL = 0.000;
            $orig_PatL = 0.000;
            $orig_StL = 0.000;
            $orig_ReL = 0.000;
            $orig_el = 0.000;
            $orig_spec = 0.000;
            $orig_ml = 0.000;
            $orig_ua = 0.000;
            $orig_slwop = 0.000;

            //GET STAFF CURRENT LEAVE BALANCES
            foreach(showLeaves() AS $leaves){

                // switch ($leaves->id) {
                //     case 1:
                //                 $lv = getLVSummary(1,$staffs->id,request()->mon,request()->yr);
                //         break;
                //     case 2:
                //                 $lv = getLVSummary(2,$staffs->id,request()->mon,request()->yr);
                //         break;
                    
                //     default:
                //                 $lv = getLeaves($staffs->id,$leaves->id);
                //         break;
                // }
                
                $lv = getLeaves($staffs->id,$leaves->id);  
                $remarks .= $leaves->leave_desc." : <b>$lv</b><br>";

                //GET PREVIOUS LEAVE
                switch ($leaves->id)
                {
                        case 1:
                            # code...
                                $orig_vl += $lv;
                            break;
                        case 2:
                            # code...
                                $orig_sl += $lv;
                            break;
                        case 3:
                            # code...
                                $orig_pl += $lv;
                            break;
                        case 4:
                            # code...
                                $orig_spl += $lv;
                            break;
                        case 5:
                            # code...
                                $orig_cto += $lv;
                            break;
                        case 6:
                            # code...
                                $orig_fl += $lv;
                            break;
                        case 7:
                            # code...
                                $orig_MatL += $lv;
                            break;
                        case 8:
                            # code...
                                $orig_PatL += $lv;
                            break;
                        case 9:
                            # code...
                                $orig_StL += $lv;
                            break;
                        case 10:
                            # code...
                                $orig_ReL += $lv;
                            break;
                        case 11:
                            # code...
                                $orig_el += $lv;
                            break;
                        case 12:
                            # code...
                                $orig_spec += $lv;
                            break;
                        case 13:
                            # code...
                                $orig_el += $lv;
                            break;
                        case 14:
                            # code...
                                $orig_ua += $lv;
                            break;
                        case 15:
                            # code...
                                $orig_slwop += $lv;
                            break;
                    }

                $collecleave->put($leaves->leave_desc, $lv);
            }
            
            $remarks .= "<br/><br/>";

            
            if($staffs->dtr_exe != 1)
            {
                if($staffs->employement_id != 12)
                {
                    //GET L.W.P
                    $lwp = getLWP($staffs->id,request()->mon,request()->yr);

                    $lwp = explode("|", $lwp);

                    $no_lates = 

                    //COUNT LWP
                    $nolwp = countLWP($staffs->id,request()->mon,request()->yr);
                    // $earnleave = getLWPCount((string)$nolwp);
                    $earnleave = 1.25;

                    // return $lwp[0];


                    $remarks .= "Required Total Hours: <b>".$lwp[10]."</b><br>";
                    $remarks .= "Total Hours Rendered: <b>".$lwp[11]."</b><br>";
                    $deficit_hours = $lwp[10] - $lwp[11];
                    $remarks .= "Deficit hours: <b>".$deficit_hours."</b><br><br>";

                    //ABSENT
                    $remarks .= "---Absent---<br/>Total : <b>".$lwp[0]."</b><br/><br/>";

                    $remarks .= "---Leave Without Pay---<br/>";

                    // if($lwp[0] >= 0)
                    // {
                    //     //EARNED VL/SL
                    //     $lwps = getLWPCount($lwp[0]);

                    //     $remarks .= "LWP total : <b>".$nolwp."</b><br>";
                    // }
                    $remarks .= "LWP total : <b>".$nolwp."</b><br>";

                    $remarks .= "<br/>";

                    $remarks .= "VL/SL earn : <b>".$earnleave."</b><br><br>";

                    $remarks .= "---Deduction---<br/>";
                    
                    //GET LATES/UNDERTIME
                    $remarks .= $lwp[2]."<br/>Lates/Undertime Deduction : <b>".number_format((float)$lwp[1], 3, '.', '')."</b><br><br>";

                    $totaldeduction += number_format((float)$lwp[1], 3, '.', '');

                    $no_process_lates = $lwp[3]."h ".$lwp[4]."m";
                    $no_process_under = $lwp[8]."h ".$lwp[9]."m";
                    $no_process_lates_under = $lwp[5]."h ".$lwp[6]."m";
                    $no_lates_total = $lwp[7];
                    $no_process_absent = $lwp[0];
                }
                else
                {
                    $totaldeduction = 0.000;
                    $earnleave = 1.25;
                    $remarks .= "VL/SL earn : <b>".$earnleave."</b><br><br>";

                    $nolwp = 0;

                    $no_process_lates = "0h 0m";
                    $no_process_under = "0h 0m";
                    $no_process_lates_under = "0h 0m";
                    $no_lates_total = "0h 0m";
                    $no_process_absent = 0;
                }
            }
            else
            {
                $totaldeduction = 0.000;
                $earnleave = 1.25;
                $remarks .= "VL/SL earn : <b>".$earnleave."</b><br><br>";

                $nolwp = 0;

                $no_process_lates = "0h 0m";
                $no_process_under = "0h 0m";
                $no_process_lates_under = "0h 0m";
                $no_lates_total = "0h 0m";
                $no_process_absent = 0;

            }
            

            //GET REQUEST
            $remarks .= "---Request---<br/>";
            $leave_req = collect(App\Request_leave::whereNotNull('parent')->where('user_id',$staffs->id)->where('leave_action_status','Approved')->whereMonth('leave_date_from',request()->mon)->whereYear('leave_date_from',request()->yr)->get());
            if($leave_req)
            {
                $leave_req = $leave_req->all();
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

                //UPDATE TO PROCESSED

                foreach ($leave_req as $leaves) 
                {
                    $remarks .= getLeaveInfo($leaves->leave_id)." - Date : ".$leaves->leave_date_from." to ".$leaves->leave_date_to." - Deduction : ".$leaves->leave_deduction."<br>";

                    switch ($leaves->leave_id) 
                    {
                        case 1:
                        # code...
                                $vl += $leaves->leave_deduction;
                                $totalvldeduction = $totaldeduction + $leaves->leave_deduction;

                                $fl += $leaves->leave_deduction;

                                $vl_ctr += $leaves->leave_deduction;

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
                                $vl += $leaves->leave_deduction;

                                $vl_ctr += $leaves->leave_deduction;

                                $totalvldeduction = $totaldeduction + $leaves->leave_deduction;
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

                    App\Request_leave::where('id',$leaves->id)
                                    ->update([
                                                'leave_action_status' => 'Processed'
                                            ]);            
                }

                // $remarks .= " LEAVE : ".$totaldeduction."<br>";


            }
            
            // $remarks .= "<br/>Total VL Deduction : ".$vl_ctr + $totaldeduction."<br/>";

            $remarks .= "<br/>---Ending Leave Balances---<br/>";

            foreach ($collecleave as $keybal => $valuebal) {
                
                switch ($keybal) {
                    case 'Vacation Leave':
                        # code...
                            $val = (($valuebal + $earnleave) - $totalvldeduction);

                            $deficit = 0;
                            if($totalvldeduction > ($valuebal + $earnleave))
                            {
                                $deficit = ($vl + $totalvldeduction) - ($valuebal + $earnleave);
                            }


                            $vl_bal = $val;

                            //UPDATE LEAVE
                            if($val > -1)
                            {
                                $data->push(['leave_id' => 1,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_vl,'leave_bal' => $val,'leave_bal_nega' => $deficit,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }

                        break;
                    case 'Sick Leave':
                        # code...
                            $val = $valuebal - $sl;
                            $val = (($valuebal + $earnleave) - $sl);

                            $sl_bal = $val;

                            $deficit = 0;
                            if($val < 0)
                            {
                                $deficit = ($sl + $totaldeduction) - ($valuebal + $earnleave);
                            }

                            //UPDATE LEAVE
                            if($val > -1)
                            {
                                $data->push(['leave_id' => 2,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_sl,'leave_bal' => $val,'leave_bal_nega' => $deficit,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }

                        break;
                    case 'Privilege Leave':
                        # code...
                            $val = $valuebal - $pl;

                            if($orig_pl > 0)
                            {
                                $data->push(['leave_id' => 3,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_pl,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Solo Parent Leave':
                        # code...
                            $val = $valuebal - $spl;

                            if($orig_spl > 0)
                            {
                                $data->push(['leave_id' => 4,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_spl,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }

                        break;
                    case 'Compensatory Time-Off':
                        # code...
                            $val = $valuebal - $cto;

                            if($orig_cto > 1)
                            {
                                $data->push(['leave_id' => 5,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_cto,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Force Leave':
                        # code...
                            $val = $valuebal - $fl;

                            $deficit = 0;
                            //UPDATE LEAVE
                            if($val > 0)
                            {
                                $data->push(['leave_id' => 6,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_fl,'leave_bal' => $val,'leave_bal_nega' => $deficit,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                            elseif($val <= 0)
                            {
                                $data->push(['leave_id' => 6,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_fl,'leave_bal' => 0,'leave_bal_nega' => $deficit,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }

                        break;
                    case 'Maternity Leave':
                        # code...
                            $val = $valuebal - $MatL;

                            if($orig_MatL > 0)
                            {
                                $data->push(['leave_id' => 7,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_MatL,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Paternity Leave':
                        # code...
                            $val = $valuebal - $PatL;

                            if($orig_PatL > 0)
                            {
                                $data->push(['leave_id' => 8,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_PatL,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Study Leave':
                        # code...
                            $val = $valuebal - $StL;

                            if($orig_StL > 0)
                            {
                                $data->push(['leave_id' => 9,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_StL,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Rehabilitation Leave':
                        # code...
                            $val = $valuebal - $ReL;

                            if($orig_ReL > 0)
                            {
                                $data->push(['leave_id' => 10,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_ReL,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Emergency Leave':
                        # code...
                            $val = $valuebal - $el;

                            if($orig_el > 0)
                            {
                                $data->push(['leave_id' => 11,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_el,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Monetize Leave':
                        # code...
                            $val = $valuebal - $ml;

                            if($orig_ml > 0)
                            {
                                $data->push(['leave_id' => 13,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_ml,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Special Leave (Magna Carta of Women)':
                        # code...
                            $val = $valuebal - $spec;

                            if($orig_spec > 0)
                            {
                                $data->push(['leave_id' => 12,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_spec,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }

                        break;
                    case 'Unauthorized Absence':
                        # code...
                            $val = $valuebal - $ua;

                            if($orig_ua > 0)
                            {
                                $data->push(['leave_id' => 14,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_ua,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                    case 'Sick Leave Without Pay':
                        # code...
                            $val = $valuebal - $slwop;

                            if($orig_slwop > 0)
                            {
                                $data->push(['leave_id' => 15,'user_id' => $staffs->id,'empcode' => $staffs->username,'leave_bal_prev' => $orig_slwop,'leave_bal' => $val,'leave_bal_nega' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                            }
                        break;
                }

                $remarks .= $keybal." : <b>".$val."</b><br/>";
            }
            // $remarks .= "<br/>---Deficit---<br/>$deficit";

            SAVE TO DTR SUMMARY
            $processed = new App\DTRProcessed;
            $processed->userid = $staffs->id;
            $processed->employee_name = $staffs->lname . ", " .$staffs->fname . " " . $staffs->mname;
            $processed->dtr_mon = request()->mon;
            $processed->dtr_year = request()->yr;
            $processed->dtr_division = $staffs->division;
            $processed->vl_leave =  $vl_ctr;
            $processed->vl_lwop = $nolwp;
            $processed->vl_late = $no_process_lates;
            $processed->vl_totalunderlate = $no_process_under;
            $processed->vl_totalunderlatededuc = $totaldeduction;
            $processed->vl_bal = $vl_bal;
            $processed->vl_undertime = $no_process_lates_under;
            $processed->sl_leave = $sl;
            $processed->nolates = $no_lates_total; 
            $processed->noabsent = $no_process_absent;
            $processed->sl_bal = $sl_bal;
            $processed->save();

            //UPDATE LEAVE
            $lv = App\Employee_leave::insert($data->all());


            return redirect('dtr/emp/'.request()->mon.'/'.request()->yr);
            // echo $remarks."<hr/>";
            }
        }
    }

    function checkIfProcess($userid,$mon,$yr)
    {
        $dtr = App\DTRProcessed::where('userid',$userid)->where('dtr_mon',$mon)->where('dtr_year',$yr)->count();

        if($dtr > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
