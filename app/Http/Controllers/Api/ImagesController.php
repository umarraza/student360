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
use App\Models\Api\ApiImages as Images;

class ImagesController extends Controller
{

    /**
     * CREATE IMAGES
     *
     * Hostel Admin can upload imgaes of his hostel. One thumbnail
     * image and others are simple images.
     * 
     * @function
     */


    public function createHostelImages(Request $request)
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

                'base64ImageData'   =>  'required',
                'hostelId'          =>  'required',
                'isThumbnail'       =>  'required',

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

                        $image = Images::create([

                            'imageName'  => $file_name,
                            'isThumbnail'=> $request->get('isThumbnail'),
                            'hostelId'   => $request->get('hostelId'),
    
                        ]);

                        DB::commit();
                        $response['data']['message'] = 'Image created Successfully';
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


    /**
     * UPDATE IMAGES
     *
     * Hostel Admin can upload thumbnail imgae of his hostel. 
     * 
     * @function
     */


    public function updateThumbnailImage(Request $request)
    {
        // return $request;
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

                'id'                =>  'required',
                'base64ImageData'   =>  'required',
                'hostelId'          =>  'required',
                'isThumbnail'       =>  'required',

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

                        $image = Images::find($request->id)->update([

                            'imageName'  => $file_name,
                            'isThumbnail'=> $request->get('isThumbnail'),
                            'hostelId'   => $request->get('hostelId'),
    
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
    public function listImages(Request $request)
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
            
            /** 
             *  SELECT * FROM Images WHERE hostel_id = '1' OR hostel_id = '2' OR hostel_id = '3'
             *  SELECT * FROM Images WHERE hostel_id IN ('1', '1', '3') -> whereIn() for Laravel
             *  SELECT * FROM Images WHERE hostel_id NOT IN ('1', '1', '3') -> whereNotIn() for Laravel
             * 
             */


            DB::beginTransaction();
            try {

                $images = Images::select('imageName', 'hostelId')
                ->where('hostelId', '=', $request->hostelId)
                ->get();

                // $images = Images::select('imageName', 'hostelId')
                // ->whereBetween('hostelId', [1,4])
                // ->orderBy('hostelId', 'asc')
                // ->limit(4)
                // ->get();

                if (!empty($images)) {

                    $response['data']['code']       =  200;
                    $response['data']['message']    =  'Request Successfull';
                    $response['data']['result']     =  $images;
                    $response['status']             =  true;
    
                }

            } catch (Exception $e) {

                DB::rollBack();
                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;

            }
        }
        return $response;
    }
}
