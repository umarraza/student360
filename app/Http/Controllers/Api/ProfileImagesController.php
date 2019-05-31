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
use App\Models\Api\ApiProfileImages as ProfileImages;
use Exception;


class ProfileImagesController extends Controller
{
    public function createImage(Request $request)
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

                'base64ImageData'  =>  'required',
                'userId'  =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
              
            }
            else
            {
                $file_data   =  $request->get('base64ImageData');

                @list($type, $file_data) = explode(';', $file_data);
                @list(, $file_data) = explode(',', $file_data);
                @list(, $type) = explode('/', $type);

                $file_name = 'image_'.time().'.'.$type;

                if ($file_data!="")
                { 
                    
                    $userId = $user->id;

                    \Storage::disk('public')->put($file_name,base64_decode($file_data));

                    DB::beginTransaction();
                    
                    try {

                        $image = ProfileImages::create([

                            'imageName' => $file_name,
                            'userId' => $userId,
    
                            ]);

                            DB::commit();

                            $response['data']['message'] = 'Image created Successfully';
                            $response['data']['code'] = 200;
                            $response['data']['result'] = $image;
                            $response['status'] = true;

                    } catch (Exception $e) {

                        DB::rollBack();
                        
                        $response['data']['message'] = 'Request Unsuccessfull';
                        $response['data']['code'] = 400;
                        $response['status'] = true;

                    }
                }
                else
                {

                    $response['data']['message'] = 'File Required';
                    $response['data']['code'] = 400;
                    $response['status'] = false;
                }
            }
        }    
        return $response;
    }

    /**
     * UPDATE IMAGES
     * Hostel Admin can upload thumbnail imgae of his hostel. 
     * 
     * @return image
     */


    public function updateProfileImage(Request $request)
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

                'id'                =>  'required',
                'base64ImageData'   =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }
            else
            {
                $file_data   =  $request->get('base64ImageData');

                @list($type, $file_data) = explode(';', $file_data);
                @list(, $file_data) = explode(',', $file_data);
                @list(, $type) = explode('/', $type);

                $file_name = 'image_'.time().'.'.$type; 

                if($file_data!="")
                { 
                    
                    \Storage::disk('public')->put($file_name,base64_decode($file_data));

                    DB::beginTransaction();
                    try {

                        $image = ProfileImages::find($request->id)->update([

                            'imageName'  => $file_name,

                        ]);

                        DB::commit();

                        $response['data']['message'] = 'Image Updated Successfully';
                        $response['data']['code'] = 200;
                        $response['data']['result'] = $image;
                        $response['status'] = true;


                    } catch (Exception $e) {

                        DB::rollBack();
                        $response['data']['message'] = 'Request to create image falied!';
                        $response['data']['code'] = 400;
                        $response['status'] = false;
                    }
                }
                else
                {
                    $response['data']['message'] = 'File Required';
                    $response['data']['code'] = 400;
                    $response['status'] = false;
                }
            }
        }    
        return $response;
    }
}
