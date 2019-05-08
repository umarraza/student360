<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queries extends Model
{
    protected $table = 'queries';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'message',
        'hostelId',
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

                'id'       =>  $this->id,
                'message'  =>  $this->message,
                'hostelId' =>  $this->hostelId,
                'userId'   =>  $this->userId,
        ];
    }
}
