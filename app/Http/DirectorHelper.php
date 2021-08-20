<?php

function getRequestForApproval()
{
	if(Auth::user()->usertype == 'Director' && Auth::user()->division == 'O')
	{
		if(Auth::user()->usertype == 'Director')
			{
				$list = App\View_request_leave::whereIn('parent',['YES','NO'])->where('leave_action_status','Pending')
						->where(function($q) {
						          $q->where('division',Auth::user()->division)
						            ->orWhere('director', 'YES');
						      })
						->get();
			}
			else
			{
				$list = App\View_request_leave::whereIn('parent',['YES','NO'])->where('leave_action_status',"!=",'Processed')
						->where(function($q) {
						          $q->where('division',Auth::user()->division)
						            ->orWhere('director', 'YES');
						      })
						->get();
			}
	}
	else
	{
		if(Auth::user()->usertype == 'Director')
			{
				$list = App\View_request_leave::where('director','NO')->whereIn('parent',['YES','NO'])->where('leave_action_status','Pending')->where('division',Auth::user()->division)->get();
			}
			else
			{
				$list = App\View_request_leave::whereIn('parent',['YES','NO'])->where('leave_action_status',"!=",'Processed')->where('division',Auth::user()->division)->get();
			}
	}
	
	
	return $list;
}

function getRequestForTOApproval()
{

	if(Auth::user()->usertype == 'Director' && Auth::user()->division == 'O')
	{
		if(Auth::user()->usertype == 'Director')
			{
				$list = App\RequestTO::where('to_status','Pending')
						->where(function($q) {
						          $q->where('division',Auth::user()->division)
						            ->orWhere('director', 'YES');
						      })
						->get();
			}
			else
			{
				$list = App\RequestTO::where('to_status',"!=",'Processed')
					->where(function($q) {
						          $q->where('division',Auth::user()->division)
						            ->orWhere('director', 'YES');
						      })
					->get();
			}
	}
	else
	{
		if(Auth::user()->usertype == 'Director')
			{
				$list = App\RequestTO::where('director','NO')->where('to_status','Pending')->where('division',Auth::user()->division)->get();
			}
			else
			{
				$list = App\RequestTO::where('to_status',"!=",'Processed')->where('division',Auth::user()->division)->get();
			}
	}

	return $list;
}

function getRequestForOTApproval()
{
	if(Auth::user()->usertype == 'Director' && Auth::user()->division == 'O')
	{
		if(Auth::user()->usertype == 'Director')
		{
			$list = App\RequestOT::where('ot_status','Pending')
				->where(function($q) {
						          $q->where('division',Auth::user()->division)
						            ->orWhere('director', 'YES');
						      })
				->get();
		}
		else
		{
			$list = App\RequestOT::where('ot_status',"!=",'Processed')
					->where(function($q) {
						          $q->where('division',Auth::user()->division)
						            ->orWhere('director', 'YES');
						      })
					->get();
		}
	}
	else
	{
		if(Auth::user()->usertype == 'Director')
		{
			$list = App\RequestOT::where('director','NO')->where('ot_status','Pending')->where('division',Auth::user()->division)->get();
		}
		else
		{
			$list = App\RequestOT::where('ot_status',"!=",'Processed')->where('division',Auth::user()->division)->get();
		}
	}
	
	
	return $list;
}