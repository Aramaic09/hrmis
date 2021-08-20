<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('home', 'HomeController@index')->name('home');


/***********PERSONNEL INFORMATION***********/

Route::get('personal-information/{tab}', 'PersonnelInformation\StaffController@index');

//CALENDAR
Route::get('calendar', 'Calendar\CalendarController@index');


/*------ADMINISTRATOR PAGES------*/
Route::get('admin/dashboard/{division}', 'PersonnelInformation\AdminController@dashboard');
Route::get('list-of-employees', 'PersonnelInformation\AdminController@index');
Route::get('list-of-applicants/{plantilla}', 'PersonnelInformation\AdminController@applicants');
Route::get('dashboard-employee/{div}', 'PersonnelInformation\EmployeeAdminController@dashboard');
Route::get('dashboard-staff/{div}', 'PersonnelInformation\EmployeeAdminController@dashboard2');
Route::get('add-new-employee', 'PersonnelInformation\EmployeeAdminController@index');
Route::get('retiree/{div}', 'PersonnelInformation\AdminController@retiree');
Route::get('update-employee/{id}', 'PersonnelInformation\EmployeeAdminController@updateview');
Route::get('service-record', 'PersonnelInformation\AdminController@servicerecord');
Route::get('pis-library/{tab}', 'PersonnelInformation\AdminController@library');
Route::get('contract-of-service', 'PersonnelInformation\AdminController@jos');

Route::get('invites/pdf/{id}', 'PersonnelInformation\PDFController@invites');

Route::post('hire-new-employee', 'PersonnelInformation\EmployeeAdminController@hire');
Route::post('hire-transfer-employee', 'PersonnelInformation\EmployeeAdminController@transferhire');
Route::post('add-new-hire-employee', 'PersonnelInformation\EmployeeAdminController@newhire');


//REQUEST FOR HIRING
Route::get('letter-of-request-list', 'PersonnelInformation\AdminController@requestHiring');
Route::post('request-for-hiring/action', 'PersonnelInformation\AdminController@requestAction');
Route::post('request-for-hiring/approve', 'PersonnelInformation\AdminController@requestApprove');
Route::post('request-for-hiring/upload-psb', 'PersonnelInformation\AdminController@uploadpsb');

//APPLICANT
Route::post('applicants/upload-psycho', 'PersonnelInformation\AdminController@uploadPsycho');


//INVITATION
Route::get('invitation/select/{id}', 'PersonnelInformation\InvitationController@select');
Route::post('invitation/create', 'PersonnelInformation\InvitationController@create');
Route::post('invitation/delete', 'PersonnelInformation\InvitationController@delete');
Route::post('invitation/update', 'PersonnelInformation\InvitationController@update');
Route::post('invitation/assign', 'PersonnelInformation\InvitationController@assign');
Route::get('invitation/json/{id}', 'PersonnelInformation\InvitationController@json');
Route::post('invitation/preview-list', 'PersonnelInformation\PDFController@previewInvitation');

//PLANTILLA
Route::get('vacant-position', 'PersonnelInformation\PlantillaController@index');
Route::post('plantilla/create', 'PersonnelInformation\PlantillaController@create');
Route::post('plantilla/delete', 'PersonnelInformation\PlantillaController@delete');
Route::post('plantilla/update', 'PersonnelInformation\PlantillaController@update');
Route::post('plantilla/assign', 'PersonnelInformation\PlantillaController@assign');
Route::post('plantilla/repost', 'PersonnelInformation\PlantillaController@repost');
Route::get('plantilla/json/{id}', 'PersonnelInformation\PlantillaController@json');


//POST EMPLOYEE
Route::post('employee/create', 'PersonnelInformation\EmployeeAdminController@create');
Route::post('employee/delete', 'PersonnelInformation\EmployeeAdminController@delete');
Route::post('employee/update', 'PersonnelInformation\EmployeeAdminController@update');

