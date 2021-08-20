<?php

namespace App\Http\Controllers\AttendanceMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class DirectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function request()
    {
    	$emp = App\View_user::where('id',Auth::user()->id)->first();
    	$data = [
                    "empinfo" => $emp,
                    "nav" => nav("attendance"),
                ];
        return view('dtr.director.request-for-approval')->with("data",$data);
    }

    public function requestsubmit()
    {
    	// Dahil sama-sama sa isang request() ang checkbox
    	// need ihiwalay kada array yung mga IDs
    	// para isang batch na lang kada request type(leave,ot,to)

    	$arr_leaves = [];
    	$arr_ots = [];
    	$arr_tos = [];

    	foreach (request()->check_request as $value) {
    		$br = explode("_", $value);
    		switch ($br[0]) {
    			case 'leave':
    					array_push($arr_leave, (int)$br[1]);
    				break;
    		}
    	}


    	//LEAVE
    	if(isset($arr_leave))
    	{
    		App\Request_leave::whereIn('id',$arr_leaves)
          		->update([
          					'leave_approved_by' => Auth::user()->id,
          					'leave_approved_date' => date(''),
          				]);
    	}
    	

    	return $arr_leaves;
    }

    public function approvedLeaveRequest()
    {

        foreach (request()->check_request as $key => $values) {
            $request = App\Request_leave::where('id',$values)
                            ->update([
                                        'leave_action_status' => request()->leave_action_status,
                                    ]);
                            
            add_history_leave(request()->userid[$key],request()->leavedid[$key],request()->leavedates[$key],request()->leave_action_status);
        }

        return redirect('request-for-approval');
    }

    public function actionRequest()
    {
        $status = "Approved";

        if(request()->leave_action_status == 'Disapproved')
        {
            $status = "Disapproved";
        }
        $i = 0;
        foreach (request()->check_request as $values) 
        {
            
            switch (request()->requestype[$values]) {
                case 'leave':

                //GET PARENT CODE
                $codes = App\Request_leave::where('id',request()->requestid[$values])->first();
                $code = $codes['parent_leave'];

                $request = App\Request_leave::where('parent_leave_code',$code)
                            ->update([
                                        'leave_action_status' => $status,
                                        'leave_action_by' => Auth::user()->lname.', '.Auth::user()->fname,
                                        'leave_action_date' => date('Y-m-d H:i:s'),
                                    ]);

                $dtr = App\Request_leave::where('parent_leave_code',$code)->whereIn('parent',['NO',null])->get();

                // CHECK IF HAS FORCE LEAVE
                if($codes['leave_id'] == 1)
                {
                    $fl = App\Request_leave::whereIn('parent',['NO',NULL])->where('leave_date_from',$codes['leave_date_from'])->where('leave_id',6)->first();
                    if(isset($fl))
                    {
                        App\Request_leave::where('id',$fl['id'])
                            ->update([
                                        'leave_action_status' => $status,
                                        'leave_action_by' => Auth::user()->lname.', '.Auth::user()->fname,
                                        'leave_action_date' => date('Y-m-d H:i:s'),
                                    ]);
                    }
                }

                foreach ($dtr as $key => $value) {
                    
                        // add_history_leave($value->id,$value->leave_id,request()->requestid[$key],$value->leave_date_from,$status);

                        //ADD TO DTR
                        $lwop = null;
                        // if($leave > 0)
                        // {
                        //     $lwop = 'YES';
                        // }

                        if($status == 'Approved')
                        {
                            $remarks = getLeaveDesc(request()->leaveid[$values]);

                            $dtr = new App\Employee_dtr;
                            $dtr->fldEmpCode =  getStaffInfo(request()->userid[$values],'empcode');
                            $dtr->employee_name =  getStaffInfo(request()->userid[$values]);
                            $dtr->division =  getStaffInfo(request()->userid[$values],'division_id');
                            $dtr->user_id =  request()->userid[$values];
                            $dtr->fldEmpDTRdate =  $value->leave_date_from;
                            $dtr->fldEmpDTRamIn =  "08:00:00";
                            $dtr->fldEmpDTRamOut =  "12:00:00";
                            $dtr->fldEmpDTRpmIn =  "13:00:00";
                            $dtr->fldEmpDTRpmOut =  "17:00:00";
                            $dtr->request =  $remarks;
                            $dtr->request_id =  request()->requestid[$values];
                            // $dtr->lwop =  $lwop;
                            $dtr->dtr_remarks =  $remarks;
                            $dtr->save();
                        }

                        // $leave--;
                }


                        

                        
                        

                    break;
                case 'TO':
                        $request = App\RequestTO::where('id',request()->requestid[$values])
                            ->update([
                                        'to_status' => $status,
                                        'to_status_by' => Auth::user()->lname.', '.Auth::user()->fname,
                                        'to_status_date' => date('Y-m-d H:i:s'),
                                    ]);

                        add_to_leave(request()->userid[$values],request()->requestid[$values],request()->leavedates[$values],$status);

                        if($status == 'Approved')
                        {
                            $dtr = new App\Employee_dtr;
                            $dtr->fldEmpCode =  getStaffInfo(request()->userid[$values],'empcode');
                            $dtr->employee_name =  getStaffInfo(request()->userid[$values]);
                            $dtr->division =  getStaffInfo(request()->userid[$values],'division_id');
                            $dtr->user_id =  request()->userid[$values];
                            $dtr->fldEmpDTRdate =  request()->leavedates[$values];
                            $dtr->fldEmpDTRamIn =  "08:00:00";
                            $dtr->fldEmpDTRamOut =  "12:00:00";
                            $dtr->fldEmpDTRpmIn =  "13:00:00";
                            $dtr->fldEmpDTRpmOut =  "17:00:00";
                            $dtr->request =  "T.O";
                            $dtr->request_id =  request()->requestid[$values];
                            $dtr->save();
                        }


                    break;
                case 'OT':
                        $request = App\RequestOT::where('id',request()->requestid[$values])
                            ->update([
                                        'ot_status' => $status,
                                        'ot_status_by' => Auth::user()->lname.', '.Auth::user()->fname,
                                        'ot_status_date' => date('Y-m-d H:i:s'),
                                    ]);
                        add_to_leave(request()->userid[$values],request()->requestid[$values],request()->leavedates[$values],$status);
                        
                        if($status == 'Approved')
                        {
                            $dtr = new App\Employee_dtr;
                            $dtr->fldEmpCode =  getStaffInfo(request()->userid[$values],'empcode');
                            $dtr->employee_name =  getStaffInfo(request()->userid[$values]);
                            $dtr->division =  getStaffInfo(request()->userid[$values],'division_id');
                            $dtr->user_id =  request()->userid[$values];
                            $dtr->fldEmpDTRdate =  request()->leavedates[$values];
                            $dtr->fldEmpDTRamIn =  "08:00:00";
                            $dtr->fldEmpDTRamOut =  "12:00:00";
                            $dtr->fldEmpDTRpmIn =  "13:00:00";
                            $dtr->fldEmpDTRpmOut =  "17:00:00";
                            $dtr->request =  "O.T";
                            $dtr->request_id =  request()->requestid[$values];
                            $dtr->save();
                        }
                    break;
            }

            // return request()->check_request[$key]." - ".request()->request_index[$key]." - ".$status;

            // $i++;

            // echo request()->requestype[$values]."<br>";
        }

        // return request()->requestype[];
    }
}
