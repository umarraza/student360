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
use App\Models\Api\ApiAttendence as Attendence;


class AttendenceController extends Controller
{
    public function markAttendenceCheckin(Request $request)
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
				'qrCode'	  		=> ['required'],
				'checkInTime' 		=> ['required'],
				'attendenceDate'	=> ['required'],
				'instituteId'		=> ['required'],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}
			else
			{
				$student = Student::where('qrCode',$request->qrCode)->first();

				if(!empty($student))
				{
					$attendenceChecker = Attendence::where('attendenceDate',$request->attendenceDate)
													->where('instituteId',$request->instituteId)
													->where('studentId',$student->id)
													->first();
					if(empty($attendenceChecker))
					{
						DB::beginTransaction();
			            try 
			            {
			            	$event  = Attendence::create([
													"checkInTime"   	=> $request->checkInTime,
													"attendenceDate"	=> $request->attendenceDate,
													"instituteId"		=> $request->instituteId,
													"studentId" 		=> $student->id,
												]);
			            	if($event)
			            	{
			            		// Attendence Mark Mail //////////////////////////////////////
			            		markAttendence($student->id,$request->instituteId,$request->checkInTime,"Student Check In");
                        		//////////////////////////////////////////////////////////////
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
			        	$response['data']['message'] = 'Duplicate Entry';
			        	$response['data']['code'] = 400;
			        	$response['status'] = false;
			        }
		        }
		        else
		        {
		        	$response['data']['message'] = 'Invalid QRCODE';
		        	$response['data']['code'] = 400;
		        	$response['status'] = false;
		        }
	        }
		}
		return $response;
    }

    public function markAttendenceCheckout(Request $request)
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
				'qrCode'	  		=> ['required'],
				'checkOutTime' 		=> ['required'],
				'attendenceDate'	=> ['required'],
				'instituteId'		=> ['required'],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}
			else
			{
				$student = Student::where('qrCode',$request->qrCode)->first();

				if(!empty($student))
				{
					$attendenceChecker = Attendence::where('attendenceDate',$request->attendenceDate)
													->where('studentId',$student->id)
													->first();
					if(!empty($attendenceChecker))
					{
						if($attendenceChecker->checkOutTime==Null)
						{
							DB::beginTransaction();
				            try 
				            {

				            	$attendenceChecker->checkOutTime  = $request->checkOutTime; 
				            	
				            	if($attendenceChecker->save())
				            	{
				            		// Attendence Mark Mail //////////////////////////////////////
				            		markAttendence($student->id,$request->instituteId,$request->checkOutTime,"Student Check Out");
	                        		//////////////////////////////////////////////////////////////
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
				        	$response['data']['message'] = 'Duplicate Check Out entry';
				        	$response['data']['code'] = 400;
				        	$response['status'] = false;
				        }
			        }
			        else
			        {
			        	$response['data']['message'] = 'No Check In availabe for this day';
			        	$response['data']['code'] = 400;
			        	$response['status'] = false;
			        }
		        }
		        else
		        {
		        	$response['data']['message'] = 'Invalid QRCODE';
		        	$response['data']['code'] = 400;
		        	$response['status'] = false;
		        }
	        }
		}
		return $response;
    }


    public function getMonthAttendenceOfStudent(Request $request)
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
				'studentId'	  		=> ['required'],
				'instituteId'	  	=> ['required'],
				'month' 			=> ['required'],
				'year' 				=> ['required'],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}
			else
			{
				$attendenceChecker = Attendence::where('studentId',$request->studentId)
												->where('instituteId',$request->instituteId)
												->whereYear('attendenceDate', $request->year)
												->whereMonth('attendenceDate', $request->month)
												->get();

				$response['data']['message'] 	= 'Request Successfull';
				$response['data']['result'] 	= $attendenceChecker;
				$response['data']['code'] 		= 200;
				$response['status'] 			= true;
	        }
		}
		return $response;
    }


    public function getDailyAttendenceOfStudents(Request $request)
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
				'attendenceDate'	=> ['required'],
				'instituteId'		=> ['required'],
			];

			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) 
			{
			    $response['data']['message'] = 'Invalid input values.';
			    $response['data']['errors'] = $validator->messages();
			}
			else
			{
				// $attendenceChecker = Attendence::where('attendenceDate',$request->attendenceDate)
				// 								->where('instituteId',$request->instituteId)
				// 								->get();

				$attendenceChecker = Attendence::where('attendenceDate',$request->attendenceDate)
												->where('instituteId',$request->instituteId)
												->pluck('studentId');

				$parentStudents = Student::Join('daily_attendences','daily_attendences.studentId','=','students.id')
                                ->select('students.*',
                                        'daily_attendences.attendenceDate',
                           				'daily_attendences.checkInTime',
                           				'daily_attendences.checkOutTime'
                           				)
                                ->whereIn('students.id',$attendenceChecker)
                                ->where('daily_attendences.instituteId',$request->instituteId)
                                ->where('daily_attendences.attendenceDate',$request->attendenceDate)
                                ->get();
                $absentStudents = Student::whereNotIn('id',$attendenceChecker)->get();

				// $attendenceChecker = Student::leftJoin('daily_attendences','daily_attendences.studentId','=','students.id')
    //                             ->select('students.*',
    //                                     'daily_attendences.attendenceDate',
    //                        				'daily_attendences.checkInTime',
    //                        				'daily_attendences.checkOutTime'
    //                        				)
    //                             ->where('students.instituteId',$request->instituteId)
    //                             ->where('daily_attendences.attendenceDate',$request->attendenceDate)
    //                             ->get();

				$response['data']['message'] 			= 'Request Successfull';
				$response['data']['result']['present'] 	= $parentStudents;
				$response['data']['result']['absent'] 	= $absentStudents;
				$response['data']['code'] 				= 200;
				$response['status'] 					= true;
	        }
		}
		return $response;
    }
}
