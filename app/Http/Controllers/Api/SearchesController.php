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
| User can search hostels on the basis of 3 parameters. His location, hostel type
| search radius. User can also search hostels by institute. The search result 
| should show the name of the hostel, rating, address, distance from the 
| searched area, price range (Monthly) 	and facilities of the hostel. 
|
| Search results will be sorted in high to low ratings.
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
           $hostelType = $request->get('hostelType');
           $searchRadius = $request->get('searchRadius');

            if (isset($hostelType)) {

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelType', 'ratings.body', 'hostel_images.imageName', 'hostel_images.type' )
                    ->where('hostel_profiles.hostelType','like', '%' . $hostelType . '%') // should we remove this where clause if hostelType is none
                    ->where('hostel_profiles.address','like', '%' . $location . '%')
                    ->where('hostel_images.type','=', 1)

                ->get();

            }

            if (isset($location)) {

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelType', 'ratings.body', 'hostel_images.imageName', 'hostel_images.type' )
                    ->where('hostel_profiles.hostelType','like', '%' . $hostelType . '%')
                    ->where('hostel_profiles.address','like', '%' . $location . '%')
                    ->where('hostel_images.type','=', 1)

                ->get();

            }
            
            if (isset($searchRadius)) {

                $hostelsResults = DB::table('hostel_profiles')

                    ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                    ->join('ratings', 'ratings.hostelId', '=', 'hostel_profiles.id')
                    ->select('hostel_profiles.id', 'hostel_profiles.hostelName', 'hostel_profiles.address', 'hostel_profiles.hostelType', 'ratings.body', 'hostel_images.imageName', 'hostel_images.type' )
                    ->where('hostel_profiles.hostelType','like', '%' . $hostelType . '%')
                    ->where('hostel_profiles.address','like', '%' . $location . '%')
                    ->where('hostel_images.type','=', 1)

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
