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
use App\Models\Api\ApiQueries as Queries;


class QueriesController extends Controller
{
      /**
     * CREATE Query
     *
     * Student can ask a query to super admin about the hostel.
     *
     * @function
     * 
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

            if(!empty($user) && $user->isStudent()){

                $response = [
                    'data' => [
                        'code' => 400,
                        'message' => 'Something went wrong. Please try again later!',
                    ],
                    
                'status' => false

                ];
                $rules = [
            
                    'message'    =>   'required',
                    'hostelId'   =>   'required',
                    'userId'     =>   'required',

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                }
                else
                {

                    $query = Queries::create([

                            'message'    =>   $request->get('message'),
                            'hostelId'   =>   $request->get('hostelId'),
                            'threadId'   =>   $request->get('threadId'),
                            'userId'     =>   $user->id,

                        ]);


                    if ($query->save()) 
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['result']             = $query;
                        $response['data']['message']    = 'Query created Successfully!';
                    }
                }
            }
        return $response;
    }

}
