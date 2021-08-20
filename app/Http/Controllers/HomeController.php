<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
use Carbon\Carbon;
use lluminate\Support\Collection;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        if(Auth::user()->usertype == 'Administrator')
        {
            return redirect('admin/dashboard/ALL');    
        }
        // elseif(Auth::user()->usertype == 'Director')
        // {
        //     $emp = App\View_user::where('id',Auth::user()->id)->first();
        //     $data = [
        //                 "empinfo" => $emp,
        //                 "nav" => nav("dashboard"),
        //             ];
        //     return view('pis.director.index')->with("data",$data);
        // }
        else
        {
            if(Auth::user()->employment_id == 1)
            {
                $emp = App\View_user::where('id',Auth::user()->id)->first();
            }
            else
            {
                $emp = App\View_users_temp::where('id',Auth::user()->id)->first();
            }

            $data = [
                        "empinfo" => $emp,
                        "nav" => nav("dashboard"),
                        "dtr" => $this->getDTR(Auth::user()->id,date('m'),date('Y')),
                    ];
            return view('pis.staff.index')->with("data",$data);
        }
        
    }

    private function getDTR($userid,$mon,$yr)
    {
        $dtr = App\Employee_dtr::where('user_id',$userid)->whereMonth('fldEmpDTRdate',$mon)->whereYear('fldEmpDTRdate',$yr)->get();
        // $dtr = collect($dtr);
        // return $dtr->all();

        return $dtr;
    }
}
