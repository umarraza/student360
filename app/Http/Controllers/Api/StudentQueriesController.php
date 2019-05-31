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
use App\Models\Api\ApiStudentQueries as Query;
use App\Models\Api\ApiMessMenuMeal as MessMenuMeal;
use App\Models\Api\ApiMessMenuTiming as MessMenuTiming;
use App\Models\Api\ApiUpdateHostelRequest as UpdateHostelRequest;
use App\Models\Api\ApiVerifyHostelRequests as VerifyHostelRequests;

use Exception;

class StudentQueriesController extends Controller
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

            if(!empty($user) && $user->isStudent()){

                $response = [
                    'data' => [
                        'code' => 400,
                        'message' => 'Something went wrong. Please try again later!',
                    ],
                    
                'status' => false

                ];

                $rules = [
            
                    'hostelId'   =>   'required',
                    'userId'   =>   'required',
                    'type'   =>   'required',

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                }
                else
                {

                    DB::beginTransaction();
                    // try {

                        $query = Query::create([

                            'question' =>   $request->get('question'),
                            'answers'  =>   $request->get('answers'),
                            'type'     =>   $request->get('type'),
                            'hostelId' =>   $request->get('hostelId'),
                            'userId'   =>   $request->get('userId'),

                        ]);

                        DB::commit();

                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['result']             = $query;
                        $response['data']['message']    = 'Query created Successfully!';

                    // } catch (Exception $e) {

                    //     DB::rollBack();
                    // }
                }
            }
        return $response;
    }

    public function listStudentQueries2(Request $request)
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

                'userId' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                DB::beginTransaction();
                // try {

                    $queries = Query::where('userId', '=', $request->userId)->get();
                    $queries->unique('hostelId');
                    return $queries;
                    
                    if (!empty($queries)) {

                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Request Successfull';
                        $response['data']['result']     =  $queries;
                        $response['status']             =  true;
    
                    }

                // } catch (Exception $e) {

                //     DB::rollBack();
                // }
            }
        }
        return $response;
    }
}
