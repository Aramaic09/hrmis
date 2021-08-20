<?php

namespace App\Http\Controllers\AttendanceMonitoring;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Carbon\Carbon;

class OTController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {   
     	return view('dtr.request-ot');   
    }

    public function send()
    {
    	// foreach (request()->leavedates as $key => $values) {
     //        $request = new App\RequestOT;
     //        $request->userid = Auth::user()->id;
     //        $request->empcode = Auth::user()->username;
     //        $request->employee_name = Auth::user()->lname.', '.Auth::user()->fname.' ' .Auth::user()->mname;
     //        $request->division = Auth::user()->division;
     //        $request->ot_date = $values;
     //        $request->ot_deduction = request()->otdeduc[$key];
     //        $request->ot_deduction_time = request()->otdeductime[$key];
     //        $request->ot_remarks = request()->remarks[$key];
     //        $request->save();
     //        $requestid = $request->id;

     //        add_ot_leave(Auth::user()->id,$requestid,$values,"Requested");
     //    }

        //ADD HISTORY ON LEAVE

        $duration = explode('-',request()->leave_duration3);

        $from = Carbon::parse($duration[0]);
        $to = Carbon::parse($duration[1]);

        $diff = 1+($from->diffInDays($to));

        //CHECK IF SINGLE DATE
        if($diff == 1)
        {
            $this->addOT(date('Y-m-d',strtotime($from)));
        }
        else
        {
            for($i = 1; $i <= $diff; ++$i)
            {
                if($i == 1)
                {
                    $this->addOT(date('Y-m-d',strtotime($from)));
                    
                }
                else
                {
                    $dt = $from->addDays(1);
                    $this->addOT(date('Y-m-d',strtotime($dt)));
                }
                
            }
        }

        return redirect('/');
    }

    private function addOT($dt)
    {
            //GET DURATION
            switch (request()->leave_time) {
                case 'wholeday':
                        $deduc = 1;
                    break;
                
                default:
                        $deduc = 0.5;
                    break;
            }

            $request = new App\RequestOT;
            $request->userid = Auth::user()->id;
            $request->empcode = Auth::user()->username;
            $request->employee_name = Auth::user()->lname.', '.Auth::user()->fname.' ' .Auth::user()->mname;
            $request->division = Auth::user()->division;
            $request->ot_date = $dt;
            $request->ot_hours = request()->cto_hours;
            $request->ot_deduction = $deduc;
            $request->ot_deduction_time = request()->leave_time;
            $request->ot_remarks = request()->remarks;
            $request->save();

            $tblid = $request->id;

            add_ot_leave(Auth::user()->id,$tblid,$dt,"Requested");
        
    }
}
