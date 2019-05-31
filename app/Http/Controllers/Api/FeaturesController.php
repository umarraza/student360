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
use App\Models\Api\ApiImages as Image;
use App\Models\Api\ApiHostel as Hostel;
use App\Models\Api\ApiReviews as Review;
use App\Models\Api\ApiRatings as Rating;
use App\Models\Api\ApiThreads as Threads;
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiFeatures as Features;
use App\Models\Api\ApiMessMenuMeal as MessMenuMeal;
use App\Models\Api\ApiMessMenuTiming as MessMenuTiming;
use App\Models\Api\ApiUpdateHostelRequest as UpdateHostelRequest;
use App\Models\Api\ApiVerifyHostelRequests as VerifyHostelRequests;

use Exception;


class FeaturesController extends Controller
{
    public function createFeature(Request $request)
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

        if(!empty($user) && $user->isSuperAdmin()) { 

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];

                $rules = [

                    'featureName'   =>  'required',

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

                        $feature = Features::create([

                            'featureName'   =>  $request->get('featureName'),

                        ]);
                        

                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['result']             = $feature;
                        $response['data']['message']    = 'Feature created Successfully';

                        DB::commit();

                    } catch (Exception $e) {

                        DB::rollBack();
                    }
                }
            }
        return $response;
    }

    public function listFeature(Request $request)
    {
        $response = [
            'data' => [
                'code' => 400,
                'message' => 'Something went wrong. Please try again later!',
            ],
            'status' => false
        ];

            try {

                $features = Features::all();
                
                DB::commit();

                $response['data']['code']       = 200;
                $response['status']             = true;
                $response['result']             = $features;
                $response['data']['message']    = 'Request Successfull';

            } catch (Exception $e) {

            }

        return $response;
    }


    public function deleteFeature(Request $request)
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

        if(!empty($user) && $user->isSuperAdmin()) { 

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];

                $rules = [

                    'id'   =>  'required',

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

                        $feature = Features::find($request->id)->delete();
                        

                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['message']    = 'Feature deleted Successfully';

                        DB::commit();

                    } catch (Exception $e) {

                        DB::rollBack();
                    }
                }
            }
        return $response;
    }
}
