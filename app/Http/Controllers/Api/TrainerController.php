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
use App\Models\Api\ApiTrainer as Trainer;
use App\Models\Api\ApiParentStudent as ParentStudent;
use App\Models\Api\ApiParentInstitute as ParentInstitute;

class TrainerController extends Controller
{
    public function addTrainer(Request $request)
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
			    'firstName'         => ['required'],
			    'lastName'          => ['required'],
			    'phoneNumber'       => ['required'],
			    'username'       	=> ['required', 'email', 'max:191', Rule::unique('users')],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}else
			{
				DB::beginTransaction();
	            try 
	            {	
	            	$trainerAvailability = Trainer::where('instituteId',$user->Admin->instituteId)->first();

	            	if(empty($trainerAvailability))
	            	{
		            	$rolesId = Roles::findByAttr('label',User::USER_TRAINER)->id;
		            	
		            	$password = '9146546';
		            	// First Enter Data in users Table
		            	$modelUser = User::create([
		            	    'username'  => $request->get('username'),
		            	    'password'  => bcrypt($password),
		            	    'roleId'    => $rolesId,
		            	    'verified'  => User::STATUS_INACTIVE,
		            	    'language'  => "English",
		            	]);

		            	$trainer = Trainer::create([
			  		        'userId'            => $modelUser->id,
			  		        'firstName'  		=> $request->get('firstName'),
			  		        'lastName'   		=> $request->get('lastName'),
			  		        'phoneNumber'   	=> $request->get('phoneNumber'),
			  		        'instituteId'  		=> $user->Admin->instituteId,
			  		    ]);

		            	$TFN = $trainer->firstName;
		            	$TLN = $trainer->lasName;
		            	$IN  =  $user->admin->name;


		            	// Traine Signup Mail ///////////
		            	trainerSignup($modelUser->id,$password);
		            	/////////////////////////////////
						//$modelUser->sendWellcomeTrainer($password,$TFN,$TLN,$IN);
						
						DB::commit();
						$response['data']['message'] = 'Request Successfull';
						$response['data']['code'] = 200;
						$response['status'] = true;
					}
					else
					{
						$response['data']['message'] = 'You can only add one trainer to you institute';
						$response['data']['code'] = 400;
						$response['status'] = false;
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

    public function updateTrainer(Request $request)
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
				'firstName'         => ['required'],
			    'lastName'          => ['required'],
			    'phoneNumber'       => ['required'],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}
			else
			{
				DB::beginTransaction();
	            try 
	            {	
	            	$trainer = Trainer::where('id',$user->trainer->id)->update([
						  		        'firstName'  		=> $request->get('firstName'),
						  		        'lastName'   		=> $request->get('lastName'),
						  		        'phoneNumber'   	=> $request->get('phoneNumber'),
						  		    ]);

					if($trainer)
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

    public function updateTrainerAdmin(Request $request)
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
				'id'         		=> ['required'],
				'firstName'         => ['required'],
			    'lastName'          => ['required'],
			    'phoneNumber'       => ['required'],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}
			else
			{
				DB::beginTransaction();
	            try 
	            {	
	            	$trainer = Trainer::where('id',$request->id)->update([
						  		        'firstName'  		=> $request->get('firstName'),
						  		        'lastName'   		=> $request->get('lastName'),
						  		        'phoneNumber'   	=> $request->get('phoneNumber'),
						  		    ]);

					if($trainer)
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

    public function listAllTrainersOfInstitute(Request $request)
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
	            	$trainers = Trainer::Join('users','users.id','=','trainers.userId')
                                                ->select('trainers.*',
                                                         'users.avatarFilePath')
                                                ->where('trainers.instituteId',$request->id)
                                                ->get();
					$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] = 200;
					$response['data']['result'] = $trainers;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            }
	        }
		}
		return $response;
    }

    public function getTrainerDetail(Request $request)
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
	            	$trainer = Trainer::Join('users','users.id','=','trainers.userId')
                                                ->select('trainers.*',
                                                         'users.avatarFilePath')
                                                ->where('trainers.id',$request->id)
                                                ->first();
					$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] = 200;
					$response['data']['result'] = $trainer;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            }
	        }
		}
		return $response;
    }

    public function deleteTrainer(Request $request)
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
	            DB::beginTransaction();
                try 
	            {	
	            	$trainer 	= Trainer::find($request->id);
	            	$userModel  = User::where('id',$trainer->userId)->update([
	            														"isDeleted" => 1,
	            														//"verified"  => 0,
	            													]);
	            	if($userModel)
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

    public function reactiveTrainer(Request $request)
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
	            DB::beginTransaction();
                try 
	            {	
	            	$trainer 	= Trainer::find($request->id);
	            	$userModel  = User::where('id',$trainer->userId)->update([
	            														"isDeleted" => 0,
	            														//"verified"  => 1,
	            													]);
	            	if($userModel)
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
