<?php

namespace App\Http\Controllers\PersonnelInformation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Auth;

class StaffController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index($tab)
    {
        $data = [
                    "nav" => nav("myprofile"),
                    "active_tab" => $tab,
                    "empinfo" => App\View_user::where('id',Auth::user()->id)->first(),
                    "contact" => App\Employee_contact::where('user_id',Auth::user()->id)->first(),
                    "basicinfo" => App\Employee_basicinfo::where('user_id',Auth::user()->id)->first(),
                    "addinfo" => App\Employee_addinfo::where('user_id',Auth::user()->id)->first(),
                    "family" => App\Employee_family::where('user_id',Auth::user()->id)->first(),
                    "education" => App\Employee_education::where('user_id',Auth::user()->id)->get(),
                    "add_permanent" => App\View_employee_add_permanent::where('user_id',Auth::user()->id)->first(),
                    "add_residential" => App\View_employee_add_residential::where('user_id',Auth::user()->id)->first(),
                    "organization" => App\Employee_organization::where('user_id',Auth::user()->id)->get(),
                    "work" => App\Employee_work::where('user_id',Auth::user()->id)->orderBy('workexp_date_from','desc')->get(),
                    "eligibility" => App\Employee_eligibility::where('user_id',Auth::user()->id)->get(),
                    "skill" => App\Employee_skill::where('user_id',Auth::user()->id)->get(),
                    "competency" => App\Employee_competency::where('user_id',Auth::user()->id)->get(),
                    "competency_duty" => App\Employee_competencies_duty::where('user_id',Auth::user()->id)->get(),
                    "competency_training" => App\Employee_competencies_training::where('user_id',Auth::user()->id)->get(),
                    "recognition" => App\Employee_recognition::where('user_id',Auth::user()->id)->get(),
                    "association" => App\Employee_association::where('user_id',Auth::user()->id)->get(),
                    "reference" => App\Employee_reference::where('user_id',Auth::user()->id)->get(),
                    'training' => App\Employee_training::where('user_id',Auth::user()->id)->orderBy('training_inclusive_dates','desc')->get(),
                    "total_training_hours" => App\Employee_training::where('user_id',Auth::user()->id)->selectRaw('sum(training_hours) as sum')->pluck('sum'),
                    "total_training_amount" => App\Employee_training::where('user_id',Auth::user()->id)->selectRaw('sum(training_amount) as sum')->pluck('sum'),
                    "ipcr" => App\View_performance_group_dpcr_ipcr::where('user_id',Auth::user()->id)->whereNotNull('ipcr_submitted_at')->get(),
                    
                ];

        return view('pis.staff.myinfo')->with("data",$data);
    }

    public function invitation()
    {
        $data = [
                    "nav" => nav("invitation"),
                ];
        return view('pis.staff.invitation')->with("data",$data);
    }

    public function invitationanswer()
    {
        if(request()->invitation_answer == 'Delete')
        {
            App\Invitation::where('id',request()->invitation_id)->delete();
        }
        else
        {
            App\Invitation::where('id',request()->invitation_id)
                        ->update([
                                    'interested' => request()->invitation_answer
                                ]);  
        }
        
    }

    public function invitationalert()
    {
        $inv = App\Invitation::where('user_id',Auth::user()->id)->whereIn('interested',['','Yes'])->count();

        $arr = ['total' => $inv];
        return json_encode($arr);
    }
}
