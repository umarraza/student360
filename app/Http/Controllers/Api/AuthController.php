<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

//// JWT ////
use JWTAuthException;
use JWTAuth;

//// Models ////
use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiInstitute as Institute;
use App\Models\Api\ApiDeviceToken as DeviceToken;
use App\Models\MyCradential;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // inializing a default response in case of something goes wrong.
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid credentials or missing parameters',
                ],
                'status' => false
            ];



        // checking if parameters are set or not
        if(isset($request['username'],$request['password']))
        {

            // authenticate token from username and passwrod
            $credentials = $request->only('username', 'password');
            $token = null;
            try {
               if (!$token = JWTAuth::attempt($credentials)) 
               {
                    return [
                        'data' => [
                            'code' => 400,
                            'message' => 'Email or password wrong.',
                        ],
                        'status' => false
                    ];
               }
            } catch (JWTAuthException $e) {
                return [
                        'data' => [
                            'code' => 500,
                            'message' => 'Fail to create token.',
                        ],
                        'status' => false
                    ];
            }
            // Finding User from token.
            $user = JWTAuth::toUser($token);
            // Checking if user is valid or not.

            if($user->isDeleted==0)
            {
                if($user->isSuperAdmin())
                {
                    $response['data']['code']               = 300;
                    $response['data']['message']            = "Request Successfull!!";
                    $response['data']['token']              = User::loginUser($user->id,$token);
                    $response['data']['result']['userData'] = $user->getArrayResponse();
                    $response['status']= true;    
                }
                elseif($user->isAdmin())
                {
                    if($user->verified==0)
                    {
                        $response['data']['code']                   = 220;
                    }
                    else
                    {
                        $response['data']['code']                   = 200;
                    }
                    
                    $response['data']['message']                    = "Request Successfull!!";
                    $response['data']['token']                      = User::loginUser($user->id,$token);
                    $response['data']['result']['userData']         = $user->getArrayResponse();
                    $response['data']['result']['adminData']        = $user->admin->getArrayResponse();
                    $response['status']= true;    
                }
                elseif($user->isTrainer())
                {
                    if($user->verified==0)
                    {
                        $response['data']['code']                   = 220;
                    }
                    else
                    {
                        $response['data']['code']                   = 200;
                    }

                    $response['data']['code']                       = 200;
                    $response['data']['message']                    = "Request Successfull!!";
                    $response['data']['token']                      = User::loginUser($user->id,$token);
                    $response['data']['result']['userData']         = $user->getArrayResponse();
                    $response['data']['result']['trainerData']      = $user->trainer->getArrayResponse();
                    $response['status']= true;
                }
                elseif($user->isParent())
                {
                    if($user->verified==0)
                    {
                        $response['data']['code']                   = 220;
                    }
                    else
                    {
                        $response['data']['code']                   = 200;
                    }
                    
                    $response['data']['message']                    = "Request Successfull!!";
                    $response['data']['token']                      = User::loginUser($user->id,$token);
                    $response['data']['result']['userData']         = $user->getArrayResponse();
                    $response['data']['result']['parentData']       = $user->parent->getArrayResponse();
                    $response['status']= true;
                }
                
            }
            else
            {   
                // response if user is not valid.
                $response['data']['message'] = 'Not a valid user';
            }
        }
        return $response;
    }

    public function splashLogin(Request $request)
    {
        // validation user from token.
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user))
        {
            if($user->isSuperAdmin())
            {
                $response['data']['code']               = 300;
                $response['data']['message']            = "Request Successfull!!";
                $response['data']['result']['userData'] = $user->getArrayResponse();
                $response['status']= true;    
            }
            elseif($user->isAdmin())
            {
                $response['data']['code']                       = 200;
                $response['data']['message']                    = "Request Successfull!!";
                $response['data']['token']                      = User::loginUser($user->id,$token);
                $response['data']['result']['adminData']        = $user->admin->getArrayResponse();
                $response['status']= true;    
            }
            elseif($user->isTrainer())
            {
                $response['data']['code']                       = 200;
                $response['data']['message']                    = "Request Successfull!!";
                $response['data']['token']                      = User::loginUser($user->id,$token);
                $response['data']['result']['trainerData']      = $user->trainer->getArrayResponse();
                $response['status']= true;
            }
            elseif($user->isParent())
            {
                $response['data']['code']                       = 200;
                $response['data']['message']                    = "Request Successfull!!";
                $response['data']['token']                      = User::loginUser($user->id,$token);
                $response['data']['result']['parentData']       = $user->parent->getArrayResponse();
                $response['status']= true;
            }
        }
        return $response;
    }

    public function logout(Request $request){

        // validation user from token.
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user))
        {
            // if user is valid then expire its token.
            JWTAuth::invalidate($request->token);
            
            // if logout occur from mobile device then clear the device token.
            if($request->deviceType=="M")
            {
                $deviceToken = DeviceToken::where('deviceToken','=',$request->tokenValue)->delete();
            }

            $response['data']['message'] = 'Logout successfully.';
            $response['data']['code'] = 200;
            $response['status'] = true;
        }
        return $response;
    }

    public function updateUserDevice(Request $request)
    {
        // validation token.
        $user = JWTAuth::toUser($request->token);
        // generating default response if something gets wrong.
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user))
        {
            // rules to check weather paramertes comes or not.
            $rules = [
                'deviceToken' => 'required',
                'deviceType' => 'required|Numeric|in:0,1'
            ];
            // validating rules
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                // saving success response.
                $response['status'] = true;
                $response['data']['code'] = 200;
                $response['data']['message'] = 'Request Successfull.';
                $model = User::where('id','=',$user->id)->first();
                // updating token
                if(!empty($model)){
                    $checkToken  = DeviceToken::where('deviceToken','=',$request->deviceToken)->first();
                    if(empty($checkToken))
                    {
                        $model = DeviceToken::create([
                                'deviceToken' => $request->deviceToken,
                                'deviceType' => $request->deviceType,
                                'userId'    =>  $user->id
                        ]);
                        // updating token
                        if($model)
                        {
                        }
                        else
                        {
                            // in cans token update is unsuccessfull.
                            $response['data']['message'] = 'Device token not saved successfully. Please try again.';
                        }
                    }
                }
                else
                {
                    // in cans token update is unsuccessfull.
                    $response['data']['message'] = 'Device token not saved successfully. Please try again.';
                }
            }
        }
        return $response;
    }

    public function listRoles(Request $request)
    {
        // generating default response if something gets wrong.
        $response = [
                'data' => [
                    'error' => 400,
                    'message' => 'No data found.',
                ],
                'status' => false
            ];
        // Get all roles with the help of Roles model.
        $modelRoles = Roles::get();

        $response['data']['message'] = 'Request Successfull';
        $response['data']['error'] = 200;
        $response['data']['result'] = $modelRoles;
        $response['status'] = true;
        return $response;
    }

    // ========================================== Secrets ===============================//
    public function updateSecrets(Request $request)
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
                'secrets'         => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }
            else
            {   
                $mySecrets = base64_decode(base64_decode($request->secrets));
                $user->secrets = encrypt($mySecrets);

                if($user->save())
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Request Successfully';
                }
            }
        }
        return $response;
    }

    public function getSecrets(Request $request)
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
        if(!empty($user))
        {
            $mySecrets = base64_encode(base64_encode(decrypt($user->secrets)));

            $response['data']['code']       = 200;
            $response['status']             = true;
            $response['data']['result']     = $mySecrets;
            $response['data']['message']    = 'Request Successfully';
                
        }
        return $response;
    }

    public function superAdminGetSecret(Request $request)
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
            $myCradential   = MyCradential::find(1);

            $response['data']['code']                           = 200;
            $response['status']                                 = true;
            $response['data']['result']                         = $myCradential;
            $response['data']['message']                        = 'Request Successfull';
        }
        return $response;
    }

    public function superAdminUpdateSecret(Request $request)
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
                'keysST'           => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $myCradential   = MyCradential::find(1);

                $myCradential->keysST = $request->keysST;
                if($myCradential->save())
                {
                    $response['data']['code']                           = 200;
                    $response['status']                                 = true;
                    $response['data']['result']                         = $myCradential;
                    $response['data']['message']                        = 'Request Successfull';
                }
                else
                {
                    $response['data']['code']                           = 400;
                    $response['status']                                 = true;
                    $response['data']['result']                         = $myCradential;
                    $response['data']['message']                        = 'Request Successfull';   
                }
            }
        }
        return $response;
    }
}
