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

                        'threadId' => $threadId,

                    ]);


                $student = Student::create([

                        'fullName'     =>   $request->get('fullName'),
                        'phoneNumber'  =>   $request->get('phoneNumber'),
                        'userId'       =>   $user->id,

                    ]);


            	if ($student->save() && $user->save()) 
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['result']     = $student;
                    $response['user']               = $user;
                    $response['data']['message']    = 'Student profile created Successfully';
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
            
            $allStudents = Student::select('id', 'fullName', 'phoneNumber', 'email', 'isVerified')->get();

            if (!empty($allStudents)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $allStudents;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
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

                if ($student->email != NULL && $student->phoneNumber != NULL && $student->city != NULL && $student->country != NULL && $student->occupation != NULL && $student->institute != NULL && $student->CNIC != NULL){

                  $student->isVerified = 1;

                  $student->save();
                    
                }else{

                    $student->isVerified = 0;

                    $student->save();
                }

            if ($updateStudent) {

                $response['data']['code']       =  200;
                $response['data']['result']     =  $student;
                $response['data']['message']    =  'User updated successfully';
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'Request Unsuccessfull';
                $response['status']             =  false;    
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

                $student = Student::find($request->id);

            	if (!empty($student)) 
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['result']     = $student;
                    $response['data']['message']    = 'Request Successfull';

                } else {

                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Srudent not found';

                }
            }
        
        return $response;
    }
}
