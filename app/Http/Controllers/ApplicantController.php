<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ApplicantController extends Controller
{
    public function index($letter,$code)
    {
        if(isset($code))
        {
            $data = 
                [
                    "code" => $code,
                    "info" => App\View_vacant_plantilla::where('plantilla_item_number',$code)->first(),
                    "request_id" => $letter
                ];
            return view('applicants.index')->with('data',$data);
        }
        else
        {
            return redirect('job-vacancies');
        }
    	
    }

    public function vacancy()
    {
        $job = App\View_vacant_plantilla::whereNotNull('plantilla_posted')->get();

        return view('applicants.jobvacancies')->with('job',$job);
    }

    public function thankyou()
    {
    	return view('applicants.thank-you');
    }

    public function list($token)
    {
        //GET TOKEN EQUIVELANT TO ID
        $plantilla = App\LinkToApplicant::where('token',$token)->first();

        $data = 
                [
                    "info" => App\View_vacant_plantilla::where('id',$plantilla['plantilla_id'])->first(),
                    "list" => App\View_job_application::where('vacant_plantilla_id',$plantilla['plantilla_id'])->where('div_shortlisted','YES')->get(),
                ];
        return view('applicants.list-of-applicants-for-psb')->with('data',$data);
    }

    public function create()
    {
        //FILES

        $path_file_cv = null;
        if(request()->hasFile('cv'))
        {
            $path_file_cv = request()->file('cv')->store('applicant_cv');
        }

        $path_file_appletter = null;
        if(request()->hasFile('appletter'))
        {
            $path_file_appletter = request()->file('appletter')->store('applicant_letter');
        }

        $path_file_trainingcert = null;
        if(request()->hasFile('trainingcert'))
        {
            $path_file_trainingcert = request()->file('trainingcert')->store('applicant_training');
        }

        $path_file_photo = null;
        if(request()->hasFile('photo'))
        {
            $path_file_photo = request()->file('photo')->store('applicant_photo');
        }

        $path_file_servicerecords = null;
        if(request()->hasFile('servicerecord'))
        {
            $path_file_servicerecords = request()->file('servicerecord')->store('applicant_servicerecord');
        }

        $path_file_cs = null;
        if(request()->hasFile('cs'))
        {
            $path_file_cs = request()->file('cs')->store('applicant_cs');
        }

        $path_file_evaluationcert = null;
        if(request()->hasFile('evaluationcert'))
        {
            $path_file_evaluationcert = request()->file('evaluationcert')->store('applicant_evaluationcert');
        }

        

    	$applicant = new App\Applicant;
    	$applicant->lname = request()->lname;
    	$applicant->fname = request()->fname;
    	$applicant->mname = request()->mname;
        $applicant->contactnum = request()->contactnum;
    	$applicant->email = request()->email;
        $applicant->file_cv = $path_file_cv;
        $applicant->file_appletter = $path_file_appletter;
        $applicant->file_trainingcert = $path_file_trainingcert;
        $applicant->file_photo = $path_file_photo;
        $applicant->file_servicerecords = $path_file_servicerecords;
        $applicant->file_evaluationcert = $path_file_evaluationcert;
        $applicant->file_cs = $path_file_cs;

    	$applicant->email_me = request()->emailMe;
    	$applicant->save();
        $applicant_id = $applicant->id;

        $applicant_list = new App\Applicant_position_apply;
        $applicant_list->request_id = request()->request_id;
        $applicant_list->vacant_plantilla_id = $this->getVacantId(request()->itemcode);
        $applicant_list->applicant_id = $applicant->id;
        $applicant_list->save();

    	return redirect('thank-you');
    }

    public function getVacantId($id)
    {
        $q = App\Vacant_plantilla::where('plantilla_item_number',$id)->first();
        return $q['id'];
    }

    public function hrdcreview($id)
    {
        $data = [
                    'hrd' => App\HRD_plan::where('id',$id)->first(),
                    'division' => App\Division::whereNotNull('type')->get(),
                ];

        return view('pis.learningdev.hrd-review')->with('data',$data);
    }
}
