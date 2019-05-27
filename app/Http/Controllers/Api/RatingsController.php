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
use App\Models\Api\ApiThreads as Threads;
use App\Models\Api\ApiRatings as Rating;


class RatingsController extends Controller
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

        if(!empty($user) && $user->isStudent()) { 

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];

                $rules = [

                    'score'   =>  'required',
                    'userId'  =>  'required',   
                    'hostelId' =>  'required',

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                
                }
                else
                {

                    DB::beginTransaction();
                    try {

                        $rating = Rating::create([

                            'score'    =>  $request->get('score'),
                            'hostelId' =>  $request->get('hostelId'),
                            'userId'   =>  $user->id,

                        ]);

                            DB::commit();
                            
                            $response['data']['code']       = 200;
                            $response['status']             = true;
                            $response['result']             = $rating;
                            $response['data']['message']    = 'Rating created Successfully';

                    } catch (Exception $e) {
                        
                        DB::rollBack();

                        $response['data']['code']       = 400;
                        $response['status']             = false;
                        $response['data']['message']    = 'Request Unsuccessfull';
                    }
                }
            }
        return $response;
    }
}
