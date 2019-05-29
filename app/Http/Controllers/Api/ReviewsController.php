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
use Exception;


class ReviewsController extends Controller
{

/*
|--------------------------------------------------------------------------
|  CREATE A REVIEW AGAINST A HOSTEL
|--------------------------------------------------------------------------
|
*/
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

                    'body'   =>  'required',
                    'hostelId'  =>  'required',   
                    'userId'    =>  'required',

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

                        $review = Review::create([

                            'body'   =>  $request->get('body'),
                            'hostelId'  =>  $request->get('hostelId'),
                            'userId'    =>  $user->id,

                        ]);
                        
                        DB::commit();

                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['result']             = $review;
                        $response['data']['message']    = 'Review created Successfully';

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

/*
|--------------------------------------------------------------------------
|  LIST OF ALL REVIEWS AGAINST ALL HOSTELS
|--------------------------------------------------------------------------
|
*/

    public function listReviews(Request $request)
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

        if(!empty($user) && $user->isStudent())
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

                $reviews = Review::all();
                
                if (!empty($reviews)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $reviews;
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
|  LIST  ALL REVIEWS AGAINST A HOSTEL
|--------------------------------------------------------------------------
|
*/
    public function listHostelReviews(Request $request)
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

        if(!empty($user) && $user->isStudent())
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

            $reviews = Review::where('hostelId', '=', $request->id)->get();

            if (!empty($reviews)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $reviews;
                $response['status']             =  true;

            }

            } catch ( Exception $e) {

                DB::rollBack();
                $response['data']['code']       =  400;
                $response['data']['message']    =  'Request Unsuccessfull';
                $response['status']             =  false;    
            }
        } elseif (!empty($user) && $user->isHostelAdmin()) {
            
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            DB::beginTransaction();
            try {

            $reviews = Review::where('hostelId', '=', $request->id)->get();

            if (!empty($reviews)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $reviews;
                $response['status']             =  true;

            }

            } catch ( Exception $e) {

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
|  UPDATE REVIEW
|--------------------------------------------------------------------------
|
*/

    public function updateReview(Request $request)
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

        if(!empty($user) && $user->isStudent())
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

                $body = $request->get('body');

                DB::beginTransaction();
                try {

                    $reviews = Review::find($request->id)->update([
                    
                        'body' => $body,
    
                    ]);

                    if ($reviews) {

                        DB::commit();
                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Review updated SuccessfullY';
                        $response['status']             =  true;
    
                    }

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
|  DELETE REVIEW
|--------------------------------------------------------------------------
|
*/


    public function deleteReview(Request $request)
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

        if(!empty($user) && $user->isStudent())
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
                try{

                $reviews = Review::find($request->id)->delete();
                
                DB::commit();

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Review Deleted SuccessfullY';
                $response['status']             =  true;

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
}
