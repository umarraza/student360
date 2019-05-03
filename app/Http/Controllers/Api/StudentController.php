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

            	'name'         =>   'required',
                'phone'        =>   'required',   
                'email'        =>   'required',
                'city'         =>   'required',
                'country'      =>   'required',  
                'occupation'   =>   'required', 
                'institute'    =>   'required',
                'dateOfBirth'  =>   'required',
                'gender'       =>   'required',
                'CNIC'         =>   'required',

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

                $user =  User::create([
                    
                    'username'   =>  $username,
                    'password'   =>  bcrypt($password),
                    'roleId'     =>  $roleId,
                    'verified'   =>  1,
                    'language'   =>  "English",

                ]);

                $student = Student::create([

                        'name'         =>   $request->get('name'),
                        'phone'        =>   $request->get('phone'),
                        'email'        =>   $request->get('email'),
                        'city'         =>   $request->get('city'),
                        'country'      =>   $request->get('country'),
                        'occupation'   =>   $request->get('occupation'),
                        'institute'    =>   $request->get('institute'),
                        'dateOfBirth'  =>   $request->get('dateOfBirth'),
                        'gender'       =>   $request->get('gender'),
                        'CNIC'         =>   $request->get('CNIC'),
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
}
