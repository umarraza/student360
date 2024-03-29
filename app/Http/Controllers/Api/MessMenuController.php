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
use App\Models\Api\ApiMessMenuMeal as MessMenuMeal;
use App\Models\Api\ApiMessMenuTiming as MessMenuTiming;
use App\Models\Api\ApiUpdateRequests as UpdateRequests;
use Exception;

class MessMenuController extends Controller
{
    /**
     * UPDATE MESS MENU
     *
     * Hostel admin can update mess menu of his hotel
     *
     * @return function
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

            $rules = [

            	'breakFastMeal'     =>  'required',
            	'lunchMeal'         =>  'required',
            	'dinnerMeal'        =>  'required',
                'hostelId'          =>  'required',
                'id'                =>  'required'

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                DB::beginTransaction();
                try {

                    $lunchMeal  =  $request->get('lunchMeal');
                    $dinnerMeal   =  $request->get('dinnerMeal');
                    $breakFastMeal  =  $request->get('breakFastMeal');

                    $hostelId = $request->hostelId;
                    $messMenu =  MessMenuMeal::where('hostelId', '=', $hostelId)->get();

                    $updateMessMenu =  MessMenuMeal::where('id', '=', $request->id)->update([
                            
                        'breakFastMeal' =>  $breakFastMeal,
                        'lunchMeal'     =>  $lunchMeal,
                        'dinnerMeal'    =>  $dinnerMeal,
    
                    ]);
    
                    if ($updateMessMenu) {

                        DB::commit();

                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Mess Menu Updated Successfully!';
                        $response['status']             =  true;
    
                    }

                } catch (Exception $e) {

                    DB::rollBaack();
                    throw $e;

                }
            }
        }
        return $response;
    }


    public function updateMessMenuTimePrice(Request $request)
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

            $rules = [

            	'brkfastStartTime'  =>  'required',
            	'brkfastEndTime'    =>  'required',
            	'lunchStartTime'    =>  'required',
            	'lunchEndTime'      =>  'required',
            	'dinnerStartTime'   =>  'required',
            	'dinnerEndTime'     =>  'required',
            	// 'isSetBreakFast'    =>  'required',
            	// 'isSetLunch'        =>  'required',
            	// 'isSetDinner'       =>  'required',
                'hostelId'          =>  'required',
                // 'id'                =>  'required'

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                DB::beginTransaction();
                try {

                    // $isSetLunch        =   $request->get('isSetLunch');
                    // $isSetDinner       =   $request->get('isSetDinner');
                    $lunchEndTime      =   $request->get('lunchEndTime');
                    $brkfastEndTime    =   $request->get('brkfastEndTime');
                    $brkfastStartTime  =   $request->get('brkfastStartTime');
                    $dinnerEndTime     =   $request->get('dinnerEndTime');
                    // $isSetBreakFast    =   $request->get('isSetBreakFast');
                    $lunchStartTime    =   $request->get('lunchStartTime');
                    $dinnerStartTime   =   $request->get('dinnerStartTime');
                    $price             =   $request->get('price');
                    $hostelId          =   $request->get('hostelId');

                    $updateMenuTiming = MessMenuTiming::where('hostelId', '=', $hostelId)->update([
    
                        'brkfastStartTime' =>  $brkfastStartTime,
                        'brkfastEndTime'   =>  $brkfastEndTime,
                        'lunchStartTime'   =>  $lunchStartTime,
                        'lunchEndTime'     =>  $lunchEndTime,
                        'dinnerStartTime'  =>  $dinnerStartTime,
                        'dinnerEndTime'    =>  $dinnerEndTime,
                        // 'isSetBreakFast'   =>  $isSetBreakFast,
                        // 'isSetLunch'       =>  $isSetLunch,
                        // 'isSetDinner'      =>  $isSetDinner,
                        'price'            =>  $price,
    
                    ]);

                    if ($updateMenuTiming) {

                        DB::commit();

                        $response['data']['code']       =  200;
                        $response['data']['message']    =  'Mess Menu Updated Successfully!';
                        $response['status']             =  true;
    
                    }

                } catch (Exception $e) {

                    DB::rollBack();
                    throw $e;

                }
            }
        }
        return $response;
    }

    /**
     * MESS MENU LIST
     *
     * List of Mess Menu to show
     *
     * @return function
     */

    public function showMessMenu(Request $request)
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

            $rules = [

            	'hostelId' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            } else {

                $hostelId = $request->get('hostelId');

                try {

                    $messMenu = MessMenuMeal::select(
                    
                        'id', 
                        'day', 
                        'breakFastMeal', 
                        'lunchMeal', 
                        'dinnerMeal', 
                        'hostelId')
                        
                        ->where('hostelId', '=', $hostelId)
                        ->get();
    
                    $messMenuTiming = MessMenuTiming::select(
                        
                        'id', 
                        'brkfastStartTime', 
                        'brkfastEndTime', 
                        'lunchStartTime', 
                        'lunchEndTime', 
                        'dinnerStartTime', 
                        'dinnerEndTime' , 
                        // 'isSetBreakFast' , 
                        // 'isSetLunch', 
                        // 'isSetDinner', 
                        'hostelId',
                        'price'
                        
                        )
                        
                        ->where('hostelId', '=', $hostelId)
                        ->first();

                        if (!empty($messMenu && $messMenuTiming)) {

                            $response['data']['code']            =  200;
                            $response['data']['message']         =  'Request Successfull';
                            $response['data']['result']          =  $messMenu;
                            $response['data']['messMenuTiming']  =  $messMenuTiming;
                            $response['status']                  =  true;
        
                        }

                }catch (Exception $e) {
                    
                    throw $e;   
                }
            }
        }
        return $response;
    }
}
