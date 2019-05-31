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
    public function create(Request $request)
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
                    'password'       =>   'required',
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
    
                            $userId = $user->id;
    
                            /* 
                                Create a new ThreadModel instance.
                                ---------------------
                                Thread respresents the conversation between a registered user and super admin.
                                Registered user can ask queries to super admin about anything regrading 
                                hostels. All messages between a registered user and super admin will 
                                form a conversation/thread. Thread is being created while 
                                registering a user because...
    
                            */ 
    
                            $thread = Threads::create([
                                'userId'  => $userId,
                                'adminId' => 1,
                            ]);
    
                            $thread->save();
    
                            $threadId = $thread->id;

                            $updateThread = User::where('id', '=', $userId)->update([
                                'threadId' => $threadId
                            ]);
    
                        $student = Student::create([
    
                                'fullName'     =>   $request->get('fullName'),
                                'phoneNumber'  =>   $request->get('phoneNumber'),
                                'userId'       =>   $user->id,
                                'threadId'     =>   $threadId,
    
                            ]);

                            DB::commit();

                            $response['data']['code']       = 200;
                            $response['status']             = true;
                            $response['data']['result']     = $student;
                            $response['user']               = $user;
                            $response['data']['message']    = 'Student profile created Successfully';

                    } catch (Exception $e) {

                        DB::rollBack();

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
            
            DB::beginTransaction();
            try {

                $allStudents = Student::select('id', 'fullName', 'phoneNumber', 'email', 'isVerified')->get();

                if (!empty($allStudents)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $allStudents;
                    $response['status']             =  true;
    
                }

            } catch (Exception $e) {

                DB::rollBack();
                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;
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
            
            DB::beginTransaction();
            try {

                $allStudents = Student::select('id', 'fullName', 'phoneNumber', 'email')
                ->where('isVerified', '=', 1)
                ->get();

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $allStudents;
                $response['status']             =  true;

            } catch (Exception $e) {

                DB::rollBack();
                $response['data']['code']       =  400;
                $response['data']['message']    =  'Request Unsuccessfull';
                $response['status']             =  false;
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

            	'id'         =>   'required',
                'username'   =>   'required',
                'email'      =>   'required',

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

                            'username'      => $request->get('username'),
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

                            'email'      => $request->get('email'),
                        
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
                }
            }
        }
        return $response;
    }


    public function updateStudent2(Request $request)
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

            	'id'         =>   'required',
                'username'   =>   'required',
                'email'      =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            
            }
            else
            {

                if($user->username = $request->username && $user->email = $request->email)
                {
                    $checkUserName = User::where('username',$request->username)->first();
                    $checkEmail = User::where('email',$request->email)->first();

                    if(!empty($checkUserName) && !empty($checkEmail))
                    {
                        $response = [
                            
                            'data' => [
                                'code' => 400,
                                'message' => 'Username and Email Already Exist!',
                            ],
                            'status' => false
                        ];

                        return $response;
                    }
                } else {

                    DB::beginTransaction();
                    // try {


                        // if ($user->username = $request->username) {

                        //     $response = [
                            
                        //         'data' => [
                        //             'code' => 400,
                        //             'message' => 'username Already Exist!',
                        //         ],
                        //         'status' => false
                        //     ];
                        // }

                        $userUpdate = User::where('id',$user->id)->update([
                                 
                            'username'  =>  $request->get('username'),
                            'email'     =>  $request->get('email'),
                            
                        ]);

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
        

                        // https://stackoverflow.com/questions/6850452/check-if-multiple-values-are-all-false-or-all-true Visit this site
    
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

                        // if ($student->email != NULL && $student->phoneNumber != NULL && $student->city != NULL && $student->country != NULL && $student->occupation != NULL && $student->institute != NULL && $student->CNIC != NULL){
    
                        // $student->isVerified = 1;
    
                        // $student->save();
                            
                        // }else{
    
                        //     $student->isVerified = 0;
    
                        //     $student->save();
                        // }

                    // } catch (Exception $e) {

                    //     DB::rollBack();
                    //     $response['data']['code']       =  400;
                    //     $response['data']['message']    =  'Request Unsuccessfull';
                    //     $response['status']             =  false;
                    // }
                }
            }
        }
        return $response;
    }



    /**
     * STUDENT DETAILS
     *
     * @function
     */

    public function studentDetails(Request $request)
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
                    $imageName = $studentImage->imageName;

                    $student['profilePicture'] = $imageName;
                    $student['username'] = $username;

                    if (!empty($student)) 
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['result']     = $student;
                        $response['data']['message']    = 'Request Successfull';
    
                    }

                } catch (Exception $e) {
 
                }
            }
        return $response;
    }

    public function allHostels(Request $request)  // for user either registered or non-registered
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
            
            try {

                $hostels = Hostel::all();

                foreach ($hostels as $hostel) {

                    $image = Image::where('hostelId', '=', $hostel->id)
                        ->where('isThumbnail', '=', 1)
                    ->first();

                    $otherImages = Image::where('hostelId', '=', $hostel->id)
                            ->select('id', 'imageName', 'isThumbnail', 'hostelId')
                        ->where('isThumbnail', '=', 0)->get();

                    $reviews = Review::where('hostelId', '=', $hostel->id)
                        ->select('id', 'body')
                    ->get();

                    $avgRating = Rating::where('hostelId', '=', $hostel->id)

                    ->avg('score');

                    $hostel['avgRating'] = $avgRating;

                    if (!empty($image)) {

                        $thumbnailImageName = $image->imageName;
                        $hostel['imageName'] = $thumbnailImageName;
                        $hostel['otherImages'] = $otherImages;
                    
                    } else {

                        $hostel['imageName'] = NULL;
                    }

                    $hostel['reviews'] = $reviews;

                }

                if (!empty($hostels)) {
                    
                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $hostels;
                    $response['status']             =  true;

                } else {

                    $response['data']['code']       =  400;
                    $response['data']['message']    =  'No Hostels Found';
                    $response['status']             =  false;    
                }

            } catch (Exception $e) {

            }
        return $response;
    }
}
