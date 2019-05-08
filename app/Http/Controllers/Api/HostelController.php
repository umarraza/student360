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
use App\Models\Api\ApiUpdateHostelRequest as UpdateHostelRequest;
use App\Models\Api\ApiHostel as Hostel;
use App\Models\Api\ApiThreads as Threads;


class HostelController extends Controller
{

     /**
     * CREATE HOSTEL
     *
     * Hostel Admin can register a new hostel.
     *
     * @function
     * 
     */

    public function create(Request $request)
    {
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
                
               'status' => false

            ];
            $rules = [
                // hostelCtaegory need to change from front end
            	'hostelName'         =>   'required',
                'hostelCategory'     =>   'required',   // Boys, Girls, Guest House
                'numberOfBedRooms'   =>   'required',
                'noOfBeds'         	 =>   'required',
                'priceRange'         =>   'required',  // price can be a range or a single value. e.g 5000/month or 5000 to 15000/month
                'address'		     =>   'required',  
                'longitude'          =>   'required',
                'latitude'           =>   'required',
                'state'              =>   'required',
                'postCode'           =>   'required',
                'city'            	 =>   'required',
                'country'            =>   'required',
                'description'        =>   'required',
                'contactName'        =>   'required',
                'contactEmail'       =>   'required',
                'website'            =>   'required',
                'phoneNumber'        =>   'required',
                'features'           =>   'required',
                'username'           =>   'required|unique:users',
                'password'           =>   'required',
                'roleId'             =>   'required',

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
                $email    = $request->get('contactEmail');

                $user =  User::create([
                    
                    'username'   =>  $username,
                    'email'      =>  $email,
                    'password'   =>  bcrypt($password),
                    'roleId'     =>  $roleId,
                    'verified'   =>  0,
                    'language'   =>  "English",
                ]);

                    $userId = $user->id;

                    $thread = Threads::create([
                        'userId'  => $userId,
                        'adminId' => 1,
                    ]);

                    $thread->save();

                    $threadId = $thread->id;

                    $updateThread = User::where('id', '=', $userId)->update([

                        'threadId' => $threadId,

                    ]);

                $hostel = Hostel::create([

                        'hostelName'       =>   $request->get('hostelName'),
                        'hostelCategory'   =>   $request->get('hostelCategory'), //Boys, Girls, Guest House
                        'numberOfBedRooms' =>   $request->get('numberOfBedRooms'),
                        'noOfBeds'         =>   $request->get('noOfBeds'),
                        'priceRange'       =>   $request->get('priceRange'),
                        'address'          =>   $request->get('address'),
                        'longitude'        =>   $request->get('longitude'),
                        'latitude'         =>   $request->get('latitude'),
                        'state'            =>   $request->get('state'),
                        'postCode'         =>   $request->get('postCode'),
                        'city'             =>   $request->get('city'),
                        'country'          =>   $request->get('country'),
                        'description'      =>   $request->get('description'),
                        'contactName'      =>   $request->get('contactName'),
                        'contactEmail'     =>   $request->get('contactEmail'),
                        'website'          =>   $request->get('website'),
                        'phoneNumber'      =>   $request->get('phoneNumber'),
                        'features'         =>   $request->get('features'),
                        'userId'           =>   $user->id,

                    ]);


            	if ($hostel->save() && $user->save()) 
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['result']             = $hostel;
                    $response['user']               = $user;
                    $response['data']['message']    = 'Hostel created Successfully';
                }
            }
        
        return $response;
    }

    /**
     * ALL HOSTELS LIST
     *
     * Super admin can see a list of all registered / Unapproved hostels
     *
     * @function
     * 
     */

    public function listHostels(Request $request)
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
            
            $allHostels = Hostel::all();
            // $allHostels = Hostel::all()->select('hostelName',  'address', 'hostelCategory', 'isVerified', 'isApproved');
            
            // If there are thousands of hostels, getting the list with all parameters will put load to server as well as network. ask musab if we can select just few fields. 

            if (!empty($allHostels)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $allHostels;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;    
            }

        }
        return $response;
    }

    /**
     * UPDATE AVAILBILITY
     *
     * show if hostel is available to book for rooms or not
     *
     * @function
     */

    public function updateAvailbility(Request $request)
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
            
            $updateAvailability =  Hostel::find($request->id)->update([
                    
                'isAvailable'  =>  1,

            ]);


            if ($updateRequest->save()) {

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
     * REGISTERED HOSTELS
     *
     * Super admin and normal user both can see the list of 
     * all registered hostels
     *
     * @function
     */

    public function registeredHostels(Request $request)
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
            
            $registeredHostels = Hostel::where('isVerified', 1)->get();

            if (!empty($registeredHostels)) {

                $response['data']['code']       =  200;
                $response['data']['message']    =  'Request Successfull';
                $response['data']['result']     =  $registeredHostels;
                $response['status']             =  true;

            } else {

                $response['data']['code']       =  400;
                $response['data']['message']    =  'No Hostels Found';
                $response['status']             =  false;    
            }


        }
        return $response;
    }
    
    /**
     * HOSTEL DETAILS
     *
     * Super admin and normal user both can see the details
     *
     * @function
     */

    public function hostelDetails(Request $request)
    {
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];

            $rules = [

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            }
            else
            {

                $hostel = Hostel::find($request->id);
                
                // $features = $hostel->features;

                // $data = json_decode($features);
                // $ATM = $data[0];
                // $BBQ = $data[1];
                // return $BBQ;

                // $breakFeatures = explode(',', $features);
                // $data = $breakFeatures[0];
                // return $data;
                // $vcardData = explode('@@@', $data);

            	if (!empty($hostel)) 
                {

                    $response['data']['code']       =  200;
                    $response['status']             =  true;
                    $response['result']             =  $hostel;
                    $response['data']['message']    =  'Request Successfull';

                } else {

                    $response['data']['code']       =  400;
                    $response['status']             =  false;
                    $response['data']['message']    =  'Hostel Not Found!';
                
                }
            }
        return $response;
    }

    /**
     * DELETE HOSTEL
     *
     * Super admin or Hostel admin can delete the hostel
     *
     * @function
     */

    public function delete(Request $request)
    {
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];

            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $rules = [

            	'id'     =>   'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            
            }else{

                $hostel = Hostel::find($request->id);
                $userId = $hostel->userId;

                $user = User::find($userId);
                
            	if ($user->delete() && $hostel->delete()) {

                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Hostel Deleted Successfully';

                } else {

                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Hostel Not Deleted!';
                
                }
            }
        
        return $response;
    }

    /**
     * CREATE HOSTEL UPDATE REQUEST
     *
     * Hostel Admin can update hostel by sending a request to 
     * Super admin. Super admin will approve or reject the 
     * request
     * 
     * @function
     */

    public function updateHostelRequest(Request $request)
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

        if(!empty($user) && $user->isHostelAdmin()){

                $response = [
                    'data' => [
                        'code' => 400,
                        'message' => 'Something went wrong. Please try again later!',
                    ],
                    
                    'status' => false

                ];
                $rules = [
                    // hostelCtaegory need to change from front end

                    'hostelName'         =>   'required',
                    'hostelCategory'     =>   'required',   // Boys, Girls, Guest House
                    'numberOfBedRooms'   =>   'required',
                    'noOfBeds'         	 =>   'required',
                    'priceRange'         =>   'required',  // price can be a range or a single value. e.g 5000/month or 5000 to 15000/month
                    'address'		     =>   'required',  
                    'longitude'          =>   'required',
                    'latitude'           =>   'required',
                    'state'              =>   'required',
                    'postCode'           =>   'required',
                    'city'            	 =>   'required',
                    'country'            =>   'required',
                    'description'        =>   'required',
                    'contactName'        =>   'required',
                    'contactEmail'       =>   'required',
                    'website'            =>   'required',
                    'phoneNumber'        =>   'required',
                    'features'           =>   'required',
                    'status'             =>   'required',
                    'hostelId'           =>   'required',

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                }
                else
                {

                $userId = $user->id;
                   
                    $updateHostel = UpdateHostelRequest::create([

                            'hostelName'       =>   $request->get('hostelName'),
                            'hostelCategory'   =>   $request->get('hostelCategory'), //Boys, Girls, Guest House
                            'numberOfBedRooms' =>   $request->get('numberOfBedRooms'),
                            'noOfBeds'         =>   $request->get('noOfBeds'),
                            'priceRange'       =>   $request->get('priceRange'),
                            'address'          =>   $request->get('address'),
                            'longitude'        =>   $request->get('longitude'),
                            'latitude'         =>   $request->get('latitude'),
                            'state'            =>   $request->get('state'),
                            'postCode'         =>   $request->get('postCode'),
                            'city'             =>   $request->get('city'),
                            'country'          =>   $request->get('country'),
                            'description'      =>   $request->get('description'),
                            'contactName'      =>   $request->get('contactName'),
                            'contactEmail'     =>   $request->get('contactEmail'),
                            'website'          =>   $request->get('website'),
                            'phoneNumber'      =>   $request->get('phoneNumber'),
                            'features'         =>   $request->get('features'),
                            'status'           =>   $request->get('status'),
                            'hostelId'         =>   $request->get('hostelId'),
                            'userId'           =>   $userId,

                        ]);


                    if ($updateHostel->save()) 
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['result']             = $updateHostel;
                        $response['data']['message']    = 'Update request for hostel created Successfully';
                    }
                }
            }
        return $response;
    }

}
