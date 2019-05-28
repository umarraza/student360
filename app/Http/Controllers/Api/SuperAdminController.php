<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\helpers;

use JWTAuthException;
use JWTAuth;

use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiHostel as Hostel;
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiUpdateHostelRequest as UpdateHostelRequest;
use App\Models\Api\ApiVerifyHostelRequests as VerifyHostelRequest;
use App\Models\Api\ApiApproveHostelRequests as ApproveHostelRequest;
use Exception;

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
            
            /** 
             *  Combining info of hostels and their approval requests in a single (object).
             *  To show approval requests list to the hostel admin, we've to show thier
             *  appropriate hostels to the superadmin also. Below logic aims to do
             *  that job.
             * 
             *  @return approvalRequests
             */

            DB::beginTransaction();
            try{

                $requests = ApproveHostelRequest::select('id', 'approveStatus', 'hostelId')->where('approveStatus', '=', 0)->get();

                $approvalRequests = [];

                foreach ($requests as $value){

                    $hostelId = $value->hostelId;
            
                    $hostel = Hostel::select('id', 'hostelName', 'hostelCategory', 'city')->where('id', '=', $hostelId)->first();

                    $city = $hostel->city;
                    $hostelName = $hostel->hostelName;
                    $hostelCategory = $hostel->hostelCategory;

                    $value["city"] = $city;
                    $value["hostelName"] = $hostelName;
                    $value["hostelCategory"] = $hostelCategory;

                    $approvalRequests[] = $value;

                }

                if (!empty($requests)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['hostel']     =  $approvalRequests;
                    $response['status']             =  true;

                }

            } catch (Exception $e) {

                DB::rollBack();
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


                DB::beginTransaction();

                try{

                    $requestData = ApproveHostelRequest::find($request->id);
                    $hostelId = $requestData->hostelId;

                    $approveRequest = ApproveHostelRequest::find($request->id)->update([
                        'approveStatus' => 1,
                    ]);
                    
                    $hostel = Hostel::where('id', '=', $hostelId)->update([
                        'isApproved' => 1,
                    ]);

                    if ($hostel && $approveRequest) {

                        DB::commit();

                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Hostel approved successfully!';
                        $response['status']             =  true;
    
                    }

                    // PUSH NOTIFICATION

                    // $title    =  "Approve Hotsle";
                    // $userId   =  $hostel->userId;
                    // $message  =  "Your request to approve hostel has been approved!";

                    // findDeviceToken($userId,$title,$message);

                } catch (Exception $e) {

                    DB::rollBack();
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

                DB::beginTransaction();

                try{

                    $rejectApprovalRequest = ApproveHostelRequest::find($request->id);
                
                    $hostelId = $rejectApprovalRequest->hostelId;

                    $hostel = Hostel::where('id', '=', $hostelId)->first();

                    $rejectApprovalRequest = ApproveHostelRequest::find($request->id)->update([
                        'approveStatus' => 2,
                    ]);


                    $rejectHostel = Hostel::where('id', '=', $hostelId)->update([
                        'isApproved' => 2,
                    ]);

                    if ($rejectApprovalRequest && $hostel){
                        
                        DB::commit();
                        $response['data']['code']     = 200;
                        $response['status']           = true;
                        $response['data']['message']  = 'Sorry! Request to approve the hostel have been rejected!';
    
                    }
                    

                    // PUSH NOTIFICATION

                    // $userId = $hostel->userId;
                    // $title = "Approval Request Rejected!";
                    // $message = "Sorry! Your request to approve hostel have been rejected!";

                    // findDeviceToken($userId, $title, $message);

                } catch (Exception $e) {

                    DB::rollBack();
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

                DB::beginTransaction();

                try {

                    $hostelData = Hostel::where('id', '=', $request->id)->first();

                    $hostel = Hostel::where('id', '=', $request->id)->update([
                        'isVerified' => 1,
                    ]);

                    $userId = $hostelData->userId;

                    $user = User::find($userId)->update([

                        'verified' => 1,

                    ]);

                    if ($hostel && $user){
                       
                        DB::commit();
                        $response['data']['code']       =  200;
                        $response['status']             =  true;
                        $response['data']['result']     =  $hostel;
                        $response['data']['message']    =  'Hostel Verified Successfully';
    
                    }

                    // PUSH NOTIFICATION

                    // $title = "Hostel Verified";
                    // $message = "Congratulations! Your request to registered a new hostel have been approved";

                    // findDeviceToken($title, $message, $userId);

                } catch (Exception $e) {

                    DB::rollBack();
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

                DB::beginTransaction();
                try {

                    $hostelData = Hostel::find($request->id);
                    $userId = $hostelData->userId;

                    $hostel = Hostel::where('id', '=', $request->id)->update([

                        'isVerified' => 2,

                        ]);
                    
                    $user = User::find($userId)->update([

                        'verified' => 2,  // Status = 2 means that the request to update hostel have been rejected by administrater

                    ]);

                    // PUSH NOTIFICATION

                    // $title = "Hostel Registration Rejected";
                    // $message = "Sorry! Your request to register a new hostel have been rejected.";

                    // findDeviceToken($title, $message, $userId);

                    if ($user){

                        DB::commit();
                        $response['data']['code']       =  200;
                        $response['status']             =  true;
                        $response['data']['message']    =  'Sorry! Request to verify the hostel have been rejected!';
    
                    }

                } catch (Exception $e){

                    DB::rollBack();
                    $response['data']['code']       =  400;
                    $response['data']['message']    =  'Request Unsuccessfull';
                    $response['status']             =  false;
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
            
            DB::beginTransaction();
            
            try{

                $allHostels = Hostel::select('id','hostelName',  'website', 'hostelCategory')
                ->where('isVerified', '=', 0)
                ->get();

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $allHostels;
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

    public function listHostelsVerifyRequests2(Request $request)
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
                
                $hostelData = [];

                $verificationRequests = VerifyHostelRequest::select('id','verificationStatus', 'hostelId')
                        ->where('verificationStatus', '=', 0)->get();
    
                foreach ($verificationRequests as $value){
    
                    $hostelData[] = Hostel::select('id', 'hostelName', 'website', 'hostelCategory')->where('id', '=', $value->hostelId)->first();
                    $hostelData[] = $value;
    
                }

                if (!empty($hostelData)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $hostelData;
                    $response['status']             =  true;
    
                }

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
     * ALL UPDATE HOSTELS REQUESTS LIST
     * Super admin can see a list of all hostels that sends the request to update info
     *
     * @return Model
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
            
            DB::beginTransaction();

            try{ 
                
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
        
                    }

            } catch (Exception $e){

                DB::rollBack();
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
     * Super admin can approve the hostel's update request.
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

                DB::beginTransaction();
                try {

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
    
                    // PUSH NOTIFICATION
    
                    // $title = "Hostel Updated";
                    // $message = "Your request to update hostel have been approved!";
                    // findDeviceToken($title, $message, $userId);

                    if ($updateHostel) {
                        
                        DB::commit();
                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Hostel Updated successfully!';
                        $response['status']             =  true;
    
                    }


                } catch (Exception $e) {

                    DB::rollBack();

                    $response['data']['code']       =  400;
                    $response['data']['message']    =  'Hostel not updated';
                    $response['status']             =  false;    
                }
            }
        }
        return $response;
    }
    /**
     * 
     * REJECT HOTSEL'S UPDATE REQUEST
     * Super admin can reject the request to update the hostel info
     * 
     */
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

                DB::beginTransaction();
                try {

                    $requestData = UpdateHostelRequest::where('id', '=', $request->id)->first();
                    $hostelId = $requestData->hostelId;

                    $hostel = Hostel::where('id', '=', $hostelId)->first();
                    $userId = $hostel->userId;

                    $rejectUpdateRequest = UpdateHostelRequest::where('id', '=', $request->id)->update([

                        'status' => 2, // Status = 2 means that the request to update hostel have been rejected by administrater

                    ]);

                    // PUSH NOTIFICATION

                    // $title = "Hostel Updated";
                    // $message = "Your request to update hostel have been approved!";
                    // findDeviceToken($title, $message, $userId);

                    if ($rejectUpdateRequest){
                        
                        DB::commit();

                        $response['data']['code']       =  200;
                        $response['status']             =  true;
                        $response['data']['message']    =  'Request to update hostel have been rejected!';
    
                    }


                } catch (Exception $e) {

                    DB::rollBack();
                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Request Unsuccessfull!';
                }
            }
        }
        return $response;
    }

    /**
     * ALL HOSTELS APPROVAL REQUESTS LIST
     *
     * Super admin can see a list of all hostels that send the request to aprove the hostel
     *
     * @function
     * 
     */

    public function liststudents(Request $request)
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

                // $hostels = Hostel::select('id', 'hostelName', 'hostelCategory', 'isApproved')->where('isApproved', '=', 0)->get();
                $students = Student::all()->get();

                if (!empty($students)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $students;
                    $response['status']             =  true;
    
                }

            } catch (Exception $e) {

                DB::rollBack();
                $response['data']['code']       =  400;
                $response['data']['message']    =  'Request Unsuccessfull';
                $response['status']             =  false;    
            }
        }
        return $response;
    }
}
