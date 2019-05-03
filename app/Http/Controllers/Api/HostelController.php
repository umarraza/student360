<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use JWTAuthException;
use JWTAuth;

use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiHostel as Hostel;

class HostelController extends Controller
{

    public function create(Request $request)
    {

        // $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

        // if(!empty($user) && $user->isHostelAdmin())
        // {

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [

            	'hostelName'         =>   'required',
                'hostelType'         =>   'required',   // Boys, Girls, Guest House
                'numberOfBedRooms'   =>   'required',
                'noOfBeds'         	 =>   'required',
                'address'		     =>   'required',  
                'pinLocation'	     =>   'required', 
                'city'            	 =>   'required',
                'country'            =>   'required',
                'description'        =>   'required',
                'contactName'        =>   'required',
                'contactEmail'       =>   'required',
                'website'            =>   'required',
                'phoneNumber'        =>   'required',
                'facilities'         =>   'required',

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
                    'verified'   =>  0,
                    'language'   =>  "English",

                ]);

                $hostel = Hostel::create([

                        'hostelName'       =>   $request->get('hostelName'),
                        'hostelType'       =>   $request->get('hostelType'),
                        'numberOfBedRooms' =>   $request->get('numberOfBedRooms'),
                        'noOfBeds'         =>   $request->get('noOfBeds'),
                        'address'          =>   $request->get('address'),
                        'pinLocation'      =>   $request->get('pinLocation'),
                        'city'             =>   $request->get('city'),
                        'country'          =>   $request->get('country'),
                        'description'      =>   $request->get('description'),
                        'contactName'      =>   $request->get('contactName'),
                        'contactEmail'     =>   $request->get('contactEmail'),
                        'website'          =>   $request->get('website'),
                        'phoneNumber'      =>   $request->get('phoneNumber'),
                        'facilities'       =>   $request->get('facilities'),
                        'userId'           =>   $user->id,

                    ]);


            	if ($hostel->save() && $user->save()) 
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['result']             = $hostel;
                    $response['user']               = $user;
                    $response['data']['message']    = 'Hostel created Successfully';
                }
            }
        // }
        
        return $response;
    }
}
