<?php
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

function getLeaveDesc($id)
{
	$leave = App\Leave_type::where('id',$id)->first();
	return $leave['leave_desc'];
}

function formatRequestStatus($status)
{
	switch ($status) {
		case 'Pending':
				$cl = "badge-secondary";
			break;
		case 'Approved':
				$cl = "badge-success";
			break;
		case 'Disapproved':
				$cl = "badge-danger";
			break;
		default:
				$cl = "badge-success";
			break;
	}

	return "<span class='badge ".$cl."' style='font-size:15px'>".$status."</span>";
}

function checkRequest()
{
	// switch ($type) {
	// 	case 'Vacation Leave':
	// 	case 'Sick Leave':
	// 	case 'Emergency Leave':
	// 	case 'Privilege Leave':
	// 	case 'Force Leave':
	// 		# code...
	// 		break;
	// 	case 'C.T.O':
	// 		# code...
	// 		break;
	// 	case 'T.O':
	// 		# code...
	// 		break;
	// 	case 'O.T':
	// 		# code...
	// 		break;
	// }
	

	$collection = collect([]);

	//CHECK LEAVE
	$leaves = App\Request_leave::where('user_id',Auth::user()->id)->whereIn('parent',['YES','NO'])->where('leave_action_status','!=','Processed')->get();

	foreach ($leaves as $value) {
		# code...

		$request_date = date('F d, Y',strtotime($value->leave_date_from)) ."-".date('F d, Y',strtotime($value->leave_date_to));
		if($value->leave_date_from == $value->leave_date_to)
			$request_date = date('F d, Y',strtotime($value->leave_date_from));
		$collection->push([
							'request_desc' => getLeaveDesc($value->leave_id),
							'request_date' => $request_date,
							'request_action_status' => $value->leave_action_status
						  ]);
	}

	//CHECK T.O
	$tos = App\RequestTO::where('userid',Auth::user()->id)->whereNull('to_process')->get();

	foreach ($tos as $value) {
		# code...
		$collection->push([
							'request_desc' => "T.O",
							'request_date' => date('F d, Y',strtotime($value->to_date)),
							'request_action_status' => $value->to_status
						  ]);
	}

	//CHECK T.O
	$ots = App\RequestOT::where('userid',Auth::user()->id)->whereNull('ot_process')->get();

	foreach ($ots as $value) {
		# code...
		$collection->push([
							'request_desc' => "O.T",
							'request_date' => date('F d, Y',strtotime($value->ot_date)),
							'request_action_status' => $value->ot_status
						  ]);
	}

	return $collection->toArray();
}

function checkIfHoliday($dt)
{
	$dt = App\Holiday::where('holiday_date',date('Y-m-d',strtotime($dt)))->count();

	if($dt > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function checkIfHasLeave($dt)
{
	$dt = App\Request_leave::where('leave_date_from',date('Y-m-d',strtotime($dt)))->count();

	if($dt > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function ramdomCode($ctr)
{
	return Str::random($ctr);
}

function getDTRApprovedBy($id)
{
	$dt = App\Request_leave::where('id',$id)->first();
	return $dt['leave_action_by'];
}