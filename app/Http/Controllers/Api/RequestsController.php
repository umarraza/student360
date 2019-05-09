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
    public function create(Request $request)
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
                        $response['result']             = $request;
                        $response['data']['message']    = 'Request to approve hostel created successfully!';
                    }
                }
            }
        return $response;
    }
}
