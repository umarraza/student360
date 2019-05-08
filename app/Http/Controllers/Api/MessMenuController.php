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
use App\Models\Api\ApiUpdateRequests as UpdateRequests;

use App\Models\Api\ApiMessMenu as MessMenu;

class MessMenuController extends Controller
{
    /**
     * UPDATE MESS MENU
     *
     * Hostel admin can update mess menu of his hotel
     *
     * @function
     */

    public function updateMessMenu(Request $request)
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

        if(!empty($user) && $user->isHostelAdmin())
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            

            $breakFastTiming = $request->get('breakFastTiming');
            $dinnerTiming = $request->get('dinnerTiming');

            $updateMessMenu =  MessMenu::find($request->id)->update([
                    
                'breakFastTiming'  =>  $breakFastTiming,
                'dinnerTiming'  =>  $dinnerTiming,

            ]);


            if ($updateMessMenu) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'Requst Unsuccessfull';
                $response['status']             =  false;    
            }


        }
        return $response;
    }

    /**
     * MESS MENU LIST
     *
     * List of Mess Menu to show
     *
     * @function
     * 
     */

    public function listMessMenu(Request $request)
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

        if(!empty($user) && $user->isHostelAdmin())
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $listOfMessMenu = MessMenu::all();
            
            // If there are thousands of hostels, getting the list with all parameters will put load to server as well as network. ask musab if we can select just few fields. 

            if (!empty($listOfMessMenu)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $listOfMessMenu;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;    
            }

        }
        return $response;
    }
}
