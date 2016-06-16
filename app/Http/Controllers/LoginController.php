<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User ;

use App\Temp ;

class LoginController extends Controller
{
    public function index(Request $request){
	$open_id = $request->input('open_id');
	if( $open_id  ){
		$me = User::where('open_id', $open_id)->first();
	
		if(!$me){
		 
			return view('login/register')->withOpenId($open_id);
		}
		else return view('login/already')->withMe($me);
	}
	else echo 'no open_id';
    }
    public function store(Request $request){
    	$this->validate($request, [
	        'phone_number' => ['required','regex:/^1(3[0-9]|5[012356789]|8[0256789]|7[0678])\d{8}$/','unique:users']
	 ]);
    	try{
    		$lastRecord = Temp::where('phone_number', $request->input('phone_number'))
	    	->orderBy('created_at', 'desc')
	               ->take(1)->get();
	               foreach ($lastRecord as $record)
		{
		    if( $request->input('verify_code')  != $record->verify_code  )
	                     	return redirect()->back()->withInput()->withErrors('verify wrong');
	                     else{
	                     	 if (User::create($request->all())) {
		           		// return redirect()->back();
	                     	 	return view('login/success')->withRecord($record);
		        	    } else {
		           		 return redirect()->back()->withInput()->withErrors('upload fail');
		       	   }		
	                     }
		}
		
	               return redirect()->back()->withInput()->withErrors('no record for the verify');
	                     
	             

	  } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	       return redirect()->back()->withInput()->withErrors('no record for the verify');
	   }
    	
               //->get();

              

              //print_r($lastRecord[0]->verify_code);

/*
	 if (User::create($request->all())) {
           		 return redirect()->back();
        	    } else {
           		 return redirect()->back()->withInput()->withErrors('upload fail');
       	   }		
*/		
    }
}
