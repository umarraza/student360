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


class StudentController extends Controller
{
	// Get Students
    public function addStudent(Request $request)
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
		        	'error' => 400,
		         	'message' => 'Something went wrong. Please try again later!',
		      	],
		     	'status' => false
		  	];
		  	$rules = [
		     	'studentFirstName' 	=> 'required',
		     	'studentLastName' 	=> 'required',
		     	'studentAge' 		=> 'required',
		     	'studentCode' 		=> 'required',
		     	'parentUserName' 	=> 'required',
		    ];
		  	$validator = Validator::make($request->all(), $rules);
		  	if ($validator->fails()) {
		    	$response['data']['message'] = 'Invalid input values.';
		    	$response['data']['errors'] = $validator->messages();
		  	}else
		  	{
		  		$checkStudent = Student::where('studentCode',$request->studentCode)->first();


		  		if(empty($checkStudent))
		  		{
		  			DB::beginTransaction();
			  		try 
			  		{
			  			$rolesIdStudent = Roles::findByAttr('label',User::USER_STUDENT)->id;
			  		    $rolesIdParent 	= Roles::findByAttr('label',User::USER_PARENT)->id;
			  		    
			  		    $password = "987453";
			  		    // First Enter Data in users Table
			  		    $userStudent = User::create([
			  		        'username'  => $request->get('studentCode')."_".$request->get('parentUserName'),
			  		        'password'  => bcrypt($password),
			  		        'roleId'    => $rolesIdStudent,
			  		        'verified'  => User::STATUS_ACTIVE,
			  		        'language'  => "English",
			  		    ]);

			  		    $student = Student::create([
			  		        'userId'            => $userStudent->id,
			  		        'firstName'  		=> $request->get('studentFirstName'),
			  		        'lastName'   		=> $request->get('studentLastName'),
			  		        'age'   			=> $request->get('studentAge'),
			  		        'studentCode'   	=> $request->get('studentCode'),
			  		        'qrCode'   			=> $request->get('studentCode'),
			  		        'qrPath'   			=> $request->get('studentCode').".png",
			  		        'instituteId'  		=> $user->Admin->instituteId,
			  		    ]);


				  		$checkParent = User::where('username',$request->parentUserName)->first();
				  		if(empty($checkParent))
				  		{
				  			$userParent = User::create([
				  		        'username'  => $request->get('parentUserName'),
				  		        'password'  => bcrypt($password),
				  		        'roleId'    => $rolesIdParent,
				  		        'verified'  => User::STATUS_ACTIVE,
				  		        'language'  => "English",
				  		    ]);

				  		    $parent = MyParent::create([
				  		        'userId'            => $userParent->id,
				  		    ]);

				  		    $parentInstitute = ParentInstitute::create([
				  		        'parentId'          => $parent->id,
				  		        'instituteId'  		=> $user->Admin->instituteId,
				  		    ]);
				  		}
				  		else
				  		{
				  			$parent = MyParent::where('userId',$checkParent->id)->first();
				  			$userParent = User::find($checkParent->id);

				  			$checkParentInstitute = ParentInstitute::where('parentId',$parent->id)
				  											->where('instituteId',$user->Admin->instituteId)
				  											->first();
				  			if(empty($checkParentInstitute))
				  			{
				  				$parentInstitute = ParentInstitute::create([
					  		        'parentId'          => $parent->id,
					  		        'instituteId'  		=> $user->Admin->id,
					  		    ]);
				  			}
				  			
				  		}

			  		    $parentStudent = ParentStudent::create([
			  		        'parentId'          => $parent->id,
			  		        'studentId'  		=> $student->id,
			  		    ]);

			  		    $IN  =  $user->admin->name;
			  		    $SFN =  $student->firstName;
			  		    $SLN =  $student->lastName;
			  		    $PFN =  $parent->firstName;
			  		    $PLN =  $parent->lastName;

			  		    $qrPath = $student->qrCode."_".time().".png";
			  		    $file = \QrCode::format('png')
								        ->size('250')
								        ->generate($request->studentCode);
						\Storage::disk('public')->put($qrPath,$file);

						$student->qrPath = $qrPath;
						$student->save();
						
						///////////////////////// Parent Mail ///////////////////////
						parentSignup($userParent->id,$password,$parentInstitute->id);
						/////////////////////////////////////////////////////////////

						//$userParent->sendWellcomeEmailParent($password,$SFN,$SLN,$IN,$PFN,$PLN);

			  		   	DB::commit();

			  		    $response['data']['message'] = 'Request Successfull';
			  		    $response['data']['error'] = 200;
			  		    $response['status'] = true;
			  		}
			  		catch (\Exception $e) 
			  		{
			  		   DB::rollBack();
			  		}

			  	}
			  	else
			  	{
			  		$response['data']['message'] = 'Duplication of Student Code';
		  		    $response['data']['error'] = 400;
		  		    $response['status'] = false;
			  	}
			}
		}
		return $response;
	}

	public function listAllStudentsOfInstitute(Request $request)
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
	            	// $studentIds = StudentInstitute::where('instituteId',$user->Admin->id)
	            	// 									  ->pluck('studentId');	
	            	$students = Student::Join('users','users.id','=','students.userId')
                                                ->select('students.*',
                                                         'users.avatarFilePath')
                                                //->whereIn('students.id',$studentIds)
                                                ->where('students.instituteId',$request->id)
                                                ->where('users.isDeleted',0)
                                                ->get();

					$response['data']['message'] = 'Request Successfull';
					$response['data']['code']    = 200;
					$response['data']['result']  = $students;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            }
	        }
		}
		return $response;
    }

    public function listParentStudentsOfInstitute(Request $request)
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
	            	$studentIds = ParentStudent::where('parentId',$user->parent->id)
	            										  ->pluck('studentId');	
	            	$students = Student::Join('users','users.id','=','students.userId')
                                                ->select('students.*',
                                                         'users.avatarFilePath')
                                                ->whereIn('students.id',$studentIds)
                                                ->where('students.instituteId',$request->id)
                                                ->where('users.isDeleted',0)
                                                ->get();

					$response['data']['message'] = 'Request Successfull';
					$response['data']['code']    = 200;
					$response['data']['result']  = $students;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            }
	        }
		}
		return $response;
    }

    public function deleteStudent(Request $request)
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
	            	$student 	= Student::find($request->id);
	            	$userModel  = User::where('id',$student->userId)->update([
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

    public function reactiveStudent(Request $request)
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
	            	$student 	= Student::find($request->id);
	            	$userModel  = User::where('id',$student->userId)->update([
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

    public function studentDetail(Request $request)
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
	            	$student = Student::Join('users','users.id','=','students.userId')
                                                ->select('students.*',
                                                         'users.avatarFilePath')
                                                ->where('students.id',$request->id)
                                                ->first();
	            	
					$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] = 200;
					$response['data']['result'] = $student;
					$response['status'] = true;
				}
				catch (\Exception $e) 
	            {
	            }
	        }
		}
		return $response;
    }

    public function updateStudentInfo(Request $request)
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
				'id'         	=> ['required'],
				'firstName'     => ['required'],
				'lastName'      => ['required'],
				'age'         	=> ['required'],
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
	            	$student = Student::where('id',$request->id)
	            						->update([
	            									"firstName" => $request->firstName,
	            									"lastName" 	=> $request->lastName,
	            									"age" 		=> $request->age,
	            								]);
	            	if($student)
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

    public function updateStudentImage(Request $request)
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
                'id'	         => ['required'],
                'image'          => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
            	$student 		= Student::find($request->id);
            	$studentUser  	= User::find($student->userId);
                DB::beginTransaction();
                try 
                {
                    $file_data = $request->input('image');

                    @list($type, $file_data) = explode(';', $file_data);
                    @list(, $file_data) = explode(',', $file_data); 
                    @list(, $type) = explode('/', $type); 
                    
                    $file_name = 'image_'.time().'.'.$type; //generating unique file name;
                    
                    if($file_data!="")
                    { 
                        \Storage::disk('public')->put($file_name,base64_decode($file_data)); 
                        
                        $studentUser->avatarFilePath= $file_name;

                        if ($studentUser->save())
                        {
                            DB::commit();
                            $response['data']['message']    = 'Request Successfull';
                            $response['data']['code']       = 200;
                            $response['data']['result']     = $studentUser->avatarFilePath;
                            $response['status']             = true;
                        }
                    }
                    else
                    {
                        $response['data']['message'] = 'File Required';
                        $response['data']['code'] = 400;
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
