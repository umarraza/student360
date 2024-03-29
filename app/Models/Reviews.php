<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'reviews';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'body',
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
                'body'  =>  $this->body,
                'hostelId' =>  $this->hostelId,
                'userId'   =>  $this->userId,
        ];
    }
}
