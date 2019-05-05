<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    protected $table = 'hostel_profiles';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'hostelName',
        'hostelType',
        'numberOfBedRooms',
        'noOfBeds',
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
        'isApproved',
        'isAvailable',
        'facilities',
        'userId',
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','userId');
    }

    public function getArrayResponse() {
        
        return [

                'id'                =>  $this->id,
                'hostelName'        =>  $this->hostelName,
                'hostelType'        =>  $this->hostelType,
                'numberOfBedRooms'  =>  $this->numberOfBedRooms,
                'noOfBeds'          =>  $this->noOfBeds,
                'address'           =>  $this->address,
                'longitude'         =>  $this->longitude,  
                'latitude'          =>  $this->latitude,  
                // 'state'             =>  $this->state,
                // 'postCode'          =>  $this->postCode,  
                'city'              =>  $this->city,
                'country'           =>  $this->country,
                'contactName'       =>  $this->contactName, 
                'contactEmail'      =>  $this->contactEmail,  
                'website'           =>  $this->website, 
                'phoneNumber'       =>  $this->phoneNumber,  
                'isApproved'        =>  $this->isApproved,  
                'isAvailable'       =>  $this->isAvailable, 
                'facilities'        =>  $this->facilities,  
                'userId'            =>  $this->userId,  

        ];
    }
}
