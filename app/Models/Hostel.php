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
        'isApproved',
        'features',
        'userId',
    ];

    public function images(){

        return $this->hasMany(Images::class, 'id','hostelId');
    }

    public function ratings(){

        return $this->hasMany(Ratings::class, 'id','hostelId');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','userId');
    }

    public function addRating($score){

        $this->ratings()->create(compact('score'));
    }


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
                'isApproved'        =>  $this->isApproved,  
                'features'          =>  $this->features,  
                'userId'            =>  $this->userId,  

        ];
    }
}
