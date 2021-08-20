<?php

namespace App\Http\Controllers\Maintenance;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App;
use Carbon\Carbon;
use Auth;

class Maintenance extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data = [
                    'dtr_option' => collect(App\DTROption::get()),
                    'holiday' => collect(App\Holiday::orderBy('holiday_date','DESC')->get()),
                    'suspension' => collect(App\Suspension::orderBy('fldSuspensionDate','DESC')->get()),
                    'exemption' => collect(App\User::where('dtr_exe',1)->get())
                ];

        return view('dtr.admin.maintenance')->with('data',$data);
    }

    public function workschedule()
    {
        //UPDATE LAST WS
        $ws = new App\WorkSchedule;
        $ws = $ws->where('id',request()->ws_id)
                ->update([
                            'date_to' => date('Y-m-d'),
                        ]);

        $ws = new App\WorkSchedule;
        $ws->dtr_option_id = request()->dtroptions;
        $ws->date_from = date('Y-m-d');
        $ws->save();

        return redirect('maintenance');
    }
}
