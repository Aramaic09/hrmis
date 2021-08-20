<?php

function getDTR($d,$t,$daydesc,$user_id)
{
	$time = "-";
	$dtr = App\Employee_dtr::where('user_id',$user_id)->whereDate('dtr_date',$d)->first();
	switch ($t) {
		case 'am-in':
				if(isset($dtr['dtr_am_in']))
				{
					if($daydesc == "Mon")
					{
						if(strtotime($dtr['dtr_am_in']) > strtotime("8:00:59"))
						{
							$time = "<span style='color:red'><b>".date("g:i a",strtotime($dtr['dtr_am_in']))."</b></span>";
							// $time = date("g:i a",strtotime($dtr['dtr_am_in']));
						}
						else
						{
							$time = date("g:i a",strtotime($dtr['dtr_am_in']));
						}
					}
					else
					{
						if(strtotime($dtr['dtr_am_in']) > strtotime("8:30:59"))
						{
							$time = "<span style='color:red'><b>".date("g:i a",strtotime($dtr['dtr_am_in']))."</b></span>";
							// $time = date("g:i a",strtotime($dtr['dtr_am_in']));
						}
						else
						{
							$time = date("g:i a",strtotime($dtr['dtr_am_in']));
						}
					}
				}
				// if(isset($dtr['dtr_am_in']))
				// {
				// 	$time = date("g:i a",strtotime($dtr['dtr_am_in']));
				// }
				// else
				// {
				// 	$time = "-";
				// }
			break;
		case 'am-out':
				if(isset($dtr['dtr_am_out']))
				{
					$time = date("g:i a",strtotime($dtr['dtr_am_out']));
				}
			break;
		case 'pm-in':
				if(isset($dtr['dtr_pm_in']))
				{
					if(strtotime($dtr['dtr_pm_in']) > strtotime("13:00:59"))
						{
							$time = "<span style='color:red'><b>".date("g:i a",strtotime($dtr['dtr_pm_in']))."</b></span>";
							// $time = date("g:i a",strtotime($dtr['dtr_am_in']));
						}
						else
						{
							$time = date("g:i a",strtotime($dtr['dtr_pm_in']));
						}
				}
			break;
		case 'pm-out':
				if(isset($dtr['dtr_pm_out']))
				{
					$time = date("g:i a",strtotime($dtr['dtr_pm_out']));
				}
			break;
	}
	return $time;
}

function getPending($id)
{
	$ctr = App\Request_leave::whereNotNull('parent_leave')->where('user_id',Auth::user()->id)->where('leave_id',$id)->where('leave_action_status','!=','Processed')->get()->sum('leave_deduction');

	if($ctr == 0)
	{
		return 0;
	}
	else
	{
		return $ctr;
	}
}

function getProjectedLeave($leave,$pending)
{
	if($pending == "-")
	{
		$pending = 0;
	}

	if($leave == "-")
	{
		$leave = 0;
	}

	$total = $leave - $pending;
	
	if($total == 0)
	{
		return '-';
	}
	else
	{
		return $total;
	}

}

function getDisableDates()
{
	//HOLIDAYS
	$req = App\Holiday::get();
	foreach ($req as $reqs) {
		$data[] = array("date_desc" => $reqs->holiday_date);
	}

	//EXISTING LEAVES
	$req = App\Request_leave::where('user_id',Auth::user()->id)->get();
	foreach ($req as $reqs) {
		$data[] = array("date_desc" => $reqs->leave_date);
	}

	return $data;
}

function getDTRicos($d,$empcode)
{
	$dtr = App\Employee_icos_dtr::whereDate('fldEmpDTRdate',$d)->where('fldEmpCode',$empcode)->first();
	if($dtr)
	{
		return array("fldEmpDTRamIn" => formatTime($dtr['fldEmpDTRamIn']),"fldEmpDTRamOut" => formatTime($dtr['fldEmpDTRamOut']),"fldEmpDTRpmIn" => formatTime($dtr['fldEmpDTRpmIn']),"fldEmpDTRpmOut" => formatTime($dtr['fldEmpDTRpmOut']));
	}
	else
	{
		return array("fldEmpDTRamIn" => "","fldEmpDTRamOut" => "","fldEmpDTRpmIn" => "","fldEmpDTRpmOut" => "");
	}
	
}

