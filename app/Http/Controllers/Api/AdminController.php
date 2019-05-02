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
use App\Models\Api\ApiInstitute as Institute;
use App\Models\Api\ApiMyParent as MyParent;
use App\Models\Api\ApiStudent as Student;
use App\Models\Api\ApiParentStudent as ParentStudent;
use App\Models\Api\ApiParentInstitute as ParentInstitute;
use App\Models\Api\ApiPackage as Package;
use App\Models\Api\ApiPaymentHistory as PaymentHistory;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function instituteSignup(Request $request)
    {
        $response = [
            'data' => [
                'code' => 400,
               	'message' => 'Something went wrong. Please try again later!',
            ],
           'status' => false
        ];
        $rules = [
           'username'       => ['required', 'email', 'max:191', Rule::unique('users')],
           'password'       => ['required'],
           'firstName'      => ['required'],
           'lastName'       => ['required'],
           'name'           => ['required'],
           'description'    => ['required'],
           'address'        => ['required'],
           'packageId'      => ['required'],
           // 'longitude'      => ['required'],
           // 'latitude'       => ['required'],
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
                $rolesId = Roles::findByAttr('label',User::USER_ADMIN)->id;
                // First Enter Data in users Table
                $user = User::create([
                    'username'  => $request->get('username'),
                    'password'  => bcrypt($request->password),
                    'roleId'    => $rolesId,
                    'verified'  => User::STATUS_ACTIVE,
                    'language'  => "English",
                ]);
                $institute = Institute::create([
                    'name'              => $request->get('name'),
                    'address'           => $request->get('address'),
                    'description'       => $request->get('description'),
                    'packageId'         => $request->get('packageId'),
                ]);
                $instituteAdmin = Admin::create([
                    'userId'            => $user->id,
                    'firstName'         => $request->get('firstName'),
                    'lastName'          => $request->get('lastName'),
                    'type'              => 0,
                    'instituteId'       => $institute->id,
                ]);

                $packageDetail = Package::find($request->packageId);
                if($packageDetail->id == 1)
                {
                    $lastPaymentMade = Carbon::now()->format('Y-m-d H:i:s');

                    if($packageDetail->unitType == 1)
                    {
                        $numberOfUnits = $packageDetail->numberOfUnits;
                        $nextPaymentDue = Carbon::now()->addDay($numberOfUnits)->format('Y-m-d H:i:s');
                    }
                    elseif($packageDetail->unitType == 2)
                    {
                        $numberOfUnits = $packageDetail->numberOfUnits;
                        $nextPaymentDue = Carbon::now()->addMonth($numberOfUnits)->format('Y-m-d H:i:s');
                    }
                    elseif($packageDetail->unitType == 3)
                    {
                        $numberOfUnits = $packageDetail->numberOfUnits;
                        $nextPaymentDue = Carbon::now()->addYear($numberOfUnits)->format('Y-m-d H:i:s');
                    }
                    
                    $nextPaymentAmount = 0;
                    $lastPaymentAmount = 0;

                    $institute->lastPaymentMade    = $lastPaymentMade;
                    $institute->nextPaymentDue     = $nextPaymentDue;
                    $institute->nextPaymentAmount  = $nextPaymentAmount;
                    $institute->lastPaymentAmount  = $lastPaymentAmount;

                    $institute->save();

                    // Signup Success Mails //
                    instituteSignup($user->id);
                    //////////////////////////

                    $response['data']['message'] = 'Request Successfull';
                    $response['data']['code'] = 200;
                    $response['status'] = true;
                }
                else
                {
                    $mySecrets = base64_decode(base64_decode($request->secrets));
                    $user->secrets = encrypt($mySecrets);
                    $user->save();

                    if($user->makePayment($packageDetail->price))
                    {
                        $lastPaymentMade = Carbon::now()->format('Y-m-d H:i:s');

                        if($packageDetail->unitType == 1)
                        {
                            $numberOfUnits   = $packageDetail->numberOfUnits;
                            $nextPaymentDue = Carbon::now()->addDay($numberOfUnits)->format('Y-m-d H:i:s');
                        }
                        elseif($packageDetail->unitType == 2)
                        {
                            $numberOfUnits   = $packageDetail->numberOfUnits;
                            $nextPaymentDue = Carbon::now()->addMonth($numberOfUnits)->format('Y-m-d H:i:s');
                        }
                        elseif($packageDetail->unitType == 3)
                        {
                            $numberOfUnits   = $packageDetail->numberOfUnits;
                            $nextPaymentDue = Carbon::now()->addYear($numberOfUnits)->format('Y-m-d H:i:s');
                        }
                        
                        $nextPaymentAmount = $packageDetail->price;
                        $lastPaymentAmount = $packageDetail->price;

                        $institute->lastPaymentMade    = $lastPaymentMade;
                        $institute->nextPaymentDue     = $nextPaymentDue;
                        $institute->nextPaymentAmount  = $nextPaymentAmount;
                        $institute->lastPaymentAmount  = $lastPaymentAmount;

                        $paymentHistory = PaymentHistory::create([
                                                            "paymentDateTime" => $lastPaymentMade,
                                                            "amountPaid"      => $lastPaymentAmount,
                                                            "instituteId"     => $institute->id,
                                                        ]);
                        $institute->save();

                        // Signup Success Mails //
                        instituteSignup($user->id);
                        //////////////////////////

                        $response['data']['message'] = 'Request Successfull';
                        $response['data']['code'] = 200;
                        $response['status'] = true;  
                    }
                    else
                    {
                        $lastPaymentMade = Carbon::now()->format('Y-m-d H:i:s');

                        if($packageDetail->unitType == 1)
                        {
                            $numberOfUnits   = $packageDetail->numberOfUnits;
                            $nextPaymentDue = Carbon::now()->addDay($numberOfUnits)->format('Y-m-d H:i:s');
                        }
                        elseif($packageDetail->unitType == 2)
                        {
                            $numberOfUnits   = $packageDetail->numberOfUnits;
                            $nextPaymentDue = Carbon::now()->addMonth($numberOfUnits)->format('Y-m-d H:i:s');
                        }
                        elseif($packageDetail->unitType == 3)
                        {
                            $numberOfUnits   = $packageDetail->numberOfUnits;
                            $nextPaymentDue = Carbon::now()->addYear($numberOfUnits)->format('Y-m-d H:i:s');
                        }
                        
                        $nextPaymentAmount = 0;
                        $lastPaymentAmount = 0;

                        $institute->packageId          = 1;
                        $institute->lastPaymentMade    = $lastPaymentMade;
                        $institute->nextPaymentDue     = $nextPaymentDue;
                        $institute->nextPaymentAmount  = $nextPaymentAmount;
                        $institute->lastPaymentAmount  = $lastPaymentAmount;

                        $institute->save();

                        // Signup Success Mails //
                        instituteSignup($user->id);
                        //////////////////////////

                        $response['data']['message'] = 'Payment Unsuccessfull. Package Shifted to Free Version';
                        $response['data']['code'] = 201;
                        $response['status'] = true;        
                    }
                    
                }
                DB::commit();
            }
            catch (\Exception $e) 
            {
               DB::rollBack();
            }
        }
        return $response;
    }

    public function updateInstituteDetails(Request $request)
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
                'id'             => ['required'],
                'name'           => ['required'],
                'description'    => ['required'],
                'address'        => ['required'],
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
                    $institute = Institute::where('id',$request->id)->update([
                                        'name'              => $request->get('name'),
                                        'description'       => $request->get('description'),
                                        'address'           => $request->get('address'),
                                    ]);
                    if($institute)
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
        }
        return $response;
    }

    public function updateAdminDetails(Request $request)
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
                'firstName'   => ['required'],
                'lastName'    => ['required'],
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
                    $admin = Admin::where('id',$user->admin->id)
                                    ->update([
                                        'firstName'      => $request->get('firstName'),
                                        'lastName'       => $request->get('lastName'),
                                    ]);
                    if($admin)
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
        }
        return $response;
    }

    public function addSecondaryAdmin(Request $request)
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
                'username'       => ['required', 'email', 'max:191', Rule::unique('users')],
                'firstName'      => ['required'],
                'lastName'       => ['required'],
                'instituteId'    => ['required'],
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
                    $randomPassword = '953674';
                    $rolesId = Roles::findByAttr('label',User::USER_ADMIN)->id;
                    $user = User::create([
                        'username'  => $request->get('username'),
                        'password'  => bcrypt($randomPassword),
                        'roleId'    => $rolesId,
                        'verified'  => User::STATUS_INACTIVE,
                        'language'  => "English",
                    ]);
                    $instituteAdmin = Admin::create([
                        'userId'            => $user->id,
                        'firstName'         => $request->get('firstName'),
                        'lastName'          => $request->get('lastName'),
                        'type'              => 1,
                        'instituteId'       => $request->instituteId,
                    ]);

                    DB::commit();

                    // Secondary Admin Signup Success Mails ////////
                    secondaryAdminSignup($user->id,$randomPassword);
                    ////////////////////////////////////////////////
                    $response['data']['message'] = 'Request Successfull';
                    $response['data']['code'] = 200;
                    $response['status'] = true;
                }
                catch (\Exception $e) 
                {
                   DB::rollBack();
                }
            }
        }
        return $response;
    }

    public function updateSecondaryAdmin(Request $request)
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
                'id'             => ['required'],
                'firstName'      => ['required'],
                'lastName'       => ['required'],
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
                    $instituteAdmin = Admin::where('id',$request->id)->update([
                        'firstName'         => $request->get('firstName'),
                        'lastName'          => $request->get('lastName'),
                    ]);

                    if($instituteAdmin)
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
        }
        return $response;
    }

    public function listSecondaryAdmins(Request $request)
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
                'id'             => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                try 
                {
                    $secondaryAdmins = Admin::where('instituteId',$request->id)
                                            ->where('type',1)
                                            ->get();

                    $response['data']['message'] = 'Request Successfull';
                    $response['data']['code'] = 200;
                    $response['data']['result'] = $secondaryAdmins;
                    $response['status'] = true;
                }
                catch (\Exception $e) 
                {
                }
            }
        }
        return $response;
    }
    public function deleteSecondaryAdmin(Request $request)
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
                'id'         => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }
            else
            {
                try 
                {   
                    $secondaryAdmin = Admin::find($request->id);
                    $userModel  = User::where('id',$secondaryAdmin->userId)->update([
                                                                        "isDeleted" => 1,
                                                                        //"verified"  => 0,
                                                                    ]);
                    if($userModel)
                    {
                        // Deletion Mails //
                        ////////////////////

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
        }
        return $response;
    }

    public function reactiveSecondaryAdmin(Request $request)
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
                'id'         => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }
            else
            {
                try 
                {   
                    $secondaryAdmin = Admin::find($request->id);
                    $userModel      = User::where('id',$secondaryAdmin->userId)->update([
                                                                        "isDeleted" => 0,
                                                                        //"verified"  => 1,
                                                                    ]);
                    if($userModel)
                    {

                        // Reactive Mails //
                        ///////////////////

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
        }
        return $response;
    }

    public function updateInstituteImage(Request $request)
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
                'id'            => ['required'],
                'image'         => ['required'],
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
                        
                        $institute = Institute::find($request->id);
                        $institute->logo = $file_name;
                        if ($institute->save())
                        {
                            DB::commit();
                            $response['data']['message']    = 'Request Successfull';
                            $response['data']['code']       = 200;
                            $response['data']['result']     = $institute->logo;
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

    public function getInstituteDetails(Request $request)
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
                'id'             => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                try 
                {
                    $institute  = Institute::find($request->id);

                    $response['data']['message'] = 'Request Successfull';
                    $response['data']['code'] = 200;
                    $response['data']['result'] = $institute;
                    $response['status'] = true;
                }
                catch (\Exception $e) 
                {
                }
            }
        }
        return $response;
    }

    public function listMyInstitutes(Request $request)
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
            try 
            {
                //$myInstituteIds = ParentInstitute::where('parentId',$user->parent->id)->pluck('instituteId');
                $studentIds = ParentStudent::where('parentId',$user->parent->id)->pluck('studentId');

                $myInstituteIds = Student::Join('users','users.id','=','students.userId')
                                                ->select('students.*',
                                                         'users.avatarFilePath')
                                                ->whereIn('students.id',$studentIds)
                                                //->whereIn('students.instituteId',$myInstituteIds)
                                                ->where('users.isDeleted',0)
                                                ->pluck('students.instituteId');
                $myInstitutes = Institute::whereIn('id',$myInstituteIds)->get();

                $response['data']['message'] = 'Request Successfull';
                $response['data']['code'] = 200;
                $response['data']['result'] = $myInstitutes;
                $response['status'] = true;
            }
            catch (\Exception $e) 
            {
            }
        }
        return $response;
    }

    public function listAllInstitutes(Request $request)
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
            try 
            {
                $institutes = Institute::all();

                $response['data']['message'] = 'Request Successfull';
                $response['data']['code'] = 200;
                $response['data']['result'] = $institutes;
                $response['status'] = true;
            }
            catch (\Exception $e) 
            {
            }
        }
        return $response;
    }

}
