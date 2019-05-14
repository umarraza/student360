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
use App\Models\Search;

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

            'location' => 'required',
            // 'searchRadius' => 'required',
            'hostelCategory' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            
            $response['data']['message'] = 'Invalid input values.';
            $response['data']['errors'] = $validator->messages();

        } else {

            $location = $request->get('location');
            $searchRadius = $request->get('searchRadius');
            $hostelCategory = $request->get('hostelCategory');

                if (isset($hostelCategory)) {

                    $hostelsResults = DB::table('hostel_profiles AS hostel')

                        ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                        ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')

                        ->select(
                            'hostel.id', 
                            'hostel.hostelName', 
                            'hostel.address', 
                            'hostel.hostelCategory', 
                            'rating.score', 
                            'image.imageName', 
                            'image.isThumbnail' )
                        
                        ->where('hostel.hostelCategory','REGEXP', $hostelCategory)
                        ->where('image.isThumbnail','=', 1)
                        
                        ->orderBy('rating.score', 'desc')

                    ->get();

                }

                if (isset($location)) {

                    $hostelsResults = DB::table('hostel_profiles AS hostel')

                    ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                    ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                    
                    ->select(
                        'hostel.id', 
                        'hostel.hostelName', 
                        'hostel.address', 
                        'hostel.hostelCategory', 
                        'rating.score', 
                        'image.imageName', 
                        'image.isThumbnail' )

                    ->where('hostel.address','REGEXP', $location)
                    ->where('image.isThumbnail','=', 1)
                    
                    ->orderBy('rating.score', 'desc')

                ->get();

                }
                
                if (isset($searchRadius)) {

                    $hostelsResults = DB::table('hostel_profiles AS hostel')

                    ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                    ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                    
                    ->select(
                        'hostel.id', 
                        'hostel.hostelName', 
                        'hostel.address', 
                        'hostel.hostelCategory', 
                        'rating.score', 
                        'image.imageName', 
                        'image.isThumbnail' )

                    ->where('hostel.searchRadius','REGEXP', $searchRadius)
                    ->where('image.isThumbnail','=', 1)
                    
                    ->orderBy('rating.score', 'desc')

                ->get();

                }

                if (isset($location, $hostelCategory)) {

                    $hostelsResults = DB::table('hostel_profiles AS hostel')

                        ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                        ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                        
                        ->select(
                            'hostel.id', 
                            'hostel.hostelName', 
                            'hostel.address', 
                            'hostel.hostelCategory', 
                            'rating.score', 
                            'image.imageName', 
                            'image.isThumbnail' )

                        ->where('hostel.address','REGEXP', $location)
                        ->where('hostel.hostelCategory','REGEXP', $hostelCategory)
                        ->where('image.isThumbnail','=', 1)
                        
                        ->orderBy('rating.score', 'desc')

                    ->get();

                }

                    if(count($hostelsResults) > 0)
                    {
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['result']     = $hostelsResults;
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


        $ac                     =   $request->get('ac');
        $tv                     =   $request->get('tv');
        $gym                    =   $request->get('gym');
        $ups                    =   $request->get('ups');
        $lawn                   =   $request->get('lawn');
        $cctv                   =   $request->get('cctv');
        $wifi                   =   $request->get('wifi');       
        $geyser                 =   $request->get('geyser');
        $score                  =   $request->get('ratings');
        $laundry                =   $request->get('laundry');
        $parking                =   $request->get('parking');
        $kitchen                =   $request->get('kitchen');
        $roomType               =   $request->get('roomType');
        $messMenu               =   $request->get('messMenu');
        $firstAid               =   $request->get('firstAid');
        $location               =   $request->get('location');
        $furnished              =   $request->get('furnished');
        $studyRoom              =   $request->get('studyRoom');
        $transport              =   $request->get('transport');
        $priceRange             =   $request->get('priceRange');
        $sportsArea             =   $request->get('sportsArea');
        $groundFloor            =   $request->get('groundFloor');
        $roomService            =   $request->get('roomService');
        $petsAllowed            =   $request->get('petsAllowed');
        $waterFilter            =   $request->get('waterFilter');
        $notFurnished           =   $request->get('notFurnished');
        $swimmingPool           =   $request->get('swimmingPool');
        $searchRadius           =   $request->get('searchRadius');
        $GuestsAllowed          =   $request->get('GuestsAllowed');
        $medicalSupport         =   $request->get('medicalSupport');
        $hostelCategory         =   $request->get('hostelCategory');
        $attachedBathroom       =   $request->get('attachedBathroom'); 
        $wheelChairAccessible   =   $request->get('wheelChairAccessible');



        if (isset($hostelCategory)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.hostelCategory','REGEXP', $hostelCategory)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($location)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.address','REGEXP', $location)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }
        
        if (isset($searchRadius)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.searchRadius','REGEXP', $searchRadius)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($ac)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $ac)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($tv)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                    ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                    ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                    
                    ->select(
                        'hostel.id', 
                        'hostel.hostelName', 
                        'hostel.address', 
                        'hostel.hostelCategory', 
                        'hostel.features', 
                        'rating.score', 
                        'image.imageName', 
                        'image.isThumbnail' )

                    ->where('hostel.features','REGEXP', $tv)
                    ->where('image.isThumbnail','=', 1)
                    
                    ->orderBy('rating.score', 'desc')

                ->get();

        }
        
        if (isset($gym)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $gym)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($ups)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $ups)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();
        }

        if (isset($lawn)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $lawn)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($cctv)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $cctv)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($wifi)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $wifi)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($geyser)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $geyser)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($laundry)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $laundry)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($parking)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $parking)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($kitchen)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $kitchen)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($messMenu)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $messMenu)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($firstAid)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $firstAid)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($furnished)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $furnished)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($studyRoom)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $studyRoom)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($transport)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $transport)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($sportsArea)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $sportsArea)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($groundFloor)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $groundFloor)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($roomService)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $roomService)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($petsAllowed)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $petsAllowed)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($waterFilter)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $waterFilter)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($notFurnished)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $notFurnished)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($swimmingPool)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $swimmingPool)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($GuestsAllowed)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $GuestsAllowed)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($medicalSupport)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $medicalSupport)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($attachedBathroom)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $attachedBathroom)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($wheelChairAccessible)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $wheelChairAccessible)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($priceRange)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.priceRange', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $priceRange)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('hostel.priceRange', 'asc')

            ->get();

        }

        if (isset($score)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $score)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($roomType)) {

            
                $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $roomType)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

        if (isset($distance)) {

            $hostelsResults = DB::table('hostel_profiles AS hostel')

                ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')
                
                ->select(
                    'hostel.id', 
                    'hostel.hostelName', 
                    'hostel.address', 
                    'hostel.hostelCategory', 
                    'hostel.features', 
                    'rating.score', 
                    'image.imageName', 
                    'image.isThumbnail' )

                ->where('hostel.features','REGEXP', $distance)
                ->where('image.isThumbnail','=', 1)
                
                ->orderBy('rating.score', 'desc')

            ->get();

        }

            if(count($hostelsResults) > 0)
            {
                $response['data']['code']       = 200;
                $response['status']             = true;
                $response['data']['result']     = $hostelsResults;
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
