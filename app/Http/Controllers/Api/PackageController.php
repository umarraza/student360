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
use App\Models\Api\ApiInstitute as Institute;
use App\Models\Api\ApiMyParent as MyParent;
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiParentStudent as ParentStudent;
use App\Models\Api\ApiParentInstitute as ParentInstitute;
use App\Models\Api\ApiPackage as Package;
use App\Models\Api\ApiPaymentHistory as PaymentHistory;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function listPackages(Request $request)
    {
        $response = [
		      	'data' => [
		          	'code' => 400,
		         	'message' => 'Something went wrong. Please try again later!',
		      	],
		     	'status' => false
		  	];
        try 
        {
            $packges = Package::all();

            $response['data']['message'] = 'Request Successfull';
            $response['data']['code'] = 200;
            $response['data']['result'] = $packges;
            $response['status'] = true;
        }
        catch (\Exception $e) 
        {
        }
        
        return $response;
    }

    public function packageDetail(Request $request)
    {
        $response = [
		      	'data' => [
		          	'code' => 400,
		         	'message' => 'Something went wrong. Please try again later!',
		      	],
		     	'status' => false
		  	];
	  	$rules = [
	     	'id' 			=>	'required',
	  	];
	  	$validator = Validator::make($request->all(), $rules);
	  	if ($validator->fails()) {
	    	$response['data']['message'] = 'Invalid input values.';
	      	$response['data']['errors'] = $validator->messages();
	  	}else
	  	{
	        try 
	        {
	            $packge = Package::find($request->id);

	            $response['data']['message'] = 'Request Successfull';
	            $response['data']['code'] = 200;
	            $response['data']['result'] = $packge;
	            $response['status'] = true;
	        }
	        catch (\Exception $e) 
	        {
	        }
	    }
        
        return $response;
    }

    public function updatePackage(Request $request)
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
		     	'id' 			=>	'required',
		     	'title' 		=>	'required',
		     	'description' 	=>	'required',
		     	'price' 		=>	'required',

		  	];
		  	$validator = Validator::make($request->all(), $rules);
		  	if ($validator->fails()) {
		    	$response['data']['message'] = 'Invalid input values.';
		      	$response['data']['errors'] = $validator->messages();
		  	}else
		  	{
		  		DB::beginTransaction();
	            try 
	            {
	                $package = Package::where('id','=',$request->id)->update([
                													"title" => $request->title,
                													"description" => $request->description,
                													"price" => $request->price,
                												]);
	                if($package)
	                {
	                	DB::commit();
		                $response['data']['message'] = 'Request Successfull';
		                $response['data']['code'] = 200;
		                $response['status'] = true;
		            }
		            else
		            {
		            	DB::rollBack();
		            }
	            }
	            catch (\Exception $e) 
	            {
	            	DB::rollBack();
	            }
	        }
        }
        return $response;
    }


    public function upgradePackage(Request $request)
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
		     	'instituteId' 	=>	'required',
		     	'packageId' 	=>	'required',
		    ];
		  	$validator = Validator::make($request->all(), $rules);
		  	if ($validator->fails()) {
		    	$response['data']['message'] = 'Invalid input values.';
		      	$response['data']['errors'] = $validator->messages();
		  	}else
		  	{
		  		DB::beginTransaction();
	            try 
	            {
	            	$institute 		= Institute::find($request->instituteId);
	            	$instituteAdmin	= Admin::where('instituteId',$institute->id)
	            							->where('type',0)
	            							->first();
	            	$adminUser = User::find($instituteAdmin->userId);
	                
	                if($adminUser->id == $user->id)
	                {
		                $packageDetail = Package::find($request->packageId);

		                $lastPaymentMade = Carbon::now()->format('Y-m-d H:i:s');

	                    if($packageDetail->unitType == 1)
	                    {
	                        $numberOfUnits   = $packageDetail->numberOfUnits;
	                        $nextPaymentDue = Carbon::now()->addDay($numberOfUnits)->format('Y-m-d H:i:s');
	                    }
	                    elseif($packageDetail->unitType == 2)
	                    {
	                        $numberOfUnits   = $packageDetail->numberOfUnits;
	                        $nextPaymentDue = Carbon::now()->addMonth($numberOfUnits)->format('Y-m-d H:i:s');
	                    }
	                    elseif($packageDetail->unitType == 3)
	                    {
	                        $numberOfUnits   = $packageDetail->numberOfUnits;
	                        $nextPaymentDue = Carbon::now()->addYear($numberOfUnits)->format('Y-m-d H:i:s');
	                    }
	                    
	                    $nextPaymentAmount = $packageDetail->price;
	                    $lastPaymentAmount = $packageDetail->price;

	                    $institute->packageId          = $packageDetail->id;
	                    $institute->lastPaymentMade    = $lastPaymentMade;
	                    $institute->nextPaymentDue     = $nextPaymentDue;
	                    $institute->nextPaymentAmount  = $nextPaymentAmount;
	                    $institute->lastPaymentAmount  = $lastPaymentAmount;

	                 
		                if($adminUser->makePayment($lastPaymentAmount))
		                {
		                	$paymentHistory = PaymentHistory::create([
		                										"paymentDateTime" => $lastPaymentMade,
		                										"amountPaid" 	  => $lastPaymentAmount,
		                										"instituteId" 	  => $institute->id,
		                									]);
		                	$institute->save();
		                	DB::commit();
			                $response['data']['message'] = 'Request Successfull';
			                $response['data']['code'] = 200;
			                $response['status'] = true;
			            }
			            else
			            {
			            	DB::rollBack();
			            }
			        }
	            }
	            catch (\Exception $e) 
	            {
	            	DB::rollBack();
	            }
	        }
        }
        return $response;
    }

    public function upgradePackage2(Request $request)
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
		     	'instituteId' 	=>	'required',
		     	'packageId' 	=>	'required',
		    ];
		  	$validator = Validator::make($request->all(), $rules);
		  	if ($validator->fails()) {
		    	$response['data']['message'] = 'Invalid input values.';
		      	$response['data']['errors'] = $validator->messages();
		  	}else
		  	{
		  		DB::beginTransaction();
	            try 
	            {
	            	$institute 		= Institute::find($request->instituteId);
	            	$instituteAdmin	= Admin::where('instituteId',$institute->id)
	            							->where('type',0)
	            							->first();
	            	$adminUser = User::find($instituteAdmin->userId);
	                
	                $packageDetail = Package::find($request->packageId);

                    $nextPaymentAmount = $packageDetail->price;
                    
                    $institute->packageId          = $packageDetail->id;
                    $institute->nextPaymentAmount  = $nextPaymentAmount;
                    
	                if($institute->save())
	                {
	                	DB::commit();
		                $response['data']['message'] = 'Request Successfull';
		                $response['data']['code'] = 200;
		                $response['status'] = true;
		            }
		            else
		            {
		            	DB::rollBack();
		            }
	            }
	            catch (\Exception $e) 
	            {
	            	DB::rollBack();
	            }
	        }
        }
        return $response;
    }
}
