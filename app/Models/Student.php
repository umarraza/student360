<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'user_profiles';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'name',
        'phone',
        'email',
        'city',
        'country',
        'occupation',
        'institute',
        'dateOfBirth',
        'gender',
        'CNIC',
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

                'id'            =>  $this->id,
                'email'         =>  $this->email,
                'name'          =>  $this->name,
                'phone'         =>  $this->phone,
                'city'          =>  $this->city,
                'country'       =>  $this->country,
                'occupation'    =>  $this->occupation,  
                'institute'     =>  $this->institute,
                'dateOfBirth'   =>  $this->dateOfBirth,
                'gender'        =>  $this->gender, 
                'CNIC'          =>  $this->CNIC,  
                'userId'        =>  $this->userId, 

        ];
    }
}
