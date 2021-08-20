<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemManager;
use File;
use App;
use App\Imports\SalaryImport;

use Maatwebsite\Excel\Facades\Excel;

class Process extends Controller
{
    // private $info = "";

    public function __construct()
    {
        $this->middleware('auth');
        
    }

    private function getInfo($id)
    {
        $emp = 
        $emp = $this->info->where('user_id',$id)->orderBy('plantilla_date_to')->first();
        return $emp['plantilla_salary'];
    }

    public function index()
    {
        $data = 
                [
                    "nav" => nav("payrollprocess"),
                ];
        return view('payroll.process')->with("data",$data);
    }

    public function create()
    {
        //MAX CHARACTER
        $max = 73;
        $max2 = 23;

        //CONST FOR LANDBANK
        $atm = "1890000";

        $folder = request()->path;

        if (!file_exists($folder)) {
            Storage::disk('payroll')->makeDirectory($folder);

            $fsMgr = new FilesystemManager(app());
            // local disk
            $localDisk = $fsMgr->createLocalDriver(['root' => storage_path('app/payroll/'.$folder)]);

            //CREATE 4 WEEKS
            for ($i=1; $i <= 4 ; $i++) { 

                //GET ALL ACTIVE EMPLOYEE
                $emp = App\View_user::get();
                $txt = "";

                foreach ($emp as $key => $value) {
            
                    $txt1 = $value->addinfo_atm.''.$value->lname.','.$value->fname.' '.$value->mname[0];

                    $txtctr = strlen($txt1);

                    //GET SALARY PER WEEK
                    $salary = getPlantillaInfo($value->username);
                    $salary = getSalaryWeek($value->username,$salary['plantilla_salary'],$i);
                    $salary = str_replace(array('.', ','), '' , $salary);

                    //SPACES IN BETWEEN TO REACH 73 characters
                    $chrs = 73 - ($txtctr + 23);
                    $spaces = str_repeat(' ', $chrs);

                    //ZERO BEFORE SALARY
                    $txt2 = $salary.$atm.$i;
                    $txtctr = strlen($txt2);
                    $chrs = 23 - ($txtctr);
                    $zeros = str_repeat('0', $chrs);


                    $txt .= $value->addinfo_atm.''.$value->lname.','.$value->fname.' '.$value->mname[0].$spaces.$zeros.$txt2."\n";


                    //UPDATE DB
                    

                }
               $localDisk->put('PC'.request()->payrollmon.'WK'.$i.'.txt', $txt);
            }
        }
        else
        {
            return "folder already exist";
        }

        // return redirect('payroll/process');
    }

    public function test()
    {


    $salarytbl = App\SalaryTable::first();

    $array = Excel::toArray(new SalaryImport, storage_path('app/salarysched/'.$salarytbl['salary_filename'].'.xlsx'));

    return $array[0];

    // $collection = Excel::toCollection(new SalaryImport, );

        foreach($array AS $index => $val)
        {
            echo $val[$index][0];
        }
    
    }

}
