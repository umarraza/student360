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
use App\Models\Api\ApiStudentInstitute as StudentInstitute;

use Hash;
use Carbon\Carbon;
use DateTime;


class PasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
	  	$response = [
	      	'data' => [
	          	'code' => 400,
	         	'message' => 'Something went wrong. Please try again later!',
	      	],
	     	'status' => false
	  	];
	  	$rules = [
	     	'userId' 		=> 	'required',
	     	'newPassword' 	=>	'required|string|min:5',
	     	'token' 		=>	'required',
	  	];
	  	$validator = Validator::make($request->all(), $rules);
	  	if ($validator->fails()) {
	    	$response['data']['message'] = 'Invalid input values.';
	      	$response['data']['errors'] = $validator->messages();
	  	}else
	  	{

	      	$user= User::find($request->userId);

	      	if(!empty($user))
	      	{
	      		DB::beginTransaction();
	      		try
	      		{
					if($user->resetPasswordToken==$request->token)
					{
						$start  = new DateTime($user->createdResetPToken);
						$end    = new DateTime(); //Current date time
						$diff   = $start->diff($end);

						if($diff->d<=0)
						{
							$user =  User::where('id', $request->get('userId'))
								            ->update([
								            	'password' => bcrypt($request->get('newPassword')),
								            	'resetPasswordToken' => Null,
								            ]); 
							if ($user) 
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
						else
						{
							$response['data']['message'] = 'Token expired';
							$response['data']['code'] = 400;
							$response['status'] = true;
						}

					}
					else
					{
						$response['data']['message'] = 'Invalid Token';
						$response['data']['code'] = 400;
						$response['status'] = true;
					}
				}
				catch (\Exception $e) 
	            {
	               DB::rollBack();
	            }
			}
			else
			{
				$response['data']['message'] = 'User Does not exist';
				$response['data']['code'] = 400;
				$response['status'] = true;
			}
	  	}
		return $response;
    }

    public function changePassword(Request $request)
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
		if(!empty($user) && $user->statusVerified())
		{
		  	$response = [
		      	'data' => [
		          	'code' => 400,
		         	'message' => 'Something went wrong. Please try again later!',
		      	],
		     	'status' => false
		  	];
		  	$rules = [
		     	'oldPassword' 	=>	'required|string|min:5',
		     	'newPassword' 	=>	'required|string|min:5',
		  	];
		  	$validator = Validator::make($request->all(), $rules);
		  	if ($validator->fails()) {
		    	$response['data']['message'] = 'Invalid input values.';
		      	$response['data']['errors'] = $validator->messages();
		  	}else
		  	{
		  		$oldPassword = $request->oldPassword;
		  		$newPassword = $request->newPassword;

	      		if(Hash::check($oldPassword, $user->password))
	      		{
	      			if($oldPassword != $newPassword)
	      			{
	      				DB::beginTransaction();
	      				try
	      				{
				      		$user =  User::where('id', $user->id)
								            ->update([
								            	'password' => bcrypt($newPassword),
								            ]); 
							if ($user) 
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
					else
					{
						$response['data']['message'] = 'Request Successfull';
						$response['data']['code'] = 401;
						$response['status'] = true;
					}
				}
				else
				{
					$response['data']['message'] = 'Your Old Password does not matach';
					$response['data']['code'] = 400;
					$response['status'] = true;
				}
		  	}
		}
		return $response;
    }

    public function changePasswordSignupTS(Request $request)
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
		if(!empty($user) && $user->statusVerified())
		{
		  	$response = [
		      	'data' => [
		          	'code' => 400,
		         	'message' => 'Something went wrong. Please try again later!',
		      	],
		     	'status' => false
		  	];
		  	$rules = [
		     	'password' 	=>	'required|string|min:5',
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
			  		$password = $request->password;

	  				$user =  User::where('id', $user->id)
						            ->update([
						            	'password' => bcrypt($password),
						            	'verified' => 1,
						            ]); 
					if ($user) 
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

    public function changePasswordSignupP(Request $request)
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
		if(!empty($user) && $user->statusVerified())
		{
		  	$response = [
		      	'data' => [
		          	'code' => 400,
		         	'message' => 'Something went wrong. Please try again later!',
		      	],
		     	'status' => false
		  	];
		  	$rules = [
		     	'password' 	=>	'required|string|min:5',
		     	'firstName'	=>	'required',
		     	'lastName' 	=>	'required',
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
			  		$password = $request->password;

	  				$modelUser =  User::where('id', $user->id)
						            ->update([
						            	'password' => bcrypt($password),
						            	'verified' => 1,
						            ]); 
					$parent = MyParent::where('userId',$user->id)
										->update([
							            	'firstName' => $request->firstName,
							            	'lastName' 	=> $request->lastName,
							            ]);
					if ($modelUser && $parent) 
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

    public function forgotPassword(Request $request)
    {

    	$response = [
	      	'data' => [
	          	'code' => 400,
	         	'message' => 'Something went wrong. Please try again later!',
	      	],
	     	'status' => false
		];
	  	$rules = [
	     	'username' => 'required',
	  	];
	  	$validator = Validator::make($request->all(), $rules);
	  	if ($validator->fails()) {
	    	$response['data']['message'] = 'Invalid input values.';
	      	$response['data']['errors'] = $validator->messages();
	  	}else
	  	{
    		$user= User::where('username','=',$request->username)
    					->where('isDeleted','=',0)
    					->first();
    		$name = "null";
	      	if(!empty($user))
	      	{
	      		if($user->verified)
		      	{
		      		DB::beginTransaction();
		      		try
		      		{
			      		if($user->roleId==2)
			      		{
			      			$name = $user->admin->firstName." ".$user->admin->lastName;
			      		}
			      		elseif($user->roleId==3)
			      		{
			      			$name = $user->trainer->firstName." ".$user->trainer->lastName;
			      		}
			      		else if($user->roleId==4)
			      		{
			      			$name = $user->parent->firstName." ".$user->parent->lastName;
			      		}
			      		else if($user->roleId==5)
			      		{
			      			$name = $user->student->firstName." ".$user->student->lastName;
			      		}
			      		else
			      		{
			      			$name="Super Admin";
			      		}

			      		//$token = bcrypt(rand ( 10000 , 100000 ));
			      		$token = md5(time() . $user->id . 'EM');
			      		$user->resetPasswordToken = $token;

			      		$now = Carbon::now();//->format('Y-m-d H:i:s');
			      		$user->createdResetPToken = $now;

						if ($user->save() && $user->sendEmailForgotPassword($token,$name)) 
						{
							DB::commit();
							$response['data']['message'] = 'If this email matches our records, we will email you password reset instructions.';
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
				else
				{
					$response['data']['message'] = 'If this email matches our records, we will email you password reset instructions.';
					$response['data']['code'] = 400;
					$response['status'] = true;
				}				
			}
			else
			{
				$response['data']['message'] = 'If this email matches our records, we will email you password reset instructions.';
				$response['data']['code'] = 400;
				$response['status'] = true;
			}
		}
		return $response;
	}
		
}
