<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateHostelRequest extends Model
{
    protected $table = 'update-hostels-requests';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'hostelName',
        'hostelCategory',
        'numberOfBedRooms',
        'noOfBeds',
        'priceRange',
        'address',
        'longitude',
        'latitude',
        'state',
        'postCode',
        'city',
        'country',
        'description',
        'contactName',
        'contactEmail',
        'website',
        'phoneNumber',
        'features',
        'status',
        'hostelId',
        'userId',


    ];

    /**
     * @return mixed
     */

    public function getArrayResponse() {
        
        return [

                'id'                =>  $this->id,
                'hostelName'        =>  $this->hostelName,
                'hostelCategory'    =>  $this->hostelCategory,
                'numberOfBedRooms'  =>  $this->numberOfBedRooms,
                'noOfBeds'          =>  $this->noOfBeds,
                'priceRange'        =>  $this->priceRange,
                'address'           =>  $this->address,
                'longitude'         =>  $this->longitude,  
                'latitude'          =>  $this->latitude,  
                'state'             =>  $this->state,
                'postCode'          =>  $this->postCode,  
                'city'              =>  $this->city,
                'country'           =>  $this->country,
                'contactName'       =>  $this->contactName, 
                'contactEmail'      =>  $this->contactEmail,  
                'website'           =>  $this->website, 
                'phoneNumber'       =>  $this->phoneNumber,  
                'features'          =>  $this->features,  
                'status'            =>  $this->status,  
                'hostelId'          =>  $this->hostelId,  
                'userId'            =>  $this->userId,  

        ];
    }
}