//POST DIVISION
Route::post('division/create', 'PersonnelInformation\PISLibraryDivisionController@create');
Route::post('division/delete', 'PersonnelInformation\PISLibraryDivisionController@delete');
Route::post('division/update', 'PersonnelInformation\PISLibraryDivisionController@update');

//POST POSITION
Route::post('position/create', 'PersonnelInformation\PISLibraryPositionController@create');
Route::post('position/delete', 'PersonnelInformation\PISLibraryPositionController@delete');
Route::post('position/update', 'PersonnelInformation\PISLibraryPositionController@update');

//POST DESIGNATION
Route::post('designation/create', 'PersonnelInformation\PISLibraryDesignationController@create');
Route::post('designation/delete', 'PersonnelInformation\PISLibraryDesignationController@delete');
Route::post('designation/update', 'PersonnelInformation\PISLibraryDesignationController@update');

//POST EMPLOYMENT
Route::post('employment/create', 'PersonnelInformation\PISLibraryEmploymentController@create');
Route::post('employment/delete', 'PersonnelInformation\PISLibraryEmploymentController@delete');
Route::post('employment/update', 'PersonnelInformation\PISLibraryEmploymentController@update');

//RESET PASSWORD
Route::post('reset-password', 'PersonnelInformation\EmployeeAdminController@resetpassword');

//CHANGE STATUS
Route::post('change-status', 'PersonnelInformation\EmployeeAdminController@changestatus');

//TRANSFER
Route::post('transfer-employee', 'PersonnelInformation\EmployeeAdminController@transfer');

//PDF REPORT
// Route::get('pdf-print', 'PersonnelInformation\PDFController@index');
Route::post('pdf/service-record', 'PersonnelInformation\PDFController@servicerecord');
Route::get('pdf/pds/', 'PersonnelInformation\PDFController@pds');
Route::get('position-classification/{division}/{class}', 'PersonnelInformation\PDFController@positionClass');
Route::get('position-description/{division}/{class}', 'PersonnelInformation\PDFController@positionDesc');
Route::get('trainings-list/{division}', 'PersonnelInformation\PDFController@trainingsList');
Route::get('employee-education/{division}/{class}', 'PersonnelInformation\PDFController@educationClass');

//POST TRAINING
Route::post('training/create', 'PersonnelInformation\TrainingController@create');
Route::post('training/delete', 'PersonnelInformation\TrainingController@delete');
Route::post('training/update', 'PersonnelInformation\TrainingController@update');
Route::get('training/json/{id}', 'PersonnelInformation\TrainingController@json');

Route::post('training/request/create', 'PersonnelInformation\TrainingController@createrequest');

//POST TRAINING TEMP
Route::post('request-for-training/create', 'PersonnelInformation\TrainingTempController@create');
Route::post('request-for-training/action', 'PersonnelInformation\TrainingTempController@action');
Route::post('request-for-training/delete', 'PersonnelInformation\TrainingTempController@delete');
Route::post('request-for-training/update', 'PersonnelInformation\TrainingTempController@update');
Route::post('request-for-training/complete', 'PersonnelInformation\TrainingTempController@complete');
Route::get('request-for-training/json/{id}', 'PersonnelInformation\TrainingTempController@json');

//EMPOYEE BASIC INFO
Route::post('basicinfo/check', 'PersonnelInformation\BasicinfoController@check');
Route::post('basicinfo/create', 'PersonnelInformation\BasicinfoController@create');
Route::post('basicinfo/update', 'PersonnelInformation\BasicinfoController@update');
Route::get('basicinfo/json/{id}', 'PersonnelInformation\BasicinfoController@json');
Route::post('basicinfo/update-photo', 'PersonnelInformation\BasicinfoController@updatePhoto');

