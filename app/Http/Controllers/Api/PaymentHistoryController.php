<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


//// JWT ////
use JWTAuthException;
use JWTAuth;

//// Models ////
use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiAdmin as Admin;
use App\Models\Api\ApiMyParent as MyParent;
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiParentStudent as ParentStudent;
use App\Models\Api\ApiParentInstitute as ParentInstitute;
use App\Models\Api\ApiPackage as Package;
use App\Models\Api\ApiPaymentHistory as PaymentHistory;

class PaymentHistoryController extends Controller
{
    public function listAllPayments(Request $request)
    {
    	$user = JWTAuth::toUser($request->token);
		$response = [
		      'data' => [
		          'code'      => 400,
		          'error'     => '',
		          'message'   => 'Invalid Token! User Not Found.',
		      ],
		      'status' => false
		  ];
		if(!empty($user)) 
		{
            try 
            {	
            	$paymentHistory = PaymentHistory::Join('institutes','institutes.id','=','payment_history.instituteId')
                                            ->select('institutes.name',
                                                     'payment_history.*')
                                            ->get();
				$response['data']['message'] = 'Request Successfull';
				$response['data']['code'] = 200;
				$response['data']['result'] = $paymentHistory;
				$response['status'] = true;
			}
			catch (\Exception $e) 
            {
            }
		}
		return $response;
    }

    public function listSpecificInstitutePaymentHistory(Request $request)
    {
    	$user = JWTAuth::toUser($request->token);
		$response = [
		      'data' => [
		          'code'      => 400,
		          'error'     => '',
		          'message'   => 'Invalid Token! User Not Found.',
		      ],
		      'status' => false
		  ];
		if(!empty($user)) 
		{
			$response = [
			    'data' => [
			        'code' => 400,
			        'message' => 'Something went wrong. Please try again later!',
			    ],
			   'status' => false
			];
			$rules = [
				'id'         => ['required'],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}
			else
			{
	            try 
	            {	
	            	$paymentHistory = PaymentHistory::Join('institutes','institutes.id','=','payment_history.instituteId')
                                                ->select('institutes.name',
                                                         'payment_history.*')
                                                ->where('institutes.id',$request->id)
                                                ->get();
					$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] = 200;
					$response['data']['result'] = $paymentHistory;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            }
	        }
		}
		return $response;
    }
}
