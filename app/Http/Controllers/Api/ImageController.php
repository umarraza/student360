<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


//// JWT ////
use JWTAuthException;
use JWTAuth;

//// Models ////
use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiAdmin as Admin;
use App\Models\Api\ApiMyParent as MyParent;
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiParentStudent as ParentStudent;
use App\Models\Api\ApiParentInstitute as ParentInstitute;

class ImageController extends Controller
{
    public function updateProfileImage(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'error'     => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user))
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'image'          => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                DB::beginTransaction();
                try 
                {
                    $file_data = $request->input('image');

                    @list($type, $file_data) = explode(';', $file_data);
                    @list(, $file_data) = explode(',', $file_data); 
                    @list(, $type) = explode('/', $type); 
                    
                    $file_name = 'image_'.time().'.'.$type; //generating unique file name;
                    
                    if($file_data!="")
                    { 
                        \Storage::disk('public')->put($file_name,base64_decode($file_data)); 
                        
                        $user->avatarFilePath= $file_name;

                        if ($user->save())
                        {
                            DB::commit();
                            $response['data']['message']    = 'Request Successfull';
                            $response['data']['code']       = 200;
                            $response['data']['result']     = $user->avatarFilePath;
                            $response['status']             = true;
                        }
                    }
                    else
                    {
                        $response['data']['message'] = 'File Required';
                        $response['data']['code'] = 400;
                        $response['status'] = true;
                    }

                }
                catch (\Exception $e) 
                {
                   DB::rollBack();
                }
            }
        }
        return $response;
    }

    public function removeProfileImage(Request $request)
    {
    	$user = JWTAuth::toUser($request->token);
		$response = [
		      'data' => [
		          'code'      => 400,
		          'error'     => '',
		          'message'   => 'Invalid Token! User Not Found.',
		      ],
		      'status' => false
		  ];
		if(!empty($user)) 
		{
			DB::beginTransaction();
            try 
            {	
				$user->avatarFilePath = "default.jpg";
				if($user->save())
				{
					DB::commit();
					$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] = 200;
					$response['status'] = true;
				}
				else
				{
				   DB::rollBack();
				}
			}
			catch (\Exception $e) 
            {
               DB::rollBack();
            }
		}
		return $response;
    }

}
