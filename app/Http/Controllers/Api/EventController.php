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
use App\Models\Api\ApiEvent as Event;

class EventController extends Controller
{
    public function addEvent(Request $request)
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
				'title'    		=> ['required'],
				'description'   => ['required'],
				'longitude'    	=> ['required'],
				'latitude'    	=> ['required'],
				'address'    	=> ['required'],
				'startDateTime' => ['required'],
				'endDateTime'   => ['required'],
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
	            	$event  = Event::create([
											"title" 		=> $request->title,
											"description" 	=> $request->description,
											"longitude" 	=> $request->longitude,
											"latitude" 		=> $request->latitude,
											"address" 		=> $request->address,
											"startDateTime" => $request->startDateTime,
											"endDateTime" 	=> $request->endDateTime,
											"instituteId" 	=> $user->admin->instituteId,
										]);
	            	if($event)
	            	{
	            		// Add Event Mails ///////
                        //////////////////////////
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

    public function updateEvent(Request $request)
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
				'id'    		=> ['required'],
				'title'    		=> ['required'],
				'description'   => ['required'],
				'longitude'    	=> ['required'],
				'latitude'    	=> ['required'],
				'address'    	=> ['required'],
				'startDateTime' => ['required'],
				'endDateTime'   => ['required'],
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
	            	$event  = Event::where('id',$request->id)->update([
															"title" 		=> $request->title,
															"description" 	=> $request->description,
															"longitude" 	=> $request->longitude,
															"latitude" 		=> $request->latitude,
															"address" 		=> $request->address,
															"startDateTime" => $request->startDateTime,
															"endDateTime" 	=> $request->endDateTime,
														]);
	            	if($event)
	            	{
	            		// Update Event Mails ////
                        //////////////////////////
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

    public function viewEventDetail(Request $request)
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
				'id'    		=> ['required'],
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
	            	$event  = Event::find($request->id);

            		$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] 	= 200;
					$response['data']['result'] = $event;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            	// DB::rollBack();
	            }
	        }
		}
		return $response;
    }

    public function allEventsOfInstitute(Request $request)
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
				'id'    		=> ['required'],
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
	            	$events = Event::where('instituteId',$request->id)->get();

            		$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] 	= 200;
					$response['data']['result'] = $events;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            	// DB::rollBack();
	            }
	        }
		}
		return $response;
    }


    public function deleteEvent(Request $request)
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
				'id'    		=> ['required'],
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
	            	$event = Event::where('id',$request->id)->delete();

	            	if($event)
	            	{
	            		// Delete Event Mails //
                        //////////////////////////
	            		DB::commit();
	            		$response['data']['message'] = 'Request Successfull';
						$response['data']['code'] 	= 200;
						$response['status'] = true;
					}
					else
					{
						DB::rollBack();
						$response['data']['message'] = 'Request Unsuccessfull';
						$response['data']['code'] 	= 400;
						$response['status'] = true;
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
