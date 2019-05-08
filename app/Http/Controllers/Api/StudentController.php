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
                // 'email'        =>   'required',
                // 'city'         =>   'required',
                // 'country'      =>   'required',  
                // 'occupation'   =>   'required', 
                // 'institute'    =>   'required',
                // 'dateOfBirth'  =>   'required',
                // 'gender'       =>   'required',
                // 'CNIC'         =>   'required',
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

                $student = Student::create([

                        'fullName'     =>   $request->get('fullName'),
                        'phoneNumber'  =>   $request->get('phoneNumber'),
                        // 'email'        =>   $request->get('email'),
                        // 'city'         =>   $request->get('city'),
                        // 'country'      =>   $request->get('country'),
                        // 'occupation'   =>   $request->get('occupation'),
                        // 'institute'    =>   $request->get('institute'),
                        // 'dateOfBirth'  =>   $request->get('dateOfBirth'),
                        // 'gender'       =>   $request->get('gender'),
                        // 'CNIC'         =>   $request->get('CNIC'),
                        'userId'       =>   $user->id,

                    ]);


            	if ($student->save() && $user->save()) 
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['result']             = $student;
                    $response['user']               = $user;
                    $response['data']['message']    = 'Student profile created Successfully';
                }
            }
        return $response;
    }

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
            
            $allStudents = Student::all();

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
                    $response['result']             = $student;
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
