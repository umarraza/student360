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
use App\Models\Api\ApiQueries as Queries;


use Exception;


class QueriesController extends Controller
{
    /**
     * CREATE Query
     *
     * Student can ask a query to super admin about the hostel.
     *
     * @return Model
     * 
     */


    public function createQuery(Request $request)
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

            if(!empty($user)){

                $response = [
                    'data' => [
                        'code' => 400,
                        'message' => 'Something went wrong. Please try again later!',
                    ],
                    
                'status' => false

                ];
                $rules = [
            
                    'message'    =>   'required',
                    'type'       =>   'required',
                    'hostelId'   =>   'required',
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


                        /**  
                         *  check if thread against a user exists or not. If exists, 
                         *  then create just queries else create thread and then queries
                         * 
                        */
                        
                        $checkThread = Threads::where('userId', '=', $request->userId)
                            ->where('hostelId', '=', $request->hostelId)->first();

                        if (!empty($checkThread)) {

                            $threadId = $checkThread->id;

                            $query = Queries::create([
    
                                'message'   =>   $request->get('message'),
                                'type'      =>   $request->get('type'),
                                'hostelId'  =>   $request->get('hostelId'),
                                'threadId'  =>   $threadId,
    
                            ]);

                        } else {

                            $thread = Threads::create([

                                'hostelId' =>  $request->get('hostelId'), 
                                'userId' =>  $request->get('userId'),
    
                            ]);
    
                            $thread->save();
    
                            $threadId = $thread->id;
    
                            $query = Queries::create([
    
                                'message'   =>   $request->get('message'),
                                'type'      =>   $request->get('type'),
                                'hostelId'  =>   $request->get('hostelId'),
                                'threadId'  =>   $threadId,
    
                            ]);

                        }

                        DB::commit();

                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['result']             = $query;
                        $response['data']['message']    = 'Query created Successfully!';

                    } catch (Exception $e) {

                    }
                }
            }
        return $response;
    }

    /**
     * ALL QUERIES LIST
     *
     * Super admin can see a list of all queries send by registered users
     *
     * @return Queries
     * 
     */

    public function listQueries(Request $request)
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

            	'threadId' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                $threadId = $request->get('threadId');

                DB::beginTransaction();
                try {

                    $queries = Queries::select('id', 'message', 'type', 'threadId', 'hostelId')->where('threadId', '=', $threadId)->get();
                    
                    foreach ($queries as $query) {

                        $hostelId   = $query->hostelId;
                        $hostelData = Hostel::find($hostelId);
                        $hostelName = $hostelData->hostelName;

                        $query['hostelName'] = $hostelName;

                    }

                    if (!empty($queries)) {

                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Request Successfull';
                        $response['data']['result']     =  $queries;
                        $response['status']             =  true;
    
                    }

                } catch (Exception $e) {

                    throw $e;

                    DB::rollBack();

                    $response['data']['code']       =  400;
                    $response['data']['message']    =  'Request Unsuccessfull';
                    $response['status']             =  false;

                }
            }
        }
        return $response;
    }

    public function delete(Request $request)
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

                $query = Queries::find($request->id)->delete();

                DB::commit();
                
                $response['data']['code']       =  200;
                $response['data']['message']    =  'Query Deleted SuccessfullY';
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


}
