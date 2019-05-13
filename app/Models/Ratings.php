<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $table = 'ratings';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'score',
        'hostelId',
        'userId',
    ];

    /**
     * @return mixed
     */

    public function hostel(){

        return $this->hasOne(Hostel::class, 'id', 'hostelId');
    } 
    
    public function user()
    {
        return $this->hasOne(User::class,'id','userId');
    }

    public function getArrayResponse() {
        
        return [

                'id'       =>  $this->id,
                'score'    =>  $this->score,
                'hostelId' =>  $this->hostelId,
                'userId'   =>  $this->userId,
        ];
    }
}