function getDTRemp($d,$user_id,$employment_id)
{
	
	switch ($employment_id) {

		case 5:
		case 6:
		case 7:
		case 8:
				$dtr = App\Employee_icos_dtr::whereDate('fldEmpDTRdate',$d)->where('user_id',$user_id)->first();

				if($dtr)
				{
					return array("id" => $dtr['id'],"fldEmpDTRamIn" => $dtr['fldEmpDTRamIn'],"fldEmpDTRamOut" => $dtr['fldEmpDTRamOut'],"fldEmpDTRpmIn" => $dtr['fldEmpDTRpmIn'],"fldEmpDTRpmOut" => $dtr['fldEmpDTRpmOut'],"fldEmpDTRotIn" => $dtr['fldEmpDTRotIn'],"fldEmpDTRotOut" => $dtr['fldEmpDTRotOut'],"dtr_ot" => $dtr['dtr_ot'],"dtr_remarks" => $dtr['dtr_remarks'],"dtr_request" => $dtr['request'],"wfh" => $dtr['wfh'],"fldEmpDTRdate" => $dtr['fldEmpDTRdate'],"dtr_option_id" => $dtr['dtr_option_id']);
				}
				else
				{
					return array("id" => "","fldEmpDTRamIn" => "","fldEmpDTRamOut" => "","fldEmpDTRpmIn" => "","fldEmpDTRpmOut" => "","fldEmpDTRotIn" => "","fldEmpDTRotOut" => "", "dtr_ot" => "","dtr_remarks" => "","dtr_request" => "","wfh" => "","fldEmpDTRdate" => "","dtr_option_id" => "");
				}
			break;
		
		default:

				$dtr = App\Employee_dtr::whereDate('fldEmpDTRdate',$d)->where('user_id',$user_id)->first();

				if($dtr)
				{
					return array("id" => $dtr['id'],"fldEmpDTRamIn" => $dtr['fldEmpDTRamIn'],"fldEmpDTRamOut" => $dtr['fldEmpDTRamOut'],"fldEmpDTRpmIn" => $dtr['fldEmpDTRpmIn'],"fldEmpDTRpmOut" => $dtr['fldEmpDTRpmOut'],"fldEmpDTRotIn" => $dtr['fldEmpDTRotIn'],"fldEmpDTRotOut" => $dtr['fldEmpDTRotOut'],"dtr_ot" => $dtr['dtr_ot'],"dtr_remarks" => $dtr['dtr_remarks'],"dtr_request" => $dtr['request'],"wfh" => $dtr['wfh'],"fldEmpDTRdate" => $dtr['fldEmpDTRdate'],"dtr_option_id" => $dtr['dtr_option_id'],"request" => $dtr['request']);
				}
				else
				{
					return array("id" => "","fldEmpDTRamIn" => "","fldEmpDTRamOut" => "","fldEmpDTRpmIn" => "","fldEmpDTRpmOut" => "","fldEmpDTRotIn" => "","fldEmpDTRotOut" => "", "dtr_ot" => "","dtr_remarks" => "","dtr_request" => "","wfh" => "","fldEmpDTRdate" => "","dtr_option_id" => "","request" => "");
				}
			break;
	}	
}

function formatTime($t)
{
	if($t != null){
		return date("g:i", strtotime($t));
	}
	else
	{
		return null;
	}
}

function countTotalTime($amIn,$amOut,$pmIn,$pmOut,$ot,$otIn,$otOut,$dt,$day)
{
	// $amTotal = 0;
	// $pmTotal = 0;
	// $otTotal = 0;

	// $amTotal += countTotalTimeEach($dt,$amIn,$amOut);

	// $pmTotal += countTotalTimeEach($dt,$pmIn,$pmOut);

	// //CHECK IF HAS OT
	// if($ot)
	// {
	// 	$otTotal += countTotalTimeEach($dt,$otIn,$otOut);
	// }


	// $total = $amTotal + $pmTotal + $otTotal;

	// if($total != 0)
	// {
	// 	return $total;
	// }
	$notime = false;

	if($amIn == null && $amOut == null && $pmIn != null && $pmOut != null)
	{
		//PM
		$start_date2 = new DateTime($dt." ".$pmOut);
		$since_start2 = $start_date2->diff(new DateTime($dt."13:00:00"));
		$h2 = $since_start2->h;
		$min2 = $since_start2->i;

		$h1 = 0;
		$min1 = 0;
	}
	elseif($amIn != null && $amOut != null && $pmIn == null && $pmOut == null)
	{
		//AM
		$start_date1 = new DateTime($dt." ".$amIn);
		$since_start1 = $start_date1->diff(new DateTime($dt."12:00:00"));
		$h1 = $since_start1->h;
		$min1 = $since_start1->i;

		$h2 = 0;
		$min2 = 0;
	}
	elseif($amIn != null && $amOut != null && $pmIn != null && $pmOut != null)
	{
		$am = "12:00:00";
		$pm = "13:00:00";
		//AM
		$start_date1 = new DateTime($dt." ".$amIn);
		$since_start1 = $start_date1->diff(new DateTime($dt." ".$am));
		$h1 = $since_start1->h;
		$min1 = $since_start1->i;

		//PM
		$start_date2 = new DateTime($dt." ".$pmOut);
		$since_start2 = $start_date2->diff(new DateTime($dt." ".$pm));
		$h2 = $since_start2->h;
		$min2 = $since_start2->i;
	}
	else
	{
		$h1 = 0;
		$min1 = 0;
		$h2 = 0;
		$min2 = 0;
		$notime = true;
	}


	if(($min1 + $min2) >= 59)
		{
			$mintotal = ($min1 + $min2) - 59;
			$hrtotal = $h1 + $h2 + 1;
		}
		else
			{
				$mintotal = $min1 + $min2;
				$hrtotal = $h1 + $h2;
			}
	if($notime)
	{
		return null;
	}
	else
	{
		return $hrtotal."h ".$mintotal. "m";
	}
}

