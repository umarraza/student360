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
use App\Models\Api\ApiImages as Image;
use App\Models\Api\ApiHostel as Hostel;
use App\Models\Api\ApiReviews as Review;
use App\Models\Api\ApiRatings as Rating;
use App\Models\Api\ApiThreads as Threads;
use App\Models\Api\ApiMessMenuMeal as MessMenuMeal;
use App\Models\Api\ApiMessMenuTiming as MessMenuTiming;
use App\Models\Api\ApiUpdateHostelRequest as UpdateHostelRequest;
use App\Models\Api\ApiVerifyHostelRequests as VerifyHostelRequests;


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

                'hostelName'         =>   'required',
                'hostelCategory'     =>   'required',   // Boys, Girls, Guest House
                'numberOfBedRooms'   =>   'required',
                'noOfBeds'         	 =>   'required',
                'priceRange'         =>   'required',  // price can be a range or a single value. e.g 5000/month or 5000 to 15000/month
                'address'		     =>   'required',  
                'longitude'          =>   'required',
                'latitude'           =>   'required',
                // 'state'              =>   'required',    State & Postcode are optional
                // 'postCode'           =>   'required',
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

                $hostel = Hostel::create([

                        'hostelName'       =>   $request->get('hostelName'),
                        'hostelCategory'   =>   $request->get('hostelCategory'), 
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
                        'isVerified'       =>   0,
                        'userId'           =>   $user->id,

                    ]);

                $hostelId  = $hostel->id;

                /**
                 *  Hostel admin cannot create mess menu, so, by default a mess menu will be created 
                 *  when a new hostel will apply for registration. Set default Meals for hostels 
                 *  for Breakfast, Lunch & Dinner against new created hostel.
                 *  @return Model
                 */

                for ($i = 0; $i < 6; ++$i){
                    
                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

                    $messMenueMeal = MessMenuMeal::create([

                        'day'            =>  $days[$i],
                        'breakFastMeal'  =>  'Set Break Fast Meal',
                        'LunchMeal'      =>  'Set lunch Meal',
                        'dinnerMeal'     =>  'Set Dinner Meal',
                        'hostelId'       =>  $hostelId,
    
                    ]);

                    $messMenueMeal->save();

                }


                /**
                 * 
                 *  Create Mess Menu list timings and status if menu is available/set or not.
                 *  We are creating mess menu while registering a user because we didn't 
                 *  want to allow the option to crate mess menu for hostel admin. 
                 *  Hostel admin cannot create mess menu again and again after
                 *  registration.
                 * 
                 *  @return Model
                 * 
                 */

                $messMenuTiming = MessMenuTiming::create([

                    'bkfastStartTime'  =>  '07:00 AM ',
                    'bkfastEndTime'    =>  '10:00 AM',
                    'lunchStartTime'   =>  '01:00 PM',
                    'lunchEndTime'     =>  '03:00 PM',
                    'dinnerStartTime'  =>  '07:00 PM',
                    'dinnerEndTime'    =>  '10:00 PM',
                    'isSetBreakFast'   =>  0,
                    'isSetLunch'       =>  0,
                    'isSetDinner'      =>  0,
                    'hostelId'         =>  $hostelId,

                ]);

            	if ($hostel->save() && $user->save()&& $messMenuTiming->save()) 
                {
                    $response['data']['code']           = 200;
                    $response['status']                 = true;
                    $response['data']['result']         = $hostel;
                    $response['data']['user']           = $user;
                    $response['data']['messMenuTiming'] = $messMenuTiming;
                    $response['data']['message']        = 'Hostel created Successfully';
                }
            }
        
        return $response;
    }

    /**
     * ALL HOSTELS LIST
     *
     * Super admin can see a list of all registered / Unapproved hostels
     *
     * @return listHostels
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
            
            $allHostels = Hostel::select('id','hostelName',  'address', 'hostelCategory', 'isVerified', 'isApproved')->get();

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
     * REGISTERED HOSTELS
     *
     * Super admin and normal user both can see the list of 
     * all registered hostels
     *
     * @return RegisteredHostels
     */

    public function listRegisteredHostels(Request $request)
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
     * Super admin registered/unregistered users both can see the details
     *
     * @return SingleHostelDetails
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

                $hostelImages = Image::where('hostelId', '=', $request->id)->get();

                $reviews = Review::where('hostelId', '=', $request->id)->get();

                $ratings = Rating::where('hostelId', '=', $request->id)->get();

                if (!empty($hostel)) 
                {
                    $response['data']['code']                     =  200;
                    $response['status']                           =  true;
                    $response['data']['result']['hostelDetails']  =  $hostel;
                    $response['data']['result']['images']         =  $hostelImages;
                    $response['data']['result']['reviews']        =  $reviews;
                    $response['data']['result']['ratings']        =  $ratings;
                    $response['data']['message']                  =  'Request Successfull';

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

    

}
