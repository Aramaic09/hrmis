<?php
use Illuminate\Support\Collection;

function getDTRMonitoring($div,$date)
{
	$collection = collect(App\Employee_dtr::where('division',$div)->where('fldEmpDTRdate',$date)->get());
	return $collection->all();
}

function checkIfProcess($userid,$mon,$yr)
{
	$dtr = App\DTRProcessed::where('userid',$userid)->where('dtr_mon',$mon)->where('dtr_year',$yr)->count();

	if($dtr > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function getDTRSummary($div,$mon,$yr)
{
	$summary = collect(App\DTRProcessed::where('dtr_division',$div)->where('dtr_mon',$mon)->where('dtr_year',$yr)->get());
	return $summary->all();

}

function formatNull($val)
{
	if($val <= 0)
	{
		return "-";
	}
	else
	{
		return $val;
	}
}

function getDirector2($div)
    {
        $division = App\Division::where('division_id',$div)->first();
        return $division['director'];
    }
function getAllLeave()
{
	$lv = collect(App\Leave_type::whereNotIn('id',[10,13,14,15])->get());
	return $lv->all();
}

function getTotalTardy($userid,$mon,$yr)
{
	// return $userid." ".$mon." ".$yr;
	
	$lwp = getLWP($userid,$mon,$yr);
	$lwp = explode("|", $lwp);

	return number_format((float)$lwp[1], 3, '.', '');
}

function getSummary($userid,$mon,$yr)
{
	$summary = collect(App\DTRProcessed::where('userid',$userid)->where('dtr_mon',$mon)->where('dtr_year',$yr)->get());
	return $summary;
}

function getLVSummary($leaveid,$userid,$mon,$yr)
{
	$prv_mon = $mon - 1;
	$yr = $yr;

	if($prv_mon == 0)
	{
		$prv_mon = 12;
		$yr = $yr - 1;
	}

	$col = "sl_bal";
	if($leaveid == 1)
	{
		$col = "vl_bal";
	}

	$summary = App\DTRProcessed::where('userid',$userid)->where('dtr_mon',$prv_mon)->where('dtr_year',$yr)->first();

	return $summary[$col];
}

function getLVDesc($id,$col)
{
	$lv = App\Leave_type::where('id',$id)->first();
	return $lv[$col];
}