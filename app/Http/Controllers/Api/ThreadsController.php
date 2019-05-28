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
use App\Models\Api\ApiThreads as Threads;
use Exception;


class ThreadsController extends Controller
{


    /**
     *  List of all threads that contains queies against threads.
     * (minimum one query against a thread)
     * 
     *  @return  Threads
     */

    public function listThreads(Request $request)
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
            
            $queries = Queries::select('threadId')->distinct()->get();
            $threads = Threads::select('id')->get();


            /* 
                Super admin can view all threads/conversations. Conversations between registered user and 
                super admin. As we are creating a thread agaisnt every regeistered user while regestring 
                a user in StudentController, so we have to show just those threads to super admin
                that contain minimum one query/message in that thread. Super admin shouldn't see
                those threads that don't have any query/message against them. Below logic is 
                checking if a thread have minimum one query/message, then show that thread 
                to super admin.
            */

            DB::beginTransaction();
            
            try {

                $data = [];

                foreach ($threads as $value){
    
                    foreach ($queries as $query){
    
                        if ($value->id == $query->threadId){
    
                            $data[] = $queriesResults = Queries::select('id', 'message', 'type', 'threadId')->where('threadId', '=', $query->threadId)->get();
                            break;                        
                        }
                    }
                }
    
                if (!empty($data)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $data;
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
