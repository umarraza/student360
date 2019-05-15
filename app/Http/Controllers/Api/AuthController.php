<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use App\Http\Requests;
use App\Http\Controllers\Controller;

/* ---------- JWT ---------- */

use JWTAuthException;
use JWTAuth;

/* ---------- MODELS ---------- */
use App\Models\Roles;
use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiHostel as Hostel;

use App\Models\Api\ApiUserDetail as UserDetail;

class AuthController extends Controller
{

    public function signUp(Request $request)
    {

        $response = [
            'data' => [
                'code' => 400,
                'message' => 'Something went wrong. Please try again later!',
            ],
           'status' => false
        ];
        $rules = [
            
            'username'    =>   'required',
            'password'    =>   'required',
            'roleId'      =>   'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data']['message'] = 'Invalid input values.';
            $response['data']['errors'] = $validator->messages();
        }
        else
        {
            $username = $request->get('username');
            $password = $request->get('password');
            $roleId   = $request->get('roleId');

            $modelUser =  User::create([
                'username'  => $username,
                'password'  => bcrypt($password),
                'roleId'    => $roleId,
                'verified'  => User::STATUS_ACTIVE,
                'language'  => "English",
            ]);

            if($modelUser)
            {
                if(isset($request['username'],$request['password']))
                {
                    $credentials = $request->only('username', 'password');

                    $token = null;
                    try {
                       if (!$token = JWTAuth::attempt($credentials)) {
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
                    if($user->verified == 1)
                    {
                        if($user->isSuperAdmin())
                        {
                            $response['data']['code']               =   200;
                            $response['data']['message']            =   "Request Successfull!!";
                            $response['data']['token']              =   User::loginUser($user->id,$token);
                            $response['data']['result']['userData'] =   $user->getArrayResponse();
                            $response['status']= true;    
                        }
                        elseif($user->isHostelAdmin())
                        {
                            $response['data']['code']                =   200;
                            $response['data']['message']             =   "Request Successfull!!";
                            $response['data']['token']               =   User::loginUser($user->id,$token);
                            $response['data']['result']['userData']  =   $user->getArrayResponse();
                            $response['status']= true;    
                        }
                        elseif($user->isStudent())
                        {
                            $response['data']['code']                =   200;
                            $response['data']['message']             =   "Request Successfull!!";
                            $response['data']['token']               =   User::loginUser($user->id,$token);
                            $response['data']['result']['userData']  =   $user->getArrayResponse();
                            $response['status']= true;    
                        }
                    }
                    else
                    {   
                        $response['data']['message'] = 'Not a valid user';
                    }
                }
            }
        }
        return $response;
    }



    public function login(Request $request)
    {
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid credentials or missing parameters',
                ],
                'status' => false
            ];
        if(isset($request['username'],$request['password']))
        {

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

            $user = JWTAuth::toUser($token);

            if($user->verified == 1)
            {
                if($user->isSuperAdmin())
                {
                    $response['data']['code']               = 300;
                    $response['data']['message']            = "Request Successfull!!";
                    $response['data']['token']              = User::loginUser($user->id,$token);
                    $response['data']['result']['userData'] = $user->getArrayResponse();
                    $response['status']= true;   

                }
                elseif($user->isHostelAdmin())
                {
                    $hostel = Hostel::where('userId', '=', $user->id)->first();
                    $hostelId = $hostel->id;

                    if($user->verified==0)
                    {
                        $response['data']['code']     =  400;
                        $response['data']['message']  =  "Request Unsuccessfull!!";
                        $response['status']= true;    

                    }
                    else
                    {
                        $response['data']['code']                   = 200;
                    }

                    $response['data']['message']              =   "Request Successfull!!";
                    $response['data']['token']                =   User::loginUser($user->id,$token);
                    $response['data']['result']['userData']   =   $user->getArrayResponse();
                    $response['data']['result']['hostelId']   =   $hostelId;
                    $response['status']= true;    
                }
                elseif($user->isStudent())
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
                    $response['status']= true;
                }
            }
            else
            {   
                $response['data']['code'] = 400;
                $response['data']['message'] = 'Sorry! Your request to register a new hostel is not approved yet by administrator!';
                $response['status']= false;
            }
        }
        return $response;
    }


  // ---------- New Login ---------- //

    public function login2(Request $request)
    {
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid credentials or missing parameters',
                ],
                'status' => false
            ];

        if(isset($request['username'],$request['password'])){

            $credentials = $request->only('username', 'password');

            $token = null;
            try {
               if (!$token = JWTAuth::attempt($credentials)) {
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
            if($user->isValidUser())
            {
                if($user->isSuperAdmin())
                {
                    $response['data']['code']                 =  200;
                    $response['data']['message']              =  "Request Successfull!!";
                    $response['data']['token']                =  User::loginUser($user->id,$token);
                    $response['data']['result']['userData']   =  $user->getArrayResponse();
                    $response['status']= true;    
                }
                elseif($user->isHostelAdmin())
                {
                    $response['data']['code']                 =  200;
                    $response['data']['message']              =  "Request Successfull!!";
                    $response['data']['token']                =  User::loginUser($user->id,$token);
                    $response['data']['result']['userData']   =  $user->getArrayResponse();
                    $response['status']= true;    
                }
                elseif($user->isStudent())
                {
                    $response['data']['code']                 =  200;
                    $response['data']['message']              =  "Request Successfull!!";
                    $response['data']['token']                =  User::loginUser($user->id,$token);
                    $response['data']['result']['userData']   =  $user->getArrayResponse();
                    $response['status']= true;    
                }
            }
            else
            {   
                $response['data']['message'] = 'Not a valid user';
            }
        }
        return $response;
    }

    public function forgotPass(Request $request)
    {
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'username'   =>  ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors']  = $validator->messages();
            }
            else
            {
                $user = User::where('username','=',$request['username'])->first();
                $userId = $user->id;
                $username = $user->username;
                           
                $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
                $password = substr($random, 0, 10);
                
                $tousername = $username;

                \Mail::send('mail',["username"=>$username, "userId"=>$userId,"password"=>$password], function ($message) use ($tousername) {
                $message->from('umarraza2200@gmail.com', 'password');
                $message->to($tousername)->subject('Forgot Password!');

               });
             
                if ($user) 
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['result']     = $user;
                    $response['data']['message']    = 'Forgot Password email send successfuly';
                }
            }
        return $response;
    }

    public function changePassword(Request $request)
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
                'oldPassword'     =>  ['required'],
                'newPassword'     =>  ['required'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors']  = $validator->messages();
            }
            else
            {

                $userId = $user->id;
                $myUser = User::where('id','=', $userId)->first();

                $oldPassword  =  $request['oldPassword'];
                $newPassword  =  $request['newPassword'];

                if(Hash::check($oldPassword, $myUser->password))
                {
                    $myUser->password = bcrypt($newPassword);
                    if($myUser->save())
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['message']    = 'Password changed successfully';
                    }
                    else
                    {
                        $response['data']['code']       = 400;
                        $response['status']             = true;
                        $response['data']['message']    = 'Request Unsuccessfull';
                    }
                }
                else
                {
                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Old password is wrong';
                }    
            }
        }
        return $response;
    }
    

    public function logout(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user)){

            JWTAuth::invalidate($request->token);
            
            // if logout occur from mobile device then clear the device token.
            // if($request->deviceType=="M")
            //     $user->clearDeviceToken();

            $response['data']['message'] = 'Logout successfully.';
            $response['data']['code'] = 200;
            $response['status'] = true;
        }
        return $response;
    }

    public function updateUserDevice(Request $request){
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
        if(!empty($user)){

            $rules = [
                'deviceToken' => 'required',
                'deviceType' => 'required|Numeric|in:0,1'
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
            
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            
            } else {

                $response['status'] = true;
                $response['data']['code'] = 200;
                $response['data']['message'] = 'Request Successfull.';
                $model = User::where('id','=',$user->id)->first();
                
                // updating token
                
                if(!empty($model)){
                    
                    $model->update([
                        'deviceToken' => $request->deviceToken,
                        'deviceType' => $request->deviceType
                    ]);
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

    public function getRoles(Request $request)
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

    

    // Update Online Status for User
    public function updateOnlineStatus(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        // generating default response if something gets wrong.
        $response = [
                'data' => [
                    'code'      => 400,
                    'error'     => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        // checking if user exists or not
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
               'status'   => ['required', 'in:0,1']
            ];
            // valiating that weather status comes from front-end or not And its value should be in 0,1
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $response['status'] = true;
                $response['data']['code'] = 401;
                $isSaved = User::where('id','=',$user->id)
                                ->update(['onlineStatus' => $request->status]);
                // updating status in db and if successfully updated send success response.
                if($isSaved){
                    $response['data']['code'] = 200;
                    $response['data']['message'] = 'Request Successfull';
                }
            }
        }   
        return $response;
    }


    public function splashLogin(Request $request)
    {
        // Login Api for mobile when on splash screen.
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
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

            if($user->isResponder()){
                    
                $response['data']['user'] = base64_encode(json_encode($user->responder->getResponseData()));
                $response['data']['school'] = base64_encode(json_encode($user->responder->schoolProfile->schoolAdminProfile->getResponseData()));
            }
            elseif($user->isStudent()){
                $response['data']['user'] = base64_encode(json_encode($user->student->getResponseData()));
                $response['data']['school'] = base64_encode(json_encode($user->student->schoolProfile->schoolAdminProfile->getResponseData()));
            }
            $response['data']['code'] = 200;
            $response['data']['message'] = 'Request Successfull';
            $response['data']['code'] = 200;
            $response['status']= true;
        }
        return $response;
    }
}