function countTotalTimeWeek($amIn,$amOut,$pmIn,$pmOut,$ot,$otIn,$otOut,$dt,$day,$ws)
{
	$notime = false;

	if($ws == 5 || $ws == 6 || $ws == 7)
	{
			return 8;
	}
	else
	{
		if($amIn == null && $amOut == null && $pmIn != null && $pmOut != null)
			{
				//PM
				$start_date2 = new DateTime($dt." ".$pmOut);
				$since_start2 = $start_date2->diff(new DateTime($dt."13:00:00"));
				$h2 = $since_start2->h;
				$min2 = $since_start2->i;

				$h1 = 0;
				$min1 = 0;
			}
			elseif($amIn != null && $amOut != null && $pmIn == null && $pmOut == null)
			{
				//AM
				$start_date1 = new DateTime($dt." ".$amIn);
				$since_start1 = $start_date1->diff(new DateTime($dt."12:00:00"));
				$h1 = $since_start1->h;
				$min1 = $since_start1->i;

				$h2 = 0;
				$min2 = 0;
			}
			elseif($amIn != null && $amOut != null && $pmIn != null && $pmOut != null)
			{
				$am = "12:00:00";
				$pm = "13:00:00";
				//AM
				$start_date1 = new DateTime($dt." ".$amIn);
				$since_start1 = $start_date1->diff(new DateTime($dt." ".$am));
				$h1 = $since_start1->h;
				$min1 = $since_start1->i;

				//PM
				$start_date2 = new DateTime($dt." ".$pmOut);
				$since_start2 = $start_date2->diff(new DateTime($dt." ".$pm));
				$h2 = $since_start2->h;
				$min2 = $since_start2->i;
			}
			else
			{
				$h1 = 0;
				$min1 = 0;
				$h2 = 0;
				$min2 = 0;
				$notime = true;
			}


			if(($min1 + $min2) >= 59)
				{
					$mintotal = ($min1 + $min2) - 59;
					$hrtotal = $h1 + $h2 + 1;
				}
				else
				{
						$mintotal = $min1 + $min2;
						$hrtotal = $h1 + $h2;
				}

			if($notime)
			{
				return null;
			}
			else
			{
				return number_format(($hrtotal + $mintotal), 2, '.', '');
			}

	}
}

function countTotalTimeEach($dt,$t1,$t2)
{
	$total = 0;
	if($t1 != null && $t2 != null)
		{
			// $time1 = strtotime($t1);
			// $time2 = strtotime($t2);
			// $difference = round(abs($time1 - $time2) / 3600,2);

			// if($difference != 0)
			// {
			// 	$total = $difference;
			// }
			$start_date = new DateTime($dt." ".$t1);
			$since_start = $start_date->diff(new DateTime($dt." ".$t2));

			$total =  $since_start->h.".".$since_start->i."".$since_start->s;
		}

	return round($total,2);
}


function countUndertime($dt,$day,$t1,$t2,$t3,$t4,$ws = null)
{	
//CHECK WORK SCHUDULE
// $ws = showActiveWS();
    switch ($ws) {
        case 5:
        case 6:
        case 7:
        	$undertime = null;
			$totalinmin = 0;
			return $undertime."|".$totalinmin;
        break;

        default:
        	if($t1 != null && $t2 != null && $t3 == null && $t4 == null)
				{
					$t1 = $t1;
					$t2 = $t2;
					$t = "08:30:00";

					if($day == 'Mon')
					{
						$t = "08:00:00";
					}

					if($t1 > $t)
					{
						$start_date = new DateTime("2021-03-17 ".$t);
						$since_start = $start_date->diff(new DateTime("2021-03-17 12:00:00"));
					}
					else
					{
						$start_date = new DateTime("2021-03-17 ".$t1);
						$since_start = $start_date->diff(new DateTime("2021-03-17 12:00:00"));
					}

					$h = 7 - $since_start->h;
					$m = 59 - $since_start->i;

					$undertime = $h."h ".$m."m ";
					$totalinmin = ($since_start->h * 60) + $since_start->i;

					return $undertime."|".$totalinmin;

				}
				elseif($t1 == null && $t2 == null && $t3 != null && $t4 != null)
				{
					$t1 = $t3;
					$t2 = $t4;
					$t = "13:00:00";

					if($t1 > $t)
					{
						$start_date = new DateTime("2021-03-17 ".$t);
						$since_start = $start_date->diff(new DateTime("2021-03-17 12:00:00"));
					}
					else
					{
						$start_date = new DateTime("2021-03-17 ".$t1);
						$since_start = $start_date->diff(new DateTime("2021-03-17 12:00:00"));
					}

					$h = 7 - $since_start->h;
					$m = 59 - $since_start->i;

					$undertime = $h."h ".$m."m ";
					$totalinmin = ($since_start->h * 60) + $since_start->i;

					return $undertime."|".$totalinmin;
				}
				elseif($t1 != null && $t2 != null && $t3 != null && $t4 != null)
				{
					$minpm = "16:30:00";
					$maxpm = "17:30:00";
					$maxam = "07:30:00";

					$t = "08:30:00";
					$t1 = $t1;
					$t2 = $t4;
					$undertime = "17:30:00";

					if($day == 'Mon')
					{
						$t = "08:00:00";
						$undertime = "17:00:00";
					}

					$hoursToAdd = 8;
					
					if($t1 > $t)
					{
						$undertime = $undertime;
					}
					else
					{
						
						$addtime = new DateTime($dt." ".$t1);
						$addtime->add(new DateInterval("PT{$hoursToAdd}H"));
						$undertime = $addtime->format('H:i:s');
						if($undertime < $minpm)
						{
							$undertime = $minpm;
						}
					}

					if($t2 < $undertime)
					{
						$start_date = new DateTime($dt." ".$t2);
						$since_start = $start_date->diff(new DateTime($dt." ".$undertime));
						$h = $since_start->h;
						$m = $since_start->i;

						$undertime = $since_start->h."h ".$since_start->i."m ";
						$totalinmin = ($since_start->h * 60) + $since_start->i;

						if($since_start->h == 0 && $since_start->i == 0)
						{
							$undertime = null;
							$totalinmin = 0;
						}

					}
					else
					{
						$undertime = null;
						$totalinmin = 0;
					}

					return $undertime."|".$totalinmin;
				}
				else
				{
					$undertime = null;
					$totalinmin = 0;
					return $undertime."|".$totalinmin;
				}
        break;
    }

	
}

