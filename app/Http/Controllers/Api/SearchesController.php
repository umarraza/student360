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
use App\Models\Api\ApiRatings as Rating;
use App\Models\Api\ApiFeatures as Features;
use App\Models\Api\ApiImages as Images;



use App\Models\Search;
use Exception;

class SearchesController extends Controller
{

/*
|--------------------------------------------------------------------------
| Hostels Searching Module
|--------------------------------------------------------------------------
| User can search hostels on the basis of 3 parameters. location, hostel type and
| search radius. The search result should show the name of the hostel, rating,
| address, distance from the searched area, price range (Monthly) and
| facilities of the hostel. Search results will be sorted in high 
| to low ratings.
| 
*/

// Join with rating,

    public function searchHostels(Request $request)
    {
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Something went wrong. Please try again later!',
                ],
                'status' => false
            ];

        $rules = [

            // 'location' => 'required',
            'areaRadius' => 'required',
            'hostelCategory' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            
            $response['data']['message'] = 'Invalid input values.';
            $response['data']['errors'] = $validator->messages();

        } else {

            /**
             * LOCATION:
             * Location will be provided in case of "other location/address"
             * rather than current location of user who is performing search.
             * 
             * LONGITUDE/LATITUDE
             * Longitude & latitude will be provided in case of current 
             * location of a user who is performing search.
             */

            $latitude         =   $request->get('latitude');
            $longitude        =   $request->get('longitude');
            $location         =   $request->get('location');
            $areaRadius       =   $request->get('areaRadius');
            $hostelCategory   =   $request->get('hostelCategory');

                if (isset($hostelCategory, $areaRadius)) {

                    $hostelsResults = DB::table('hostel_profiles AS hostel')
                        ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')

                        ->select(
                            DB::raw(
                                    
                            '( 6367 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') )
                            + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'),
                            
                            'hostel.id', 
                            'hostel.hostelName', 
                            'hostel.address', 
                            'hostel.hostelCategory', 
                            'image.imageName', 
                            'image.isThumbnail', 
                            'hostel.avgRating', 

                            )

                        // ->where('hostel.address','REGEXP', $location)
                        ->where('hostel.hostelCategory','REGEXP', $hostelCategory)
                        ->where('image.isThumbnail','=', 1)
                        
                        ->orderBy('hostel.avgRating', 'desc')

                    ->get();


                    $arr = [];

                    foreach ($hostelsResults as $value) 
                    {
                        if($value->distance < $areaRadius)
                        {
                            $arr[] = $value;
                        }
                    }
                }
            
                if(count($arr) > 0)
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['result']     = $arr;
                    $response['data']['message']    = 'Request Successfull';
            
                }
                else
                {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'No Items matches your searches';
                }
            }
        return $response;
    }

    /*
    |--------------------------------------------------------------------------
    | Hostels Searching Module
    |--------------------------------------------------------------------------
    | User can search hostels on the basis of 3 parameters. location, hostel type and
    | search radius. The search result should show the name of the hostel, rating,
    | address, distance from the searched area, price range (Monthly) and
    | facilities of the hostel. Search results will be sorted in high 
    | to low ratings.
    | 
    */

    public function searchByFeatures(Request $request)
    {
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Something went wrong. Please try again later!',
                ],
                'status' => false
            ];


            $array = [
            
                $ac                     =   $request->get('ac'),
                $tv                     =   $request->get('tv'),
                $gym                    =   $request->get('gym'),
                $ups                    =   $request->get('ups'),
                $lawn                   =   $request->get('lawn'),
                $cctv                   =   $request->get('cctv'),
                $wifi                   =   $request->get('wifi'),       
                $geyser                 =   $request->get('geyser'),
                $score                  =   $request->get('ratings'),
                $laundry                =   $request->get('laundry'),
                $parking                =   $request->get('parking'),
                $kitchen                =   $request->get('kitchen'),
                $roomType               =   $request->get('roomType'),
                $messMenu               =   $request->get('messMenu'),
                $firstAid               =   $request->get('firstAid'),
                $furnished              =   $request->get('furnished'),
                $studyRoom              =   $request->get('studyRoom'),
                $transport              =   $request->get('transport'),
                $priceRange             =   $request->get('priceRange'),
                $sportsArea             =   $request->get('sportsArea'),
                $groundFloor            =   $request->get('groundFloor'),
                $roomService            =   $request->get('roomService'),
                $petsAllowed            =   $request->get('petsAllowed'),
                $waterFilter            =   $request->get('waterFilter'),
                $notFurnished           =   $request->get('notFurnished'),
                $swimmingPool           =   $request->get('swimmingPool'),
                $searchRadius           =   $request->get('searchRadius'),
                $GuestsAllowed          =   $request->get('GuestsAllowed'),
                $medicalSupport         =   $request->get('medicalSupport'),
                $attachedBathroom       =   $request->get('attachedBathroom'), 
                $wheelChairAccessible   =   $request->get('wheelChairAccessible')

            ];

            // $features = Features::all();

            $length = count($array);
            
            for ($i = 0; $i < $length; ++$i) {

                if (isset($array[$i])) {

                    $hostelResults = DB::table('hostel_profiles AS hostel')

                    // ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                    
                    ->select(
                        
                        'hostel.id', 
                        'hostel.hostelName', 
                        'hostel.address', 
                        'hostel.hostelCategory',
                        'hostel.features', 
                        // 'image.imageName', 
                        // 'image.isThumbnail',
                        'hostel.avgRating', 
                        
                        )

                    ->where('hostel.features','REGEXP', $array[$i])
                    // ->where('image.isThumbnail','=', 1)

                    ->orderBy('hostel.avgRating', 'desc')

                ->get();
            }
        }


        foreach ($hostelResults as $hostel) {

            $imageData = Images::where('hostelId', '=', $hostel->id)
            ->where('isThumbnail', '=', 1)->first();
            return $imageData;
            $imageName = $imageData->imageName;

            $hostel->imageName = $imageData->imageName;

        }

        return $hostelResults;


        if(count($hostelResults) > 0)
        {
            $response['data']['code']       = 200;
            $response['status']             = true;
            $response['data']['result']     = $hostelResults;
            $response['data']['message']    = 'Request Successfull';
    
        }
        else
        {
            $response['data']['code']       = 200;
            $response['status']             = true;
            $response['data']['message']    = 'No Items matches your searches';
        }

        return $response;
    }
}
