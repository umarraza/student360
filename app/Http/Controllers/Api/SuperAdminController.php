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

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                $hostel = Hostel::find($request->id)->update([
                    'isApproved' => 1,
                ]);

                if ($hostel){

                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Hostel Approved Successfully';

                }else{

                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Request to approve hostel failed!';

                }
            }
        }
        return $response;
    }

/*
|--------------------------------------------------------------------------
|  Verify Hostel
|--------------------------------------------------------------------------
|  Hostel admin can also apply for a verified badge. Verfified badge will 
|  be given after the inspetion team will inspect the hostel. This Api
|  is used to verified a hostel after inspection.
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

                $user = User::find($userId)->update([

                    'verified' => 1,

                ]);

                if (!empty($hostel)){

                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Hostel Verified Successfully';

                }else{

                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Request to verify hostel failed!';

                }
            }
        }
        return $response;
    }
}
