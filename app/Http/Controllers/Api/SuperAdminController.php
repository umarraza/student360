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
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiUpdateRequests as UpdateRequests;


class SuperAdminController extends Controller
{

/*
|--------------------------------------------------------------------------
|  Approve Hostel
|--------------------------------------------------------------------------
|  Hostel admin can also apply for a verified badge. Verfified badge will 
|  be given after the inspetion team will inspect the hostel. This Api
|  is used to verified a hostel after inspection.
|
*/

    public function approveHostel(Request $request)
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
            
            $rules = [

            	'id' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            }else{

                $hostel = Hostel::find($request->id)->update([
                    'isApproved' => 1,
                ]);

                if ($hostel){

                    $response['data']['code']     = 200;
                    $response['status']           = true;
                    $response['data']['message']  = 'Hostel Approved Successfully';

                }else{

                    $response['data']['code']     = 400;
                    $response['status']           = false;
                    $response['data']['message']  = 'Request to approve hostel failed!';

                }
            }
        }
        return $response;
    }

/*
|--------------------------------------------------------------------------
|  Reject Hostel Approval
|--------------------------------------------------------------------------
|  Admin can reject the request to approve an hostel by not giving the verified
|  badge to the hostel.  
|
*/

    public function rejectHostelApprovel(Request $request)
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
            
            $rules = [

            	'id' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            }else{

                $hostel = Hostel::find($request->id)->update([
                    'isApproved' => 0,
                ]);

                if ($hostel){

                    $response['data']['code']     = 200;
                    $response['status']           = true;
                    $response['data']['message']  = 'Sorry! Request to approve the hostel have been rejected!';

                }else{

                    $response['data']['code']     = 400;
                    $response['status']           = false;
                    $response['data']['message']  = 'Request failed!';

                }
            }
        }
        return $response;
    }

/*
|--------------------------------------------------------------------------
|  Verify Hostel
|--------------------------------------------------------------------------
|  Hostel addmin will send a request to admin for verifying a hostel after
|  submitting a register request. Admin will verify the hostel if he 
|  meets the requirements of the hostel.
|
*/

    public function verifyHostel(Request $request)
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
            
            $rules = [

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                $hostel = Hostel::find($request->id);
                $userId = $hostel->userId;

                $hostel->isVerified = 1;

                $hostel->save();

                $user = User::find($userId)->update([

                    'verified' => 1,

                ]);

                if ($user){

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['data']['result']     =  $hostel;
                    $response['data']['message']    =  'Hostel Verified Successfully';

                }else{

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Request to verify hostel failed!';

                }
            }
        }
        return $response;
    }

/*
|--------------------------------------------------------------------------
|  Reject Hostel Verification
|--------------------------------------------------------------------------
|  Admin can reject the request to verify an hostel if he did not find the 
|  hostel appropriate according to thier requirements. This action will
|  takes place when a request is submitted to regiter a new hostel.
|
*/

    public function rejectHostelVerification(Request $request)
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
            
            $rules = [

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {


                $user = User::find($userId)->update([

                    'verified' => 0,

                ]);

                if ($user){

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['data']['message']    =  'Sorry! Request to verify the hostel have been rejected!';

                }else{

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Request Failed';

                }
            }
        }
        return $response;
    }

/*
|--------------------------------------------------------------------------
|  Verify User
|--------------------------------------------------------------------------
|  An registered user can also apply for a verify badge request. User can apply  
|  for badge if
|  
|
*/


    public function verifyUser(Request $request)
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
            
            $rules = [

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

              
                $student = Student::find($request->id)->update([

                    'isVerified' => 1,

                ]);


                if ($student){

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['data']['result']     =  $student;
                    $response['data']['message']    =  'Hostel Verified Successfully';

                }else{

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Request to verify hostel failed!';

                }
            }
        }
        return $response;
    }

    public function rejectUserVerification(Request $request)
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
            
            $rules = [

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

              
                $student = Student::find($request->id)->update([

                    'isVerified' => 0,

                ]);


                if ($student){

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['data']['message']    =  'Sorry! Request to verify the user have been rejected!';

                }else{

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Request Falied!';

                }
            }
        }
        return $response;
    }

    public function updateHostel(Request $request)
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
            
            $rules = [

                'id'                 =>   'required',
                'hostelType'         =>   'required',   // Boys, Girls, Guest House
                'numberOfBedRooms'   =>   'required',
                'noOfBeds'         	 =>   'required',
                'address'		     =>   'required',  
                'longitude'          =>   'required',
                'latitude'           =>   'required',
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

            } else {

                $approveUpdateRequest = UpdateRequests::find($request->id)->update([

                    'isUpdated' => 1,

                ]);

                $hostelDetails = Hostel::find($request->id)->update([

                    'hostelName'       =>   $request->get('hostelName'),
                    'hostelType'       =>   $request->get('hostelType'),
                    'numberOfBedRooms' =>   $request->get('numberOfBedRooms'),
                    'noOfBeds'         =>   $request->get('noOfBeds'),
                    'address'          =>   $request->get('address'),
                    'longitude'        =>   $request->get('longitude'),
                    'latitude'         =>   $request->get('latitude'),
                    'city'             =>   $request->get('city'),
                    'country'          =>   $request->get('country'),
                    'description'      =>   $request->get('description'),
                    'contactName'      =>   $request->get('contactName'),
                    'contactEmail'     =>   $request->get('contactEmail'),
                    'website'          =>   $request->get('website'),
                    'phoneNumber'      =>   $request->get('phoneNumber'),
                    'facilities'       =>   $request->get('facilities'),

                ]);

                
                if ($approveUpdateRequest && $hostelDetails){

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['data']['message']    =  'Request to update a hostel have been approved!';

                }else{

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Request to update hostel failed!';

                }
            }
        }
        return $response;
    }

    public function rejectUpdateHostel(Request $request)
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
            
            $rules = [

                'id' =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                $rejectUpdateRequest = UpdateRequests::find($request->id)->update([

                    'isUpdated' => 0,

                ]);

                if ($rejectUpdateRequest){

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['data']['message']    =  'Sorry! Request to update hostel have been rejected!';

                }else{

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Request Failed!';

                }
            }
        }
        return $response;
    }
}
