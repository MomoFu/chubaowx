<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Temp ;

class PollController extends Controller
{
             public function GetRandStr($len) 
	{ 
	    $chars = array( 
	       "0", "1", "2",  "3", "4", "5", "6", "7", "8", "9" 
	    ); 
	    $charsLen = count($chars) - 1; 
	    shuffle($chars);   
	    $output = ""; 
	    for ($i=0; $i<$len; $i++) 
	    { 
	        $output .= $chars[mt_rand(0, $charsLen)]; 
	    }  
	    return $output;  
	} 


	    public function store(Request $request)
	{
		$validator = $this->validate($request, [
		        'phone_number' => ['required','regex:/^1(3[0-9]|5[012356789]|8[0256789]|7[0678])\d{8}$/','unique:users']
		 ]);
		$verify_code = $this->GetRandStr(4);
	 //  send the post to the server to ask for text message
		        $url = "http://ws2.cootekservice.com/auth/send_market_verification";
		        /*
		　　$data = array ("phone" => ($request->input('phone_number')) , "msg" => "您的验证码为：$verify_code。请在4分钟内完成验证。");
*/
		       $data = array("phone"=>($request->input('phone_number')), "msg"=>'' );
  		      $ch = curl_init($url);
  		      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  		      curl_setopt($ch, CURLOPT_POST, 1);
  		      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		       $output=curl_exec($ch);
		       curl_close($ch);
		 if (Temp::create(['phone_number'=>($request->input('phone_number')), 'verify_code'=>$verify_code]) ){
		 	return response()->json(array(
			            'status' => 1,
			            'msg' => $output,
			  ));
		 }
		 
		 else{
		 	return response()->json(array(
			            'status' => 0,
			            'msg' => 'cannot create'
			    ));
		 }	

	  
	}
	
}
