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

class SearchesController extends Controller
{
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

                // $location          =    $request->get('location');
                $hostelType        =    $request->get('hostelType');
                // $searchRadius      =    $request->get('searchRadius');

                $hostelsResults = DB::table('hostel_profiles')
                            ->join('hostel_images', 'hostel_images.hostelId', '=', 'hostel_profiles.id')
                            ->select('hostel_images.image_name', 'hostel_profiles.hostelType')
                            // ->where('hostel_profiles.location','like', '%' . $location . '%')
                            ->where('hostel_profiles.hostelType','like', '%' . $hostelType . '%')
                    ->get();                

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
