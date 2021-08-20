<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class JSON extends Controller
{
    public function index()
    {
    	return view('sample');
    }

    public function list($yr,$mon)
    {
    	if($mon == 'all')
    	{
    		$test = App\Plantilla::whereYear('plantilla_date_from',$yr)->get();
    	}
    	else
    	{
    		$test = App\Plantilla::whereYear('plantilla_date_from',$yr)->whereMonth('plantilla_date_from',$mon)->get();	
    	}
    	
    	return json_encode($test);
    }
}