function add_history_leave($userid,$leaveid,$tblid,$leavedate,$status)
{
	$history = new App\HistoryLeave;
	$history->user_id = $userid;
	$history->leave_id = $leaveid;
	$history->leave_tbl_id = $tblid;
	$history->leave_date = $leavedate;
	$history->leave_status = $status;
	$history->acted_by = Auth::user()->fname . ' ' . Auth::user()->lname;
	$history->save();

}

function add_to_leave($userid,$tblid,$todate,$status)
{
	$history = new App\HistoryTO;
	$history->user_id = $userid;
	$history->to_tbl_id = $tblid;
	$history->to_date = $todate;
	$history->to_status = $status;
	$history->acted_by = Auth::user()->fname . ' ' . Auth::user()->lname;
	$history->save();

}

function add_ot_leave($userid,$tblid,$otdate,$status)
{
	$history = new App\HistoryOT;
	$history->user_id = $userid;
	$history->ot_tbl_id = $tblid;
	$history->ot_date = $otdate;
	$history->ot_status = $status;
	$history->acted_by = Auth::user()->fname . ' ' . Auth::user()->lname;
	$history->save();

}

function checkIfIcos($userid)
{
	$user = App\User::where('id',$userid)->first();
        switch ($user['employment_id']) {
            case 5:
            case 6:
            case 7:
            case 8:
                	return true;
                break;
            
            default:
                	return false;
                break;
        }
}

function computeLate($dt,$d,$val,$ws = null)
{
	// $ws = showActiveWS();
    switch ($ws) {
        case 5:
        case 6:
        case 7:
        	return null;
        break;

        default:
        	if($val != null)
				{
					$tl = "08:30:00";

					if($d == 'Mon')
					{
						$tl = "08:00:00";
					}

					if($val > $tl)
					{
						$start_date = new DateTime($dt." ".$val);
						$since_start = $start_date->diff(new DateTime($dt." ".$tl));
						$totalinmin = ($since_start->h * 60) + $since_start->i;
						$tlates = $since_start->h."h ".$since_start->i."m<br/>|".$totalinmin;

						return $tlates;
					}
					else
					{
						return null;
					}
        break;
    }
	

		// $start_date = new DateTime($dt." ".$val);
		// $since_start = $start_date->diff(new DateTime($dt." ".$tl));
		// $totalinmin = ($since_start->h * 60) + $since_start->i;
		// $tlates = $since_start->h."h ".$since_start->i."m|".$totalinmin;

		// return $tlates;

		// $time1 = strtotime($tl);
		// $time2 = strtotime($val);
		// $difference = round(($time1 - $time2) / 60,2);

		// if($difference < 0)
		// {
		// 	return abs($difference);
		// }

	}
	
}

function checkDTRProcess($mon,$yr,$div)
    {
        $dtr = App\DTRProcessed::where('dtr_mon',$mon)->where('dtr_year',$yr)->where('dtr_division',$div)->first();

        if(isset($dtr))
        {
        	if($dtr['dtr_processed'] == 1)
	        {
	            return "YES";
	        }
	        else
	        {
	            return "NO";
        	}
        }
        else
        {
        	return "NO";
        }
        
    }
function checkPendingRequest($req,$mon,$year,$div)
    {
    	switch ($req) {
    		case 'Leave':
    				$request = App\Request_leave::where('leave_action_status','Pending')->whereMonth('leave_date',$mon)->whereYear('leave_date',$year)->where('user_div',$div)->count();
    			break;
    		case 'T.O':
    				$request = App\RequestTO::where('to_status','Pending')->whereMonth('to_date',$mon)->whereYear('to_date',$year)->where('division',$div)->count();
    			break;
    		default:
    				$request = App\RequestOT::where('ot_status','Pending')->whereMonth('ot_date',$mon)->whereYear('ot_date',$year)->where('division',$div)->count();
    			break;
    	}

    	if($request > 0)
    	{
    		return "Division has a pending ($request) for approval $req this ".date('F',mktime(0, 0, 0, $mon, 10))." ".$year."~false";
    	}
    	else
    	{
    		return "No Pending $req request for approval~true";
    	}

    	// echo $msg;
    }

function checkDTRStaff($mon,$yr,$div)
    {
        //GET ALL STAFF FIRST
        $staff = App\View_user::where('division',$div)->where('usertype','!=','Administrator')->orderBy('lname')->get();
        $staffarr = $staff->toArray();

        $msg = "";
        foreach ($staffarr as $staffs) 
        {
         	$mon = date('m',strtotime($mon));
	        $mon2 = date('F',mktime(0, 0, 0, $mon, 10));
	        $yr = $yr;
	        $date = $mon2 ."-" . $yr;
	        $month = ++$mon;

	        $tUndertime = null;

	        $tLates = null;

	        $totalAb = null;

	        $noentry = 0;

	        $noentry_msg = null;

	        $totanolates = 0;

	        $total = Carbon\Carbon::parse($date)->daysInMonth;
                      for($i = 1;$i <= $total;$i++)
                      {
                      		$dtr_date = date("Y-m-d",strtotime($yr.'-'.request()->mon.'-'.$i));

                            $dayDesc = weekDesc($dtr_date);

                            $dtr = getDTRemp($dtr_date,$staffs['id'],$staffs['employment_id']);


                            //UDERTIME
                            $under = null;
                            if(countUndertime($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_option_id']))
                            {
                                $undertime = explode("|", countUndertime($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_option_id']));
                                $under = $undertime[0];
                                $tUndertime += $undertime[1];
                            }

                            //LATES
                            $lates = null;
                            if(computeLate($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['dtr_option_id']))
                            {
                                $late = explode("|",computeLate($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['dtr_option_id']));
                                $lates = $late[0];
                                $tLates += $late[1];
                            }

                            switch ($dayDesc) {
                                case 'Sat':
                                case 'Sun':
                                    # code...
                                    break;
                                
                                default:
                                		if($dtr_date < date('Y-m-d'))
                                		{
                                			if($dtr['fldEmpDTRamIn'] == null && $dtr['fldEmpDTRamOut'] == null && $dtr['fldEmpDTRpmIn'] == null && $dtr['fldEmpDTRpmOut'] == null && $dtr['dtr_request'] == null)
	                                        {
	                                            $noentry++;
	                                            $noentry_msg .= $dtr_date." | ";
	                                        }
                                		}
                                        
                                    break;
                            }
                            
                             // $rows .=  "<tr><td style='width:10%'><span>".$i."</span><span style='float:right'>".$dayDesc."</span></td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRamIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRamOut'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRpmIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRpmOut'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRotIn'])."</td><td align='center' style='width:8%'>".formatTime($dtr['fldEmpDTRotOut'])."</td><td align='center' style='width:8%'>".countTotalTime($dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_ot'],$dtr['fldEmpDTRotIn'],$dtr['fldEmpDTRotOut'],$dtr_date,$dayDesc)."</td><td align='center' style='width:8%'>".$lates." ".$under."</td><td align='center'>".$dtr['dtr_remarks']."</td></tr>";

                             // checkEntry($dtr_date,);
                        
                      }
	        //DISPLAY LATES
	        $hourslate = floor($tLates / 60);
	        $minuteslate = $tLates % 60;

	        //DISPLAY UNDERTIME
	        $hoursunder = floor($tUndertime / 60);
	        $minutesunder = $tUndertime % 60;

	        //TOTAL DEDUCTION
	        //IF THERES AN ABSENT
	        $totalabsent = 0.000;
	        $hoursdeduc = 0.000;
	        $minutesdeduc = 0.000;
	        // $deducudhr = 0.000;
	        // $deducudmin = 0.000;

	        $totaldeduc = $tLates + $tUndertime;
	        $totaludlatededuc = 0.000;

	        if($totaldeduc == 60)
	        {
	        	$totaludlatededuc = 0.125;
	        }
	        elseif ($totaldeduc > 60) {
	        	//GET HOURS
	        	$hoursdeduc = floor($totaldeduc / 60);
	        	$hoursdeduc = $hoursdeduc * 0.125;

	        	$minutesdeduc = getLateDeduc($totaldeduc % 60);

	        	$totaludlatededuc = $hoursdeduc + $minutesdeduc;


	        }
	        elseif ($totaldeduc < 60) {
	        	$totaludlatededuc = getLateDeduc($totaldeduc);
	        	$totaludlatededuc = number_format((float)$totaludlatededuc, 3, '.', '');
	        }

	        if($noentry > 0)
	        {
	        	$lt = 8 * $noentry;
	        	$totalabsent = number_format((float)$noentry, 3, '.', '');
	        }

	        //CONVERT LATES/UNDERTIME HOURS
	        // $deduclatehr = $hourslate * 0.125;
	        // $deduclatehr = number_format((float)$deduclatehr, 3, '.', '');

	        // $deduclatemin  = getLateDeduc($minuteslate);
	        // $deduclatemin = number_format((float)$deduclatemin, 3, '.', '');

	        // //CONVERT LATES/UNDERTIME HOURS
	        // $deducudhr = $hoursunder * 0.125;
	        // $deducudhr = number_format((float)$deducudhr, 3, '.', '');

	        // $deducudmin  = getLateDeduc($minutesunder);
	        // $deducudmin = number_format((float)$deducudmin, 3, '.', '');
	        
	        $totaldeduction = $totalabsent + $totaludlatededuc;
	        $totaldeduction = number_format((float)$totaldeduction, 3, '.', '');

	        if($noentry > 0)
	        {
	        	$msg .= "<small><b>".$staffs['lname'].", ".$staffs['fname']. "</b> <span class='text-danger'>no entry</span> - ".$noentry_msg."<br/><b/>Total Lates : </b> ".$hourslate."h ".$minuteslate."m<br><b>Total Undertime : </b>".$hoursunder."h ".$minutesunder."m<br><b>Total Deduction : </b>".$totaldeduction."</small><br><br>";
	        }
         }

        echo $msg;
    }

    function getLateDeduc($min)
    {
    	switch (true) {
    		case ($min >= 1 && $min <= 4):
    			$x = ".00" . ($min * 2);
    			return $x;
    		case ($min >= 5 && $min <= 18):
    			$x = ".0" . (($min * 2) + 1);
    			return $x;
    		case ($min >= 19 && $min <= 30):
    			$x = ".0" . (($min * 2) + 2);
    			return $x;
    		case ($min >= 31 && $min <= 42):
    			$x = ".0" . (($min * 2) + 3);
    			return $x;
    		case ($min >= 31 && $min <= 42):
    			$x = ".0" . (($min * 2) + 4);
    			return $x;
    		case ($min >= 43 && $min <= 47):
    			$x = ".0" . (($min * 2) + 4);
    			return $x;
    		case ($min >= 48 && $min <= 54):
    			$x = "." . (($min * 2) + 4);
    			return $x;
    		case ($min >= 55 && $min <= 59):
    			$x = "." . (($min * 2) + 5);
    			return $x;
    		break;

    	}
    }

    function getLWP($userid,$mon,$yr)
    {
    	$dtr = collect(App\Employee_dtr::where('user_id',$userid)->whereMonth('fldEmpDTRdate',$mon)->whereYear('fldEmpDTRdate',$yr)->get());
    	
    	//COUNTER
    	$lwp = 0;

    	//GET ALL DAYS A MONTH
    	$month = date('F',mktime(0, 0, 0, $mon, 10));
    	$date = $month ."-" . $yr;

    	$tUndertime = null;
		$tLates = null;

		$totalnolates = 0;
		$totalhrs = 0;
		$totalhrsneeded = 0.0;

    	$total = Carbon\Carbon::parse($date)->daysInMonth;
        
        for($i = 1;$i <= $total;$i++)
        	{
        		$dtr_date = date("Y-m-d",strtotime($yr.'-'.request()->mon.'-'.$i));
				$dayDesc = weekDesc($dtr_date);
				$dtr = getDTRemp($dtr_date,$userid,1);

				

				//UDERTIME
                $under = null;
                if(countUndertime($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_option_id']))
                {
                    $undertime = explode("|", countUndertime($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_option_id']));
                    $under = $undertime[0];
                    $tUndertime += $undertime[1];
                }

                //LATES
                $lates = null;
                if(computeLate($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['dtr_option_id']))
                {
                    $late = explode("|",computeLate($dtr_date,$dayDesc,$dtr['fldEmpDTRamIn'],$dtr['dtr_option_id']));
                    $lates = $late[0];
                    $tLates += $late[1];

                    if($tLates > 0)
                    {
                    	$totalnolates++;
                    }
                }

				switch ($dayDesc) {
                    case 'Sat':
                    case 'Sun':
                        # code...
                        break;
                    
                    default:
                      $totalhrsneeded += checkvaliddate($dtr_date);

                      if($dtr_date < date('Y-m-d'))
                      {
                       if($dtr['fldEmpDTRamIn'] == null && $dtr['fldEmpDTRamOut'] == null && $dtr['fldEmpDTRpmIn'] == null && $dtr['fldEmpDTRpmOut'] == null && $dtr['dtr_request'] == null)
	                            {
	                                $lwp++;
	                            }
	                    $totalhrs += countTotalTimeWeek($dtr['fldEmpDTRamIn'],$dtr['fldEmpDTRamOut'],$dtr['fldEmpDTRpmIn'],$dtr['fldEmpDTRpmOut'],$dtr['dtr_ot'],$dtr['fldEmpDTRotIn'],$dtr['fldEmpDTRotOut'],$dtr_date,$dayDesc,$dtr['dtr_option_id']);
                      }
                                        
                    break;
                }

               
        	}
        	//DISPLAY LATES
	        $hourslate = floor($tLates / 60);
	        $minuteslate = $tLates % 60;

	        //DISPLAY UNDERTIME
	        $hoursunder = floor($tUndertime / 60);
	        $minutesunder = $tUndertime % 60;

        	$totalabsent = 0.000;
	        $hoursdeduc = 0.000;
	        $minutesdeduc = 0.000;
	        // $deducudhr = 0.000;
	        // $deducudmin = 0.000;

	        $totaldeduc = $tLates + $tUndertime;
	        $totaludlatededuc = 0.000;

	        //LATE AND UNDERTIME
	        $lateunderhr = floor($totaldeduc / 60);
	        $lateundermin = $totaldeduc % 60;

	        if($totaldeduc == 60)
	        {
	        	$totaludlatededuc = 0.125;
	        }
	        elseif ($totaldeduc > 60) {
	        	//GET HOURS
	        	$hoursdeduc = floor($totaldeduc / 60);
	        	$hoursdeduc = $hoursdeduc * 0.125;

	        	$minutesdeduc = getLateDeduc($totaldeduc % 60);

	        	$totaludlatededuc = $hoursdeduc + $minutesdeduc;


	        }
	        elseif ($totaldeduc < 60) {
	        	$totaludlatededuc = getLateDeduc($totaldeduc);
	        	$totaludlatededuc = number_format((float)$totaludlatededuc, 3, '.', '');
	        }



        	// return number_format((float)$ctr, 2, '.', '');
        	return $lwp."|".$totaludlatededuc."|Total Lates : <b> ".$hourslate."h ".$minuteslate."m</b><br>Total Undertime : <b>".$hoursunder."h ".$minutesunder."m</b>|".$hourslate."|".$minuteslate."|".$hoursunder."|".$minutesunder."|".$totalnolates."|".$lateunderhr."|".$lateundermin ."|".$totalhrsneeded."|".$totalhrs;
    }

    function getLWPCount($i)
    {
    	$collection = collect(["0" => 1.250,"0.5" => 1.229,"1" => 1.208,"1.5" => 1.188,"2" => 1.167,"2.5" => 1.146,"3" => 1.125,"3.5" => 1.104,"4" => 1.083,"4.5" => 1.063,"5" => 1.042,"5.5" => 1.021,"6" => 1.000,"6.5" => 0.979,"7" => 0.958,"7.5" => 0.938,"8" => 0.917,"8.5" => 0.896,"9" => 0.875,"9.5" => 0.854,"10" => 0.833,"10.5" => 0.813,"11" => 0.792,"11.5" => 0.771,"12" => 0.750,"12.5" => 0.729,"13" => 0.708,"13.5" => 0.687,"14" => 0.667,"14.5" => 0.646,"15" => 0.625,"15.5" => 0.604,"16" => 0.583,"16.5" => 0.562,"17" => 0.542,"17.5" => 0.521,"18" => 0.500,"18.5" => 0.479,"19" => 0.458,"19.5" => 0.437,"20" => 0.417,"20.5" => 0.396,"21" => 0.375,"21.5" => 0.354,"22" => 0.333,"22.5" => 0.312,"23" => 0.292,"23.5" => 0.271,"24" => 0.250,"24.5" => 0.229,"25" => 0.208,"25.5" => 0.208,"26" => 0.167,"26.5" => 0.146,"27" => 0.125,"27.5" => 0.104,"28" => 0.083,"28.5" => 0.062,"29" => 0.042,"29.5" => 0.021,"30" => 0.000]);

    	return $collection->pull($i);
    	// return $collection->all();
    }

    function countLWP($userid,$mon,$yr)
    {
    	// return App\Request_leave::where('user_id',$userid)->whereNull('parent')->whereNull('leave_processed')->whereMonth('leave_date_from',$mon)->whereYear('leave_date_from',$yr)->get()->sum('leave_deduction');
    	return App\Request_leave::where('user_id',$userid)->whereIn('parent',['NO',null])->where('lwop','YES')->whereMonth('leave_date_from',$mon)->whereYear('leave_date_from',$yr)->get()->sum('leave_deduction');
    }

    function getLWPArray($i)
    {
    	$collection = collect(["0" => 1.250,"0.5" => 1.229,"1" => 1.208,"1.5" => 1.188,"2" => 1.167,"2.5" => 1.146,"3" => 1.125,"3.5" => 1.104,"4" => 1.083,"4.5" => 1.063,"5" => 1.042,"5.5" => 1.021,"6" => 1.000,"6.5" => 0.979,"7" => 0.958,"7.5" => 0.938,"8" => 0.917,"8.5" => 0.896,"9" => 0.875,"9.5" => 0.854,"10" => 0.833,"10.5" => 0.813,"11" => 0.792,"11.5" => 0.771,"12" => 0.750,"12.5" => 0.729,"13" => 0.708,"13.5" => 0.687,"14" => 0.667,"14.5" => 0.646,"15" => 0.625,"15.5" => 0.604,"16" => 0.583,"16.5" => 0.562,"17" => 0.542,"17.5" => 0.521,"18" => 0.500,"18.5" => 0.479,"19" => 0.458,"19.5" => 0.437,"20" => 0.417,"20.5" => 0.396,"21" => 0.375,"21.5" => 0.354,"22" => 0.333,"22.5" => 0.312,"23" => 0.292,"23.5" => 0.271,"24" => 0.250,"24.5" => 0.229,"25" => 0.208,"25.5" => 0.208,"26" => 0.167,"26.5" => 0.146,"27" => 0.125,"27.5" => 0.104,"28" => 0.083,"28.5" => 0.062,"29" => 0.042,"29.5" => 0.021,"30" => 0.000]);

    	return $collection->pull($i);
    	// return $collection->all();
    }

    function getLeaveInfo($id)
    {
    	$collection = collect(App\Leave_type::get());

    	foreach ($collection as $leave) {
    		if($leave->id == $id)
    		{
    			return $leave->leave_desc;
    		}
    	}
    }

    function checkIfHasReq($userid,$leaveid,$mon,$yr,$val)
    {
    	// $collection = collect(App\Request_leave::where('user_id',$userid)->where('leave_id',$leaveid)->whereMonth('leave_date',$mon)->whereYear('leave_date',$yr)->whereNull(''))
    }

    function getWarning($valid,$time,$ws = null)
    {
    	// return $ws;
    	
    	$alert = "";
    	if(isset($time))
    	{
    		return $time;
    	}
    	else
    	{	
    		if(isset($valid))
    		{
    			return $time;
    		}
    		else
    		{
    			//CHECK WORKSCHDULE
    			// $ws = showActiveWS();
    			switch ($ws) {
    				case 1:
    				case 2:
    				case 3:
    				case 4:
    						$alert = "<i class='fas fa-exclamation-circle text-danger'></i>";
    					break;
    			}
    		}
    		return $alert;
    	}


    }

    function checkifNull($time)
    {
    	if(isset($time))
    	{
    		return $time;
    	}
    	else
    	{
    		return null;
    	}
    }

    function countNoEntry($userid,$mon,$yr,$exe)
    {
    	if($exe == 1)
    	{
    		return null;
    	}
    	else
    	{
    		$collection = collect();

	    	$month = date('F',mktime(0, 0, 0, $mon, 10));
	    	$date = $month ."-" . $yr;

	    	$noentry = 0;

	    	$total = Carbon\Carbon::parse($date)->daysInMonth;
	    	for($i = 1;$i <= $total;$i++)
	        	{
	        		$dtr_date = date("Y-m-d",strtotime($yr.'-'.request()->mon.'-'.$i));

	        		$dtr = App\Employee_dtr::where('user_id',$userid)->where('fldEmpDTRdate',$dtr_date)->first();

	        		$dayDesc = weekDesc($dtr_date);

	        		switch ($dayDesc) {
	                    case 'Sat':
	                    case 'Sun':
	                        # code...
	                        break;
	                    
	                    default:
	                      if($dtr_date < date('Y-m-d'))
	                      {
	                       if(!isset($dtr))
				        		{
				        			$collection->push($dtr_date);
				        		}
	                      }
	                                        
	                    break;
	                }
	        	}

	        	$noentry = $collection->count();

		    	if($noentry > 0)
		    	{
		    		return "<span class='badge badge-danger' style='cursor:pointer' onclick='showNoEntry(\"".$collection->implode(',')."\")'>".$noentry."</span>";
		    	}
		    	else
		    	{
		    		return null;
		    	}
    	}
    	
    }


    function getPendingRequest($type,$userid,$mon,$yr)
    {
    	$collection = collect();
    	switch ($type) {
    		case 'leave':
    				$req = App\Request_leave::whereNotNull('parent')->where('user_id',$userid)->where('leave_action_status','Pending')->whereMonth('leave_date_from',$mon)->whereYear('leave_date_from',$yr)->get();
    				if(isset($req))
    				{
    					foreach ($req as $key => $value) {
    						if($value->parent == 'YES')
    						{
    							$collection->push("LEAVE - ".formatDateRead($value->leave_date_from) . " - " . formatDateRead($value->leave_date_to));
    						}
    						else
    						{
    							$collection->push("LEAVE - ".formatDateRead($value->leave_date_from));	
    						}
    						
    					}
    				}
    			break;
    		
    		case 't.o':
    				$req = App\RequestTO::where('userid',$userid)->where('to_status','Pending')->whereMonth('to_date',$mon)->whereYear('to_date',$yr)->get();
    				if(isset($req))
    				{
    					foreach ($req as $key => $value) {
    						$collection->push("T.O - ".formatDateRead($value->to_date));
    					}
    				}
    			break;

    		case 'o.t':
    				$req = App\RequestOT::where('userid',$userid)->where('ot_status','Pending')->whereMonth('ot_date',$mon)->whereYear('ot_date',$yr)->get();
    				if(isset($req))
    				{
    					foreach ($req as $key => $value) {
    						$collection->push("O.T - ".formatDateRead($value->ot_date));
    					}
    				}
    			break;
    	}

    	return $collection->all();
    }

    function formatDateRead($dt)
    {
    	return date('F d, Y',strtotime($dt));
    }
    

    function covertDurationNum($leaves,$dd)
    {
    	switch ($dd) {
                case 'wholeday':
                        $deduc = 1;
                    break;
                default:
                        $deduc = 0.5;
                    break;
            }
        $remaining = $leave - $deduc;

        if($remaining > 0)
        {
        	return "YES";
        }
        else
        {
        	return "NO";
        }
    }

function countDiffLeave($leaves,$dd)
{
    switch ($dd) {
                case 'wholeday':
                        $deduc = 1;
                    break;
                default:
                        $deduc = 0.5;
                    break;
            }

    $remain = $leaves - $deduc;
    if($remain < 0)
    {
        return 'YES';
    }
    else
    {
        return 'NO';
    }
}


function getLeave($userid,$deduc,$mon,$yr)
    {

        $collection = collect(App\Request_leave::where('user_id',$userid)->where('leave_deduction',$deduc)->whereMonth('leave_date_from',$mon)->whereYear('leave_date_from',$yr)->where('leave_action_status','!=','Pending')->get());

        return $collection->all();
    }

function getLeave2($userid,$mon,$yr)
    {

        $collection = collect($ctr = App\Request_leave::whereNotNull('parent')->where('user_id',$userid)->whereMonth('leave_date_from',$mon)->whereYear('leave_date_from',$yr)->where('leave_action_status','Processed')->get());

        return $collection->all();
    }


function getBalance($type,$leaveid,$userid,$mon,$yr)
    {

        if($type == 'begin')
        {
        	$sort = 'DESC';
        }
        else
        {
            $sort = 'ASC';
        }

        $bal = App\Employee_leave::where('user_id',$userid)->where('leave_id',$leaveid)->whereMonth('created_at',$mon)->whereYear('created_at',$yr)->orderBy('created_at',$sort)->first();

        // return $bal;

        if(isset($bal['leave_bal']))
        {
        	return $bal['leave_bal'];
        }
        else
        {
        	return null;
        }
        
    }

function getLastDTRProcess($userid)
{
	$dtr = App\DTRProcessed::where('user_id',$userid)->orderBy('id','DESC')->first();
	return $dtr['dtr_mon'] . '-' . $dtr['dtr_year'];
}

function checkvaliddate($dt)
{
	//CHECK IF HOLIDAY
	$holiday = App\Holiday::whereDate('holiday_date',$dt)->count();
	if($holiday == 0)
	{
		//CHECK IF SUSPENDED
		$suspension = App\Suspension::whereDate('fldSuspensionDate',$dt)->first();
		if(!isset($suspension))
			{
				return 8;
			}
			else
			{
				return $suspension['fldMinHrs'];
			}
	}
	else
	{
		return 0;
	}
	
}