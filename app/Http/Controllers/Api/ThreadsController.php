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
use App\Models\Api\ApiImages as Images;
use App\Models\Api\ApiHostel as Hostel;
use App\Models\Api\ApiQueries as Queries;
use App\Models\Api\ApiThreads as Threads;
use App\Models\Api\ApiStudent as Student;

use Exception;

class ThreadsController extends Controller
{

    public function createThread(Request $request)  // Only creates a thread when user post a query against a hostel
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

                        $thread = Threads::create([

                            'hostelId'  =>  $request->get('hostelId'),
                            'userId'    =>  $user->id,

                        ]);
                        
                        DB::commit();

                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['result']             = $thread;
                        $response['data']['message']    = 'Thread created Successfully';

                    } catch (Exception $e) {

                        DB::rollBack();
                    }
                }
            }
        return $response;
    }


    public function listStudentThreads(Request $request)
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

                try {

                    $threads = Threads::where('userId', '=', $request->userId)->get();
                    
                    foreach ($threads as $thread) {


                        $hostel          =  Hostel::where('id', '=', $thread->hostelId)->first();
                        $thumbnailImage  =  Images::where('hostelId', '=', $thread->hostelId)->where('isThumbnail', '=', 1)->first();
                        $hostelImages    =  Images::where('hostelId', '=', $thread->hostelId)->where('isThumbnail', '=', 0)->get();
                        $queries         =  Queries::select('id', 'message', 'type', 'threadId', 'hostelId')->where('threadId', '=', $thread->id)
                            ->where('hostelId', '=', $thread->hostelId)->get();



                        $hostelName             =  $hostel->hostelName;
                        $address                =  $hostel->address;
                        $thread['hostelName']   =  $hostelName;
                        $thread['address']      =  $address;



                        if (!empty($thumbnailImage && $hostelImages)) {

                            $imageName              =  $thumbnailImage->imageName;
                            $thread['imageName']    =  $imageName;
                            $thread['otherImages']  =  $hostelImages;

                        } else {

                            $thread['imageName'] = NULL;
                            $thread['otherImages'] = NULL;

                        }

                        $thread['queries'] = $queries;
                    }

                    if (!empty($threads)) {

                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Request Successfull';
                        $response['data']['result']     =  $threads;
                        $response['status']             =  true;

                    }

                } catch (Exception $e) {

                }
            }
        }
        return $response;
    }
}
