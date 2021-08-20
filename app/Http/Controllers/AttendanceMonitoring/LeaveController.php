<?php

namespace App\Http\Controllers\AttendanceMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function apply()
    {
        $leave = new App\Employee_leave_apply;
        $leave->user_id = Auth::user()->id;
        $leave->save();
    }

    public function getPending($id)
    {
        $leave = App\Request_leave::where('user_id',Auth::user()->id)->where('leave_id',$id)->update(['deleted_by' => Auth::user()->fname." ".Auth::user()->lname ]);


        $leave = App\Request_leave::where('user_id',Auth::user()->id)->where('leave_id',$id)->get();
        return json_encode($leave);
    }

    public function cancelLeave($id)
    {
        try {
              App\Request_leave::where('user_id',Auth::user()->id)->where('id',$id)->delete();

              return redirect('/');
            } catch (\Exception $e)
            {
               return redirect('/');
            }
    }

    public function request() 
    {
        return view('dtr.request-leave');
    }


    public function send() 
    {

        $no_nega = true;

        if(request()->leave_id == 1 || request()->leave_id == 2)
        {
            $no_nega = false;
        }


        $duration = explode('-',request()->leave_duration);

        if(request()->leave_id == 2)
        {
            $duration = explode('-',request()->leave_duration2);
        }
        elseif(request()->leave_id == 5 || request()->leave_id == 16)
        {
            $duration = explode('-',request()->leave_duration3);
        }

        $from = Carbon::parse($duration[0]);
        $from_orig = Carbon::parse($duration[0]);
        $to = Carbon::parse($duration[1]);

        $diff = 1+($from->diffInDays($to));

        //CHECK HAS LEAVE BALANCE, WAG LANG VL AT SL
        $bal = getLeaves(Auth::user()->id,request()->leave_id);

        $rem_bal = $bal - $diff;
        if($rem_bal > 0 || $no_nega == false)
        {
            //FOR MULTIPLE DATES, MAHIRAP KASI I-CHECK INDIVIDUAL DATES TO CHECK IF EXISTING YUNG LEAVE DATE
            $code = ramdomCode(15);

            //GET UPDATED LEAVE
            $leaves = getLeaves(Auth::user()->id,request()->leave_id);
            $leaves_loop = $leaves;

            //CHECK IF SINGLE DATE
            if($diff == 1)
            {
                $lwop = countDiffLeave($leaves,request()->leave_time);

                $this->addLeave(date('Y-m-d',strtotime($from)),date('Y-m-d',strtotime($to)),request()->leave_time,null,$code,$code,'NO',$lwop);
            }
            else
            {
                //COUNT NUMBER OF DAYS
                
                $totaldays = 0;
                for($i = 1; $i <= $diff; $i++)
                {

                    if($i == 1)
                        {
                            $dt = date('Y-m-d',strtotime($from));
                        }
                        else
                        {
                            $dt_main = $from->addDays(1);
                            $dt = $dt_main;
                        }

                        if(!$this->checkIfWeekend($dt))
                            {
                                if(!checkIfHoliday($dt))
                                {
                                    if(!checkIfHasLeave($dt))
                                    {
                                        $lwp = 'NO';
                                        if($leaves_loop <= 0)
                                            {
                                               $lwp = 'YES';
                                            }
                                        
                                        $this->addLeave(date('Y-m-d',strtotime($dt)),null,'multiple',1,null,$code,null,$lwp,$leaves_loop);
                                        
                                        $totaldays++;
                                        $leaves_loop--;
                                    }
                                }

                            }
                    
                }
                // $lwop = countDiffLeave($leaves,$totaldays);

                $this->addLeave(date('Y-m-d',strtotime($from_orig)),date('Y-m-d',strtotime($to)),'multiple',$totaldays,$code,$code,'YES',null);

            }

            return redirect('/');
        } 
        else
        {
            return view('error-message')->with('error_message','Not enough leave balance..');
        }       

        
    }
    private function addLeave($dt1,$dt2,$type,$dduc,$code1,$code2,$parent,$lwop,$rem = null)
    {
            //GET DURATION
            switch ($type) {
                case 'wholeday':
                        $deduc = 1;
                    break;
                case 'multiple':
                        $deduc = $dduc;
                    break;
                default:
                        $deduc = 0.5;
                    break;
            }


            //CHARGE VL TO FL 
            $leaveid = request()->leave_id;
            
            //IF DIRECTOR
            $director = 'NO';
            if(Auth::user()->usertype == 'Director')
                $director = 'YES';

            $request = new App\Request_leave;
            // $request->user_id = Auth::user()->id;
            $request->user_id = request()->userid2;
            $request->empcode = Auth::user()->username;
            $request->director = $director;
            $request->user_div = Auth::user()->division;
            $request->leave_date_from = $dt1;
            $request->leave_date_to = $dt2;

            $request->parent = $parent;
            $request->parent_leave = $code1;
            $request->parent_leave_code = $code2;
            
            $request->leave_id = $leaveid;
            $request->leave_deduction = $deduc;
            $request->leave_deduction_time = request()->leave_time;

            // $request->leave_remarks = $rem;

            $request->lwop = $lwop;

            $request->save();

            $tblid = $request->id;

            $dt = $dt1 ."-".$dt2;
            
            if($dt1 == $dt2)
                $dt = $dt1;

            add_history_leave(Auth::user()->id,request()->leave_id,$tblid,$dt,'Requested');
        
    }

    public function checkIfWeekend($dt)
    {
        $dt = Carbon::parse($dt);

        if($dt->isWeekend())
            return true;
        else
            return false;
    }

    private function checkFL($userid)
    {
        $fl = getLeaves($userid,6);
        return $fl;
    }

    public function updateLeave()
    {
        $lv = new App\Employee_leave;

        $lv->leave_id = request()->leave_list_1;
        $lv->user_id = request()->emp_list_1;
        // $lv->empcode = request()->leave_id;
        $lv->leave_bal = request()->leave_bal;
        $lv->leave_bal_nega = request()->leave_bal_neg;
        $lv->save();

        return redirect('maintenance');
    }
}
