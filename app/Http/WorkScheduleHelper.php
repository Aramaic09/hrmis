<?php
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
function CheckLateUnderTime()
{
	//CHECK ACTIVE SCHEME
	$scheme = collect(App\Duration::orderBy('id','DESC')->first());
	$scheme =  $scheme->all();

	$dtroption = collect(App\DTROption::where('id',$scheme['fldDTROptionID'])->first());

	return $dtroption->all();

}


function getOffset($id)
{
	$offset = collect(App\DTROffset::where('id',$id)->first());
	$offset = $offset->all();
	
}

function showActiveWS($type = null)
{
	$ws = App\View_work_schedule::orderBy('id','DESC')->first();

	switch ($type) {
		case 'desc':
				$col = 'fldDTROptDesc';
			break;
		
		default:
				$col = 'dtr_option_id';
			break;
	}
	return $ws[$col];
}