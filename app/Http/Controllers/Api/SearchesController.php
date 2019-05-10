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

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelCategory', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                    ->where('hostel_profiles.hostelCategory','like', '%' . $hostelCategory . '%') 
                    ->where('hostel_profiles.address','like', '%' . $location . '%')
                    ->where('hostel_images.isThumbnail','=', 1)
                    ->orderBy('ratings.score', 'desc')

                ->get();

            }

            if (isset($location)) {

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelCategory', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                    ->where('hostel_profiles.hostelCategory','like', '%' . $hostelCategory . '%')
                    ->where('hostel_profiles.address','like', '%' . $location . '%')
                    ->where('hostel_images.isThumbnail','=', 1)
                    ->orderBy('ratings.score', 'desc')

                ->get();

            }
            
            if (isset($searchRadius)) {

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelType', 'ratings.body', 'hostel_images.imageName', 'hostel_images.type' )
                    ->where('hostel_profiles.hostelType','like', '%' . $hostelType . '%')
                    ->where('hostel_profiles.address','like', '%' . $location . '%')
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
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.priceRange', 'hostel_profiles.hostelCategory', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.hostelCategory','like', '%' . $hostelCategory . '%') 
                ->where('hostel_profiles.address','like', '%' . $location . '%')
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($location)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.priceRange', 'hostel_profiles.hostelCategory', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.hostelCategory','like', '%' . $hostelCategory . '%')
                ->where('hostel_profiles.address','like', '%' . $location . '%')
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')


            ->get();

        }
        
        if (isset($searchRadius)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.priceRange', 'hostel_profiles.hostelType', 'ratings.body', 'hostel_images.imageName', 'hostel_images.type' )
                ->where('hostel_profiles.hostelType','like', '%' . $hostelType . '%')
                ->where('hostel_profiles.address','like', '%' . $location . '%')
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($ac)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $ac . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($tv)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $tv . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }
        
        if (isset($gym)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $agym . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($ups)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $ups . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($lawn)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $lawn . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($cctv)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $cctv . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($wifi)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $wifi . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($geyser)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $geyser . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($laundry)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $laundry . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($parking)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $parking . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($kitchen)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $kitchen . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($messMenu)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $messMenu . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($firstAid)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $firstAid . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($furnished)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $furnished . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($studyRoom)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $studyRoom . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($transport)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $transport . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($sportsArea)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $sportsArea . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($groundFloor)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $groundFloor . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($roomService)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $roomService . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($petsAllowed)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $petsAllowed . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($waterFilter)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $waterFilter . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($notFurnished)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $notFurnished . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($swimmingPool)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $swimmingPool . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($GuestsAllowed)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $GuestsAllowed . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($medicalSupport)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $medicalSupport . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($attachedBathroom)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $attachedBathroom . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($wheelChairAccessible)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.features','like', '%' . $wheelChairAccessible . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($priceRange)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.priceRange', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.priceRange','like', '%' . $priceRange . '%')
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
                ->where('hostel_profiles.features','like', '%' . $roomType . '%') 
                ->where('hostel_images.isThumbnail','=', 1)
                ->orderBy('ratings.score', 'desc')

            ->get();

        }

        if (isset($distance)) {

            $hostelsResults = DB::table('hostel_profiles')

                ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.features', 'ratings.score', 'hostel_images.imageName', 'hostel_images.isThumbnail' )
                ->where('hostel_profiles.distance','like', '%' . $distance . '%') 
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