//EMPOYEE FAMILY
Route::post('family/check', 'PersonnelInformation\FamilyController@check');
Route::post('family/create', 'PersonnelInformation\FamilyController@create');
Route::post('family/update', 'PersonnelInformation\FamilyController@update');
Route::get('family/json/{id}', 'PersonnelInformation\FamilyController@json');

//EMPOYEE WORK
Route::post('education/create', 'PersonnelInformation\EducationController@create');
Route::post('education/update', 'PersonnelInformation\EducationController@update');
Route::post('education/delete', 'PersonnelInformation\EducationController@delete');
Route::get('education/json/{id}', 'PersonnelInformation\EducationController@json');

//EMPOYEE ADD INFO
Route::post('addinfo/check', 'PersonnelInformation\AddinfoController@check');
Route::post('addinfo/create', 'PersonnelInformation\AddinfoController@create');
Route::post('addinfo/update', 'PersonnelInformation\AddinfoController@update');
Route::get('addinfo/json/{id}', 'PersonnelInformation\AddinfoController@json');

//EMPOYEE ORGANIZATION
Route::post('organization/create', 'PersonnelInformation\OrganizationController@create');
Route::post('organization/update', 'PersonnelInformation\OrganizationController@update');
Route::post('organization/delete', 'PersonnelInformation\OrganizationController@delete');
Route::get('organization/json/{id}', 'PersonnelInformation\OrganizationController@json');

//EMPOYEE WORK
Route::post('work/create', 'PersonnelInformation\WorkController@create');
Route::post('work/update', 'PersonnelInformation\WorkController@update');
Route::post('work/delete', 'PersonnelInformation\WorkController@delete');
Route::get('work/json/{id}', 'PersonnelInformation\WorkController@json');

//EMPOYEE ELIGIBILITY
Route::post('eligibility/create', 'PersonnelInformation\EligibilityController@create');
Route::post('eligibility/update', 'PersonnelInformation\EligibilityController@update');
Route::post('eligibility/delete', 'PersonnelInformation\EligibilityController@delete');
Route::get('eligibility/json/{id}', 'PersonnelInformation\EligibilityController@json');

//EMPOYEE SKILL
Route::post('skill/create', 'PersonnelInformation\SkillController@create');
Route::post('skill/update', 'PersonnelInformation\SkillController@update');
Route::post('skill/delete', 'PersonnelInformation\SkillController@delete');
Route::get('skill/json/{id}', 'PersonnelInformation\SkillController@json');

//EMPOYEE RECOGNITION
Route::post('recognition/create', 'PersonnelInformation\RecognitionController@create');
Route::post('recognition/update', 'PersonnelInformation\RecognitionController@update');
Route::post('recognition/delete', 'PersonnelInformation\RecognitionController@delete');
Route::get('recognition/json/{id}', 'PersonnelInformation\RecognitionController@json');

//EMPOYEE ASSOCIATION
Route::post('association/create', 'PersonnelInformation\AssociationController@create');
Route::post('association/update', 'PersonnelInformation\AssociationController@update');
Route::post('association/delete', 'PersonnelInformation\AssociationController@delete');
Route::get('association/json/{id}', 'PersonnelInformation\AssociationController@json');

//EMPOYEE REFERENCES
Route::post('reference/create', 'PersonnelInformation\ReferenceController@create');
Route::post('reference/update', 'PersonnelInformation\ReferenceController@update');
Route::post('reference/delete', 'PersonnelInformation\ReferenceController@delete');
Route::get('reference/json/{id}', 'PersonnelInformation\ReferenceController@json');

//EMPOYEE ADDRESS/CONTACT
Route::post('address/check', 'PersonnelInformation\AddressController@check');
Route::get('location/municipal/{prov_id}', 'PersonnelInformation\AddressController@municipal');
Route::get('location/barangay/{mun_id}', 'PersonnelInformation\AddressController@barangay');

