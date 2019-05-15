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
use App\Models\Api\ApiUpdateHostelRequest as UpdateHostelRequest;
use App\Models\Api\ApiVerifyHostelRequests as VerifyHostelRequest;
use App\Models\Api\ApiApproveHostelRequests as ApproveHostelRequest;

class SuperAdminController extends Controller
{

    /**
     * ALL HOSTELS APPROVAL REQUESTS LIST
     *
     * Super admin can see a list of all hostels that send the request to aprove the hostel
     *
     * @function
     * 
     */
    public function listapprovalRequests(Request $request)
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
            
            $requests = ApproveHostelRequest::select('approveStatus', 'hostelId')->where('approveStatus', '=', 0)->get();

            if (!empty($requests)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $requests;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'Request Unsuccessfull';
                $response['status']             =  false;    
            }

        }
        return $response;
    }


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

                $requestData = ApproveHostelRequest::find($request->id);
                $hostelId = $requestData->hostelId;

                $hostel = Hostel::where('id', '=', $hostelId)->first();

                $approveRequest = ApproveHostelRequest::find($request->id)->update([

                    'approveStatus' => 1,

                ]);

                $hostel = Hostel::where('id', '=', $hostelId)->update([
                    'isApproved' => 1,
                ]);
                

                if ($approveRequest && $hostel) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Hostel approved successfully!';
                    $response['data']['result']     =  $approveRequest;
                    $response['status']             =  true;

                } else {

                    $response['data']['code']       =  400;
                    $response['data']['message']    =  'Request Unsuccessfull';
                    $response['status']             =  false;    
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
|  badge to the hostel. This means that the inspection team didn't find the 
|  hostel appropriate according to thier requirements.
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

                $rejectApprovalRequest = ApproveHostelRequest::find($request->id)->update([
                    
                    'approveStatus' => 2,  // Status = 2 means that the request to update hostel have been rejected by administrater
                
                ]);
                
                if ($rejectApprovalRequest ){

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

                $requestData = VerifyHostelRequest::find($request->id);

                $hostelId = $requestData->hostelId;

                $verifyHostel = VerifyHostelRequest::find($request->id)->update([
                    'verificationStatus' => 1,
                ]);

                $hostelData = Hostel::where('id', '=', $hostelId)->first();

                $hostel = Hostel::where('id', '=', $hostelId)->update([
                    'isVerified' => 1,
                ]);

                $userId = $hostelData->userId;

                $user = User::find($userId)->update([

                    'verified' => 1,

                ]);



                if ($verifyHostel && $hostel && $user){

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

            	'id' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                $user = User::find($userId)->update([

                    'verified' => 2,  // Status = 2 means that the request to update hostel have been rejected by administrater

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


    /**
     * ALL HOSTELS VERIFICATION REQUESTS LIST
     * Super admin can see a list of all hostels that send the request to register the hostel
     * 
     * @param VerifyHostelRequest 
     * @return Model
     */

    public function listHostelsVerifyRequests(Request $request)
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

            $hostelData = [];

            $verificationRequests = VerifyHostelRequest::select('id','verificationStatus', 'hostelId')
                    ->where('verificationStatus', '=', 0)->get();


            foreach ($verificationRequests as $requestData){

                $hostelData[] = Hostel::select('id', 'hostelName', 'isVerified')->where('id', '=', $requestData->hostelId)->first();
                $hostelData[] = $requestData;

            }

            if (!empty($hostelData)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $hostelData;
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
     * ALL UPDATE HOSTELS REQUESTS LIST
     *
     * Super admin can see a list of all hostels that send the request to update info
     *
     * @function
     * 
     */

    public function listHostelsUpdateRequests(Request $request)
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
            
            $allUpdateRequests = UpdateHostelRequest::select(
                
                'id',
                'hostelName',
                'hostelCategory',
                'numberOfBedRooms',
                'noOfBeds',
                'priceRange',
                'address',
                'longitude',
                'latitude',
                'state',
                'postCode',
                'city',
                'country',
                'description',
                'contactName',
                'website',
                'phoneNumber',
                'features' )

                ->where('status', '=', 0)->get();
            
            if (!empty($allUpdateRequests)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $allUpdateRequests;
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
     * APPROVE UPDATE REQUEST
     *
     * Super admin can see a list of all hostels that send the request to update info
     *
     * @function
     * 
     */

    public function approveUpdateRequest(Request $request)
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

            } else {

                $approveUpdateRequest = UpdateHostelRequest::find($request->id)->update([
                    'status' => 1,  // Chnage status to 1 to approve the update hostel request
                ]);
                
                $hostel = UpdateHostelRequest::find($request->id);

                $hostelId         =   $hostel->hostelId;
                $hostelName       =   $hostel->hostelName;
                $hostelCategory   =   $hostel->hostelCategory;
                $numberOfBedRooms =   $hostel->numberOfBedRooms;
                $noOfBeds         =   $hostel->noOfBeds;
                $priceRange       =   $hostel->priceRange;
                $address          =   $hostel->address;
                $longitude        =   $hostel->longitude;
                $latitude         =   $hostel->latitude;
                $state            =   $hostel->state;
                $postCode         =   $hostel->postCode;
                $city             =   $hostel->city;
                $country          =   $hostel->country;
                $description      =   $hostel->description;
                $contactName      =   $hostel->contactName;
                $contactEmail     =   $hostel->contactEmail;
                $website          =   $hostel->website;
                $phoneNumber      =   $hostel->phoneNumber;
                $features         =   $hostel->features;
                $userId           =   $hostel->userId;
            

                $updateHostel = Hostel::find($hostelId)->update([

                    'hostelName'        =>   $hostelName,
                    'hostelCategory'    =>   $hostelCategory,
                    'numberOfBedRooms'  =>   $numberOfBedRooms,
                    'noOfBeds'          =>   $noOfBeds,
                    'priceRange'        =>   $priceRange,
                    'address'           =>   $address,
                    'longitude'         =>   $longitude,
                    'latitude'          =>   $latitude,
                    'state'             =>   $state,
                    'postCode'          =>   $postCode,
                    'city'              =>   $city,
                    'country'           =>   $country,
                    'description'       =>   $description,
                    'contactName'       =>   $contactName,
                    'contactEmail'      =>   $contactEmail,
                    'website'           =>   $website,
                    'phoneNumber'       =>   $phoneNumber,
                    'features'          =>   $features,

                ]);

                if ($approveUpdateRequest) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Hostel Updated successfully!';
                    $response['status']             =  true;

                } else {

                    $response['data']['code']       =  400;
                    $response['data']['message']    =  'No Hostels Found';
                    $response['status']             =  false;    
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

                $rejectUpdateRequest = UpdateHostelRequest::find($request->id)->update([

                    'status' => 2, // Status = 2 means that the request to update hostel have been rejected by administrater

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
