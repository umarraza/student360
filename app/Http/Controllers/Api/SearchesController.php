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

           $location = $request->get('location');
           $searchRadius = $request->get('searchRadius');
           $hostelCategory = $request->get('hostelCategory');

            if (isset($hostelCategory)) {

                $hostelsResults = DB::table('hostel_profiles AS hostel')

                    ->join('hostel_images AS image', 'image.hostelId', '=', 'hostel.id')
                    ->join('ratings AS rating', 'rating.hostelId', '=', 'hostel.id')

                    ->select('hostel.id', 'hostel.hostelName', 'hostel.address', 'hostel.hostelCategory', 'rating.score', 'image.imageName', 'image.isThumbnail' )
                    
                    ->where('hostel.hostelCategory','REGEXP', $hostelCategory)
                    ->where('image.isThumbnail','=', 1)
                    
                    ->orderBy('rating.score', 'desc')

                ->get();

            }

            if (isset($location)) {

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelCategory', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                    ->where('hostel_profiles.address','REGEXP', $location)
                    ->where('hostel_images.isThumbnail','=', 1)
                    ->orderBy('ratings.score', 'desc')

                ->get();

            }
            
            if (isset($searchRadius)) {

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelType', 'ratings.body', 'hostel_images.imageName', 'hostel_images.type' )
                    ->where('hostel_profiles.hostelCategory','REGEXP', $hostelCategory)
                    ->where('hostel_images.isThumbnail','=', 1)
                    ->orderBy('ratings.score', 'desc')

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

            $hostelsResults = DB::table('hostel_profiles')  

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelCategory', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.hostelCategory','REGEXP', $hostelCategory)
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($location)) {

                $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id') 
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelCategory', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.address','REGEXP', $location)
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }
        
        if (isset($searchRadius)) {

                $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelType', 'ratings.body', 'hostel_images.imageName', 'hostel_images.type' )
                ->where('hostel_profiles.hostelCategory','REGEXP', $hostelCategory)
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($ac)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $ac . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($tv)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $tv . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }
        
        if (isset($gym)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $agym . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($ups)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $ups . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($lawn)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $lawn . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($cctv)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $cctv . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($wifi)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $wifi . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($geyser)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $geyser . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($laundry)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $laundry . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($parking)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $parking . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($kitchen)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $kitchen . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($messMenu)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $messMenu . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($firstAid)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $firstAid . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($furnished)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $furnished . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($studyRoom)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $studyRoom . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($transport)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $transport . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($sportsArea)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $sportsArea . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($groundFloor)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $groundFloor . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($roomService)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $roomService . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($petsAllowed)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $petsAllowed . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($waterFilter)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $waterFilter . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($notFurnished)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $notFurnished . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($swimmingPool)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $swimmingPool . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($GuestsAllowed)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $GuestsAllowed . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($medicalSupport)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $medicalSupport . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($attachedBathroom)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $attachedBathroom . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($wheelChairAccessible)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $wheelChairAccessible . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($priceRange)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.priceRange', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.priceRange','LIKE', '%' . $priceRange . '%')
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')
                ->orderBy('hostel_profiles.priceRange', 'asc')

            ->get();

        }

        if (isset($score)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.priceRange', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('ratings.score', '=', $score)
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($roomType)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','LIKE', '%' . $roomType . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($distance)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.distance','LIKE', '%' . $distance . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

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
