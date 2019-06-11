<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use JWTAuthException;
use JWTAuth;

use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiHostel as Hostel;
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiThreads as Threads;
use App\Models\Api\ApiRatings as Rating;
use App\Models\Api\ApiImages as Image;
use App\Models\Api\ApiReviews as Review;
use App\Models\Api\ApiProfileImages as ProfileImages;

use Exception;

class StudentController extends Controller
{
    public function createStudent(Request $request)
    {
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],

               'status' => false
            
            ];

                $rules = [

                    'fullName'       =>   'required',
                    'phoneNumber'    =>   'required',   
                    'username'       =>   'required|unique:users',
                    'email'          =>   'required|unique:users',
                    'password'       =>   'required|min:6',
                    'roleId'         =>   'required',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                
                }
                else
                {

                    $username = $request->get('username');
                    $password = $request->get('password');
                    $roleId   = $request->get('roleId');
                    $email    = $request->get('email');

                    DB::beginTransaction();

                    try {

                        $user =  User::create([
                        
                            'username'   =>  $username,
                            'email'      =>  $email,
                            'password'   =>  bcrypt($password),
                            'roleId'     =>  $roleId,
                            'verified'   =>  1,
                            'language'   =>  "English",
    
                        ]); 
    
                        $student = Student::create([
    
                                'fullName'     =>   $request->get('fullName'),
                                'phoneNumber'  =>   $request->get('phoneNumber'),
                                'email'        =>   $request->get('email'),
                                'userId'       =>   $user->id,
                            ]);

                            DB::commit();

                            $response['data']['code']       = 200;
                            $response['status']             = true;
                            $response['data']['result']     = $student;
                            $response['user']               = $user;
                            $response['data']['message']    = 'Student profile created Successfully';

                    } catch (Exception $e) {

                        DB::rollBack();
                        throw $e;
                    }
                }
        return $response;
    }

     /**
     * LIST OF ALL USERS/STUDENTS
     *
     * @function
     */

    public function listStudents(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

        if(!empty($user) && $user->isSuperAdmin())
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            try {

                $allStudents = Student::select('id', 'fullName', 'phoneNumber', 'email', 'isVerified')->get();

                if (!empty($allStudents)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $allStudents;
                    $response['status']             =  true;
    
                }

            } catch (Exception $e) {

                throw $e;
            } 
        }
        return $response;
    }

    /**
     * LIST OF ALL REGISTERED USERS/STUDENTS
     *
     * @function
     */

    public function listRegisteredStudents(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

        if(!empty($user) && $user->isSuperAdmin())
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            try {

                $allStudents = Student::select(
                    'id', 
                    'fullName', 
                    'phoneNumber',
                     'email',
                     'city',
                     'country',
                     'occupation',
                     'institute',
                     'dateOfBirth',
                     'gender',
                     'CNIC',

                    )
                ->where('isVerified', '=', 1)
                ->get();

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $allStudents;
                $response['status']             =  true;

            } catch (Exception $e) {

                throw $e;
            }
        }
        return $response;
    }

     /**
     * UPDATE USER/STUDENT
     *
     * @function
     */

    public function updateStudent(Request $request)
    {
        // return $request;
        $user = JWTAuth::toUser($request->token);

        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

        if(!empty($user) && $user->isStudent())
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $rules = [

            	'id'  => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }
            else
            {

                if($user->username != $request->username)
                {
                    $checkUserName = User::where('username',$request->username)->first();

                    if(!empty($checkUserName))
                    {
                        $response = [
                            'data' => [
                                'code' => 400,
                                'message' => 'Username Already Exist!',
                            ],
                        'status' => false
                        ];
                        return $response;

                    } else {

                        $userUpdate = User::where('id',$user->id)->update([

                            'username' => $request->get('username'),
                        ]);
                    }
                }
                        
                if($user->email != $request->email)
                {
                    $checkEmail = User::where('email',$request->email)->first();

                    if(!empty($checkEmail))
                    {
                        $response = [
                            'data' => [
                                'code' => 400,
                                'message' => 'Email Already Exist!',
                            ],
                        'status' => false
                        ];
                        return $response;

                    } else {

                        $userUpdate = User::where('id',$user->id)->update([

                            'email'  => $request->get('email'),
                        
                        ]);
                    }
                }

                DB::beginTransaction();
                try {

                    $updateStudent = Student::find($request->id)->update([

                        'fullName'    =>  $request->get('fullName'),
                        'phoneNumber' =>  $request->get('phoneNumber'),
                        'email'       =>  $request->get('email'),
                        'city'        =>  $request->get('city'),
                        'country'     =>  $request->get('country'),
                        'occupation'  =>  $request->get('occupation'),
                        'institute'   =>  $request->get('institute'),
                        'dateOfBirth' =>  $request->get('dateOfBirth'),
                        'gender'      =>  $request->get('gender'),
                        'CNIC'        =>  $request->get('CNIC'),
    
                    ]);
    
                    $student = Student::find($request->id);
    
                    $email        =  $student->email;
                    $phoneNumber  =  $student->phoneNumber;
                    $city         =  $student->city;
                    $country      =  $student->country;
                    $occupation   =  $student->occupation;
                    $institute    =  $student->institute;
                    $dateOfBirth  =  $student->dateOfBirth;
                    $gender       =  $student->gender;
                    $CNIC         =  $student->CNIC;
    
                    if (isset($email, $phoneNumber, $city, $country, $occupation, $institute, $dateOfBirth, $gender, $CNIC)) {

                        $student->isVerified = 1;

                        $student->save();

                    } else {
                        
                        $student->isVerified = 0;

                        $student->save();
                    }

                    if ($updateStudent) {

                        $response['data']['code']       =  200;
                        $response['data']['result']     =  $student;
                        $response['data']['message']    =  'User updated successfully';
                        $response['status']             =  true;
    
                    }

                    DB::commit();

                } catch (Exception $e) {

                    DB::rollBack();
                    throw $e;
                }
            }
        }
        return $response;
    }


    /**
     *  STUDENT DETAILS
     *  Get all details of a student
     * 
     *  @return student
     */

    public function studentDetails(Request $request)
    {
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }
            else
            {

                try {

                    $student = Student::find($request->id);
                    $user = User::find($student->userId);
                    $username = $user->username;

                    $studentImage = ProfileImages::where('userId', '=', $student->userId)->first();

                    if (!empty($studentImage)) {

                        $imageName = $studentImage->imageName;
                        $student['profilePicture'] = $imageName;
                        $student['username'] = $username;

                    } else {

                        $student['profilePicture'] = NULL;
                        $student['username'] = $username;

                    }

                    if (!empty($student)) 
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['result']     = $student;
                        $response['data']['message']    = 'Request Successfull';
    
                    }

                } catch (Exception $e) {
                    
                    throw $e;
                }
            }
        return $response;
    }

}
