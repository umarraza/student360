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
use App\Models\Api\ApiUpdateRequests as UpdateRequests;

use App\Models\Api\ApiHostel as Hostel;

class HostelController extends Controller
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

            	'hostelName'         =>   'required',
                'hostelType'         =>   'required',   // Boys, Girls, Guest House
                'numberOfBedRooms'   =>   'required',
                'noOfBeds'         	 =>   'required',
                'address'		     =>   'required',  
                'longitude'          =>   'required',
                'latitude'           =>   'required',
                'state'              =>   'required',
                'postCode'           =>   'required',
                'city'            	 =>   'required',
                'country'            =>   'required',
                'description'        =>   'required',
                'contactName'        =>   'required',
                'contactEmail'       =>   'required',
                'website'            =>   'required',
                'phoneNumber'        =>   'required',
                'features'           =>   'required',
                'username'           =>   'required|unique:users',
                'password'           =>   'required',
                'roleId'             =>   'required',

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
                        'longitude'        =>   $request->get('longitude'),
                        'latitude'         =>   $request->get('latitude'),
                        'state'            =>   $request->get('state'),
                        'postCode'         =>   $request->get('postCode'),
                        'city'             =>   $request->get('city'),
                        'country'          =>   $request->get('country'),
                        'description'      =>   $request->get('description'),
                        'contactName'      =>   $request->get('contactName'),
                        'contactEmail'     =>   $request->get('contactEmail'),
                        'website'          =>   $request->get('website'),
                        'phoneNumber'      =>   $request->get('phoneNumber'),
                        'features'         =>   $request->get('features'),
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
        
        return $response;
    }

    public function listHostels(Request $request)
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
            
            $allHostels = Hostel::all();

            if (!empty($allHostels)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $allHostels;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;    
            }

        }
        return $response;
    }

    public function registeredHostels(Request $request)
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
            
            $registeredHostels = Hostel::where('isVerified', 1)->get();

            if (!empty($registeredHostels)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $registeredHostels;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;    
            }


        }
        return $response;
    }

    public function hostelDetails(Request $request)
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

                $hostel = Hostel::find($request->id);

                // Here we have to broke the string to get the info of features of a hostel

                $breakData = explode('$$$', $features);
                $data = $breakData[0];
                $vcardData = explode("@@@",$data);

            	if (!empty($hostel)) 
                {

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['result']             =  $hostel;
                    $response['data']['message']    =  'Request Successfull';

                } else {

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Hostel Not Found!';
                
                }
            }
        return $response;
    }

    public function delete(Request $request)
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
            
            }else{

                $hostel = Hostel::find($request->id);
                $userId = $hostel->userId;

                $user = User::find($userId);
                
            	if ($user->delete() && $hostel->delete()) {

                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Hostel Deleted Successfully';

                } else {

                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Hostel Not Deleted!';
                
                }
            }
        
        return $response;
    }

    public function updateRequest(Request $request)
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

        if(!empty($user) && $user->isHostelAdmin())
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $isUpdated = $request->get('isUpdated');

            $updateRequest =  UpdateRequests::create([
                    
                'isUpdated'  =>  $isUpdated,

            ]);


            if ($updateRequest->save()) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $updateRequest;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;    
            }


        }
        return $response;
    }

}