//MARSHALL
Route::get('letter-request', 'PersonnelInformation\MarshalController@requestHiring');
Route::get('recruitment/list-of-applicants/{id}/{letterid}', 'PersonnelInformation\SharedController@applicants');
Route::post('request-for-hiring/update-applicants', 'PersonnelInformation\SharedController@updateapplicants');
Route::post('request-for-hiring/create', 'PersonnelInformation\RequestForHiringController@create');
Route::post('request-for-hiring/update', 'PersonnelInformation\RequestForHiringController@update');
Route::post('request-for-hiring/delete', 'PersonnelInformation\RequestForHiringController@delete');
Route::post('request-for-hiring/repost', 'PersonnelInformation\RequestForHiringController@repost');
Route::get('request-for-hiring/json/{id}', 'PersonnelInformation\RequestForHiringController@json');
Route::get('request-for-hiring-alert/json', 'PersonnelInformation\RequestForHiringController@alert');
Route::get('request-for-hiring-alert/clear', 'PersonnelInformation\RequestForHiringController@clear');
Route::post('recruitment/upload/{type}', 'PersonnelInformation\RequestForHiringController@upload');
Route::get('recruitment/history/{id}', 'PersonnelInformation\PDFController@hiringHistory');


//RECRUITMENT
Route::get('recruitment/index', 'PersonnelInformation\RecruitmentController@index');
Route::get('recruitment/list-vacant-position', 'PersonnelInformation\RecruitmentController@vacant');

//LETTER CLEARANCE
Route::get('recruitment/letter-approval', 'PersonnelInformation\RequestForHiringController@approval');
Route::post('recruitment/clearance', 'PersonnelInformation\RequestForHiringController@clearance');


//LEARNING AND DEVELOPMENT




//STAFF
Route::get('invitation/list', 'PersonnelInformation\StaffController@invitation');
Route::get('invitation/alert', 'PersonnelInformation\StaffController@invitationalert');
Route::post('invitation/answer', 'PersonnelInformation\StaffController@invitationanswer');


/***********SHARED PAGES***********/
Route::get('trainings/update', 'PersonnelInformation\TrainingTempController@trainings');

/***********END PERSONNEL INFORMATION***********/




/***********PAYROLL***********/

//PDF REPORT
Route::post('pdf/my-payslip', 'Payroll\PDFController@myPayslip');

/***********END PAYROLL***********/



/***********APPLICANTS***********/

Route::get('job-vacancies', 'ApplicantController@vacancy');
Route::get('apply/{letter}/{item}', 'ApplicantController@index');
Route::get('thank-you', 'ApplicantController@thankyou');
Route::get('list-of-applicants-for-psb/{token}', 'ApplicantController@list');
Route::post('send-application', 'ApplicantController@create');

/***********END PAYROLL***********/


/***********CALL FOR SUBMISSION***********/
Route::get('submission/list', 'Submission\PageController@index');
Route::get('submission-list/division', 'Submission\PageController@index2');
Route::post('submission-list/update', 'Submission\Submission@update2');

Route::post('submission/create', 'Submission\Submission@create');
Route::post('submission/update', 'Submission\Submission@update');
Route::post('submission/delete', 'Submission\Submission@delete');
Route::get('submission/json/{id}', 'Submission\Submission@json');

Route::get('submission/list/training-report', 'Submission\PageController@trainingreport');
Route::get('submission/list/training-certificate', 'Submission\PageController@trainingcertificate');

/***********CALL FOR SUBMISSION***********/


/***********NOTIFICATION***********/
Route::get('notifications', 'NotificationController@index');
/***********NOTIFICATION***********/


