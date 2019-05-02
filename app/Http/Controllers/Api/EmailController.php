<?php

namespace App\Http\Controllers\Api;

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
use App\Models\Api\ApiPackage as Package;

class EmailController extends Controller
{
    public function mailSingleInstitute(Request $request)
    {
    	$user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
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
                'subject'     		=> ['required'],
                'instituteId'		=> ['required'],
                'content'	     	=> ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
            	$admin = Admin::where('instituteId',$request->instituteId)->first();

            	$subject = $request->subject;
            	$content = $request->content;
            	
                if($admin->user->sendGeneralEmail($subject,$content));
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Request Successfull';
                }
            }
        }
        return $response;
    }

    public function mailMultipleInstitutes(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
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
                'subject'           => ['required'],
                'instituteIds'      => ['required'],
                'content'           => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $subject = $request->subject;
                $content = $request->content;
                
                $arrLength  = sizeof(json_decode($request->instituteIds));
                $membersArr = json_decode($request->instituteIds);

                for($i=0 ; $i<$arrLength ; $i++)
                {
                    $admin = Admin::where('instituteId',$request->instituteId)->first();
                    $admin->user->sendGeneralEmail($subject,$content);
                }

                
                $response['data']['code']       = 200;
                $response['status']             = true;
                $response['data']['message']    = 'Request Successfull';
            }
        }
        return $response;
    }

    public function mailSingleParent(Request $request)
    {
    	$user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
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
                'subject'     	=> ['required'],
                'studentId'		=> ['required'],
                'content'	    => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
            	$parentStudent  = ParentStudent::where('studentId',$request->studentId)->first();
                $parent         = MyParent::find($parentStudent->parentId);
                $parentUser     = User::find($parent->userId); 
            	
                $subject = $request->subject;
            	$content = $request->content;
            	
                if($parentUser->sendGeneralEmail($subject,$content));
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Request Successfull';
                }
            }
        }
        return $response;
    }

    public function mailMultipleParents(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
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
                'subject'           => ['required'],
                'studentIds'        => ['required'],
                'content'           => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $subject = $request->subject;
                $content = $request->content;
                
                $arrLength  = sizeof(json_decode($request->studentIds));
                $membersArr = json_decode($request->studentIds);

                for($i=0 ; $i<$arrLength ; $i++)
                {
                    $parentStudent  = ParentStudent::where('studentId',$membersArr[$i])->first();
                    $parent         = MyParent::find($parentStudent->parentId);
                    $parentUser     = User::find($parent->userId); 

                    $parentUser->sendEmailCustomer($subject,$content);
                }

                
                $response['data']['code']       = 200;
                $response['status']             = true;
                $response['data']['message']    = 'Request Successfull';
            }
        }
        return $response;
    }
}
