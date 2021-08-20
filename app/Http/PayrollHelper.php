<?php

function getMembership($empcode)
{
	return App\Payroll\Membership::where('fldEmpCode',$empcode)->get();
}

function getPersonalLoans($empcode)
{
	return App\Payroll\PersonalLoan::where('fldEmpCode',$empcode)->get();
}

function getDeductions($empcode)
{
	return App\Payroll\Deduction::where('empCode',$empcode)->get();
}

function getCompensation($empcode)
{
	return App\Payroll\Compensation::where('empCode',$empcode)->get();
}

function getCompensation_rata($empcode,$cond)
{
	if($cond)
	{
		return App\Payroll\Compensation::where('empCode',$empcode)->whereIn('compID',[3,4])->get();
	}
	else
	{
		return App\Payroll\Compensation::where('empCode',$empcode)->whereNotIn('compID',[3,4])->get();
	}
	
}

function formatCash($val)
{
	if($val == 0 || $val == null || $val == "")
	{
		return 0;
	}
	else
	{
		return number_format($val,2);
	}
}

function getPlantillaInfo($empcode)
{
	$position = App\View_employee_position::where('username',$empcode)->orderBy('plantilla_date_to')->first();
	return $position;
}

function getLast($empcode)
{
	$position = App\Plantilla::where('username',$empcode)->orderBy('plantilla_date_to')->first();
	return $position;
}

function getPayrollList()
{
	$directories = Storage::disk('payroll')->directories();
	return $directories;
}

function getPayrollFileList($dir)
{
	$collection = collect([]);
    $filesInFolder = \File::files(storage_path('app/payroll/'.$dir));     
    foreach($filesInFolder as $path) { 
          $file = pathinfo($path);
          $collection->push($file['filename'] . '.' .$file['extension']);
     }

     return $collection->all();
}

function getSalaryWeek($username,$salary,$week)
{
	//GET COMPENSATION
	$total_comp = 0;
	foreach(getCompensation_rata($username,false) AS $values)
	{
		$total_comp += $values->compAmount;
	}

	$rata = 0;
	foreach(getCompensation_rata($username,true) AS $values)
	{
		$rata += $values->compAmount;
	}

	$total_deduc = 0;
	//GET LOANS
	foreach(getPersonalLoans($username) AS $values)
	{
		$total_deduc += $values->DED_AMOUNT;
	}
	//GET MANDA DEDUC
	foreach(getDeductions($username) AS $values)
	{
		$total_deduc += $values->deductAmount;
	}

	$amnet = ($salary + $total_comp) - $total_deduc;

	$a = number_format(($amnet/4), 2, ".", "");

	$tenths = 0;
	 $cents = 0;
	 $excess = 0;
	 $r_fmod = fmod($a, 10);
	 
	 if($r_fmod > 0){
	 	 //$cents = $a - floor($a);
		 $cents = fmod($a,1);
		 $floored = $a - $cents;
		 $tenths = fmod($floored, 10);
		 $excess = $tenths + $cents;
	 } else {
	 	 $tenths = 0;
		 $cents = 0;
		 $excess = 0;
	 }

	$amount1 = number_format($a - $excess, 2, ".", "");
	$amount2 = number_format($a - $excess, 2, ".", "");
	$amount3 = number_format($a - $excess, 2, ".", "");

	switch ($week) {
		case 1:
				return formatCash($amount1 + $rata);
		case 2:
		case 3:
				return formatCash($amount2);
			break;
		
		default:
				$amount4 = $amnet - $amount1 - $amount2 - $amount3;

				return formatCash($amount4);
			break;
	}
}

function getSalaryTbl()
{
	//GET LATEST FILE
	$salarytbl = App\SalaryTable::first();

	$salary = storage_path('app/salarysched/'.$salarytbl['salary_filename'].'.csv');
}