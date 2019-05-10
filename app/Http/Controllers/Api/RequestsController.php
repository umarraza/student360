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
use App\Models\Api\ApiReviews as Review;
use App\Models\Api\ApiApproveHostelRequests as ApproveHostelRequest;


class RequestsController extends Controller
{
    /**
     * REQUEST FOR HOSTEL APPROVAL
     *
     * Hostel admin can send an approval request to super admin.
     * Inspection team of super admin will inspect the hostel
     * and then super admin will approve or reject the 
     * approval request of hostel.
     * 
     * @function
     */

    public function approveHostelRequest(Request $request)
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

        if(!empty($user) && $user->isHostelAdmin()) { 

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];

                $rules = [

                    'hostelId'  =>  'required',   

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                
                }
                else
                {

                    $request = ApproveHostelRequest::create([

                            'approveStatus'  =>  0,
                            'hostelId'  =>  $request->get('hostelId'),

                        ]);


                    if ($request->save()) 
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['result']     = $request;
                        $response['data']['message']    = 'Request to approve hostel created successfully!';
                    }
                }
            }
        return $response;
    }

    /**
     * HOSTEL UPDATE REQUEST
     *
     * Hostel Admin can update hostel by sending a request to 
     * Super admin. Super admin will approve or reject the 
     * request.
     * 
     * @function
     */

    public function updateHostelRequest(Request $request)
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

        if(!empty($user) && $user->isHostelAdmin()){

                $response = [
                    'data' => [
                        'code' => 400,
                        'message' => 'Something went wrong. Please try again later!',
                    ],
                    
                    'status' => false

                ];
                $rules = [

                    'hostelName'         =>   'required',
                    'hostelCategory'     =>   'required',  
                    'numberOfBedRooms'   =>   'required',
                    'noOfBeds'         	 =>   'required',
                    'priceRange'         =>   'required',  
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
                    'status'             =>   'required',
                    'hostelId'           =>   'required',

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                }
                else
                {

                $userId = $user->id;
                   
                    $updateHostel = UpdateHostelRequest::create([

                            'hostelName'       =>   $request->get('hostelName'),
                            'hostelCategory'   =>   $request->get('hostelCategory'), //Boys, Girls, Guest House
                            'numberOfBedRooms' =>   $request->get('numberOfBedRooms'),
                            'noOfBeds'         =>   $request->get('noOfBeds'),
                            'priceRange'       =>   $request->get('priceRange'),
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
                            'status'           =>   $request->get('status'),
                            'hostelId'         =>   $request->get('hostelId'),
                            'userId'           =>   $userId,

                        ]);


                    if ($updateHostel->save()) 
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['result']     = $updateHostel;
                        $response['data']['message']    = 'Update request for hostel created Successfully';
                    }
                }
            }
        return $response;
    }
}