/***********LEARNING AND DEVELOPMENT***********/
Route::get('learning-development/index', 'PersonnelInformation\LearningDevController@index');
Route::post('learning-development/call-for-hrd-plan', 'PersonnelInformation\LearningDevController@hrdplandivision');
Route::get('learning-development/division-hrd-list/{id}', 'PersonnelInformation\LearningDevController@jsondivhrd');
Route::get('learning-development/hrdc-hrd-list/{id}', 'PersonnelInformation\LearningDevController@jsonhrdchrd');
Route::post('learning-development/division-upload-hrd-plan', 'PersonnelInformation\MarshalController@divuploadhrd');
Route::post('learning-development/send-to-hrdc', 'PersonnelInformation\LearningDevController@sendtohrdc');
Route::get('learning-development/list-hrd-approval', 'PersonnelInformation\SharedController@hrdapprovallist');
Route::post('learning-development/hrd-approval', 'PersonnelInformation\SharedController@hrdapproval');
Route::post('learning-development/send-to-oed', 'PersonnelInformation\LearningDevController@sendtooed');
Route::post('learning-development/oed-upload-final', 'PersonnelInformation\SharedController@oedupload');
Route::get('learning-development/hrd-plan/{hrd_degree_id}/{hrd_plan_id}', 'PersonnelInformation\SharedController@hrdplan');
Route::get('learning-development/json/hrd-plan-degree/{id}', 'PersonnelInformation\SharedController@jsonhrdplandegree');
Route::post('learning-development/save-hrd-plan-degree', 'PersonnelInformation\SharedController@savehrddegree');
Route::post('learning-development/save-hrd-plan-non-degree', 'PersonnelInformation\SharedController@savehrdnondegree');
Route::post('learning-development/update-hrd-plan-degree', 'PersonnelInformation\SharedController@updatehrddegree');
Route::post('learning-development/delete-hrd-plan-degree', 'PersonnelInformation\SharedController@deletehrddegree');
Route::post('learning-development/delete-hrd-plan-non-degree', 'PersonnelInformation\SharedController@deletehrdnondegree');
Route::get('learning-development/print/hrd-plan-degree/{degreeid}', 'PersonnelInformation\PDFController@hrddegree');
Route::get('learning-development/print/hrd-plan-non-degree/{degreeid}', 'PersonnelInformation\PDFController@hrdnondegree');
Route::post('learning-development/submit-hrd-plan', 'PersonnelInformation\SharedController@hrdsubmit');
Route::get('learning-development/print/hrd-plan-consolidated/{hrd_id}', 'PersonnelInformation\PDFController@hrdconsolidated');
Route::get('learning-development/print/hrd-plan-consolidated-degree/{hrd_id}', 'PersonnelInformation\PDFController@hrdconsolidated2');

Route::get('learning-development/print/hrd-plan-monitoring-non-degree/{hrd_id}', 'PersonnelInformation\PDFController@monitoringnondegree');
Route::get('learning-development/print/hrd-plan-monitoring-degree', 'PersonnelInformation\PDFController@monitoringdegree');

Route::get('learning-development/hrd-plan-review/{id}', 'ApplicantController@hrdcreview');
Route::post('learning-development/submit-hrd-plan-review', 'ApplicantController@hrdcreviewsubmit');
Route::post('learning-development/close-hrd', 'PersonnelInformation\LearningDevController@closehrd');

Route::get('learning-development/hrd-degree-json/{id}', 'PersonnelInformation\LearningDevController@degreejson');
Route::post('learning-development/hrd-degree-update/', 'PersonnelInformation\LearningDevController@degreeupdate');

/***********TRAINING AND DEVELOPMENT***********/



/***********PERFORMANCE MANAGEMENT***********/

Route::get('performance/index', 'PersonnelInformation\PerformanceController@index');
Route::get('performance/dpcr/json/{year}/{period}', 'PersonnelInformation\PerformanceController@jsondpcr');
Route::get('performance/division', 'PersonnelInformation\PerformanceController@division');
Route::post('performance/ipcr/create', 'PersonnelInformation\PerformanceController@ipcrcreate');
Route::post('performance/dpcr/create', 'PersonnelInformation\PerformanceController@dpcrcreate');
Route::post('performance/dpcr/submit', 'PersonnelInformation\PerformanceController@dpcrsubmit');
Route::post('performance/ipcr-staff/create', 'PersonnelInformation\PerformanceController@ipcruploadstaff');



/***********PERFORMANCE MANAGEMENT***********/


/***********AWARDS AND RECOGNITION***********/

Route::get('rewards/index', 'PersonnelInformation\RewardsRecognitionController@index');


/***********AWARDS AND RECOGNITION***********/


// Route::get('test', function () {
//     $dt = "01-15-2021";

//     return $dt->Carbon::isWeekend();
// });


// Route::get('update-emp', function () {
//     $emp = new App\Employee_division;
//     $emp = $emp->orderBy('id')->get();

//     // return $emp;
//     foreach($emp as $emps)
//     x`//     	$user = new App\Plantilla;
//     	$user = $user
//     			->where('user_id', $emps->user_id)
//           		->update(['employment_id' => $emps->employment_id]);
//     }
// });

// Route::get('plantillas', function () {
//     $emp = new App\Plantillas_history;
//     $emp = $emp->groupBy('username')->get();

//     // return $emp;
//     foreach($emp as $emps)
//     {
//     	$emp2 = new App\Plantillas_history;
//     	$emp2 = $emp2
//     			->where('username',$emps->username)
//     			->orderBy('plantilla_date_from','desc')
//     			->first();

//     	// echo $emp2->username."-".$emp2->plantilla_date_from."<br/>";

//     	$emp3 = new App\Plantilla;
//     	$emp3->username = $emp2->username;
//     	$emp3->plantilla_item_number = $emp2->plantilla_item_number;
//     	$emp3->plantilla_division = $emp2->plantilla_division;
//     	$emp3->position_id = $emp2->position_id;
//     	$emp3->plantilla_step = $emp2->plantilla_step;
//     	$emp3->employment_id = $emp2->employment_id;
//     	$emp3->plantilla_salary = $emp2->plantilla_salary;
//     	$emp3->plantilla_date_from = $emp2->plantilla_date_from;
//     	$emp3->plantilla_date_to = $emp2->plantilla_date_to;
//     	$emp3->plantilla_remarks = $emp2->plantilla_remarks;
//     	$emp3->save();
//     }
// });

// Route::get('divisions', function () {
//     $emp = new App\Employee_division;
//     $emp = $emp->groupBy('username')->get();

//     // return $emp;
//     foreach($emp as $emps)
//     {
//     	$emp2 = new App\Employee_division;
//     	$emp2 = $emp2
//     			->where('username',$emps->username)
//     			->orderBy('emp_desig_from','desc')
//     			->first();

//     	// echo $emp2->username."-".$emp2->plantilla_date_from."<br/>";

//     	$emp3 = new App\User;
//     	$emp3 = $emp3->where('username', $emp2->username)
//           		     ->update(['division' => $emp2->division_id]);
//     }
// });

// Route::get('test', function () {
// 	return App\HRD_plan_staff::where('user_id',Auth::user()->id)->whereNull('submitted_at')->count();
// });

// Route::get('update-leave', function () {
//     $emp = App\User::get();

//     // return $emp;
//     foreach($emp as $emps)
//     {
//     	App\Employee_leave::where('empcode',$emps->username)
//           		     ->update(['user_id' => $emps->id]);
//     }
// });



//DOWNLOAD
Route::get('download-zip', 'ZipController@downloadZip');


/***********ATTENDANCE MONITORING***********/

//GET LEAVE PENDING
Route::get('dtr/terminal', 'AttendanceMonitoring\DTRController@terminal');
Route::get('dtr/icos/{mon}/{year}', 'AttendanceMonitoring\DTRController@icos');
Route::get('dtr/icos-month', 'AttendanceMonitoring\DTRController@icosmonth');

// Route::get('test', 'AttendanceMonitoring\RequestController@dt');

//GET LEAVE PENDING
Route::get('dtr/get-pending-leave/{id}', 'AttendanceMonitoring\LeaveController@getPending');
Route::get('dtr/cancel-leave/{id}', 'AttendanceMonitoring\LeaveController@cancelLeave');

//PDF REPORT
// Route::get('pdf/my-dtr/{date}', 'AttendanceMonitoring\PDFController@myDTR');
Route::post('pdf/my-dtr', 'AttendanceMonitoring\PDFController@myDTR');

//REQUEST FOR LEAVE/OT/TO
Route::post('request/{type}', 'AttendanceMonitoring\RequestController@index');
Route::get('dtr/request-leave', 'AttendanceMonitoring\LeaveController@request');
Route::post('dtr/send-leave-request', 'AttendanceMonitoring\LeaveController@send');
//TO
Route::get('dtr/request-for-to', 'AttendanceMonitoring\TOController@index');
Route::post('dtr/send-to-request', 'AttendanceMonitoring\TOController@send');

//OT
Route::get('dtr/request-for-ot', 'AttendanceMonitoring\OTController@index');
Route::post('dtr/send-ot-request', 'AttendanceMonitoring\OTController@send');

//DIRECTOR

//LEAVE/OT/TO FOR APPROVAL
Route::get('request-for-approval', 'AttendanceMonitoring\DirectorController@request');
Route::post('request-for-approval-submit', 'AttendanceMonitoring\DirectorController@approvedLeaveRequest');



//DTR MONITORING
// Route::get('dtr/monitoring/{mon}/{yr}/{userid}', 'AttendanceMonitoring\DTRController@monitor');
Route::post('dtr/monitoring', 'AttendanceMonitoring\DTRController@monitor');
Route::post('dtr/pdf', 'AttendanceMonitoring\DTRController@pdf');
Route::post('dtr/edit', 'AttendanceMonitoring\DTRController@edit');
Route::get('dtr/edit/{id}/{mon}/{yr}', 'AttendanceMonitoring\DTRController@edit2');
Route::get('change-password', 'AttendanceMonitoring\DTRController@password');
Route::post('change-password-send', 'HomeController@changepassword');
Route::post('dtr/icos/update', 'AttendanceMonitoring\DTRController@icosupdate');
Route::get('dtr/icos', 'AttendanceMonitoring\DTRController@icosindex');
Route::post('dtr/icos/wfh', 'AttendanceMonitoring\DTRController@icoswfh');

Route::get('dtr/employee', 'AttendanceMonitoring\DTRController@index');

Route::get('dtr/process/{mon}/{yr}', 'AttendanceMonitoring\DTRController@proccessdtr');




//LEAVE
// Route::post('cams/apply-leave', 'AttendanceMonitoring\LeaveController@apply');

// Route::get('test', function () {
//    $list = DB::select("SELECT id FROM Employee_icos_dtr WHERE division = '".Auth::user()->division."' GROUP BY division,MONTH(fldEmpDTRdate)");

// 	// $list = App\Employee_icos_dtr::get();
//     return $list;
// });

Route::get('monitor-dtr/EzUt1cg19i/{datedtr}', function ($datedtr) {

   //TOTAL ICOS + REGULAR
    $total_emp = App\User::where('employment_id',8)->count() + 300;

    //GET ICOS ATTENDANCE
    $total_icos = App\Employee_icos_dtr::where('fldEmpDTRdate',$datedtr)->whereNull('dtr_remarks')->count();

    //GET REGULAR ATTENDANCE
    $total_reg = App\Camsdtr::where('fldEmpDTRdate',$datedtr)->count();

    $percent = round(($total_icos + $total_reg) / $total_emp * 100);

    $data = [
    			'datedtr' => $datedtr,
    			'total_reg' => $total_reg,
    			'total_icos' => $total_icos,
    			'percent' => $percent,
    		];
   return view('monitor-dtr')->with('data',$data);
});






