<?php

namespace App\Http\Controllers\AttendanceMonitoring;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;
use Carbon\Carbon;

class TOController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {   
     	return view('dtr.request-to');   
    }

    public function send()
    {
    	// foreach (request()->leavedates as $key => $values) {
     //        $request = new App\RequestTO;
     //        $request->userid = Auth::user()->id;
     //        $request->empcode = Auth::user()->username;
     //        $request->employee_name = Auth::user()->lname.', '.Auth::user()->fname.' ' .Auth::user()->mname;
     //        $request->division = Auth::user()->division;
     //        $request->to_date = $values;
     //        $request->to_deduction = request()->todeduc[$key];
     //        $request->to_deduction_time = request()->todeductime[$key];
     //        $request->to_remarks = request()->remarks[$key];
     //        $request->save();
     //        $requestid = $request->id;

     //        add_to_leave(Auth::user()->id,$requestid,$values,"Requested");
     //    }

        $duration = explode('-',request()->leave_duration3);

        $from = Carbon::parse($duration[0]);
        $to = Carbon::parse($duration[1]);

        $diff = 1+($from->diffInDays($to));

        //CHECK IF SINGLE DATE
        if($diff == 1)
        {
            $this->addTO(date('Y-m-d',strtotime($from)));
        }
        else
        {
            for($i = 1; $i <= $diff; ++$i)
            {
                if($i == 1)
                {
                    $this->addTO(date('Y-m-d',strtotime($from)));
                    
                }
                else
                {
                    $dt = $from->addDays(1);
                    $this->addTO(date('Y-m-d',strtotime($dt)));
                }
                
            }
        }

        //ADD HISTORY ON LEAVE

        return redirect('/');
    }

    private function addTO($dt)
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

            $request = new App\RequestTO;
            $request->userid = Auth::user()->id;
            $request->empcode = Auth::user()->username;
            $request->employee_name = Auth::user()->lname.', '.Auth::user()->fname.' ' .Auth::user()->mname;
            $request->division = Auth::user()->division;
            $request->to_date = $dt;
            $request->to_deduction = $deduc;
            $request->to_deduction_time = request()->leave_time;
            $request->to_vehicle = request()->vehicle;
            $request->to_perdiem = request()->perdiem;
            $request->to_place = request()->place;
            $request->to_purpose = request()->purpose;
            $request->save();

            $tblid = $request->id;

            add_to_leave(Auth::user()->id,$tblid,$dt,"Requested");
        
    }
}
