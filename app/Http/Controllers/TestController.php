<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
       public function store(Request $request)
	{
	 //  print_r($request->all());
	   echo 'wuu';
	}
}
