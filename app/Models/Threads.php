<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Threads extends Model
{
    protected $table = 'threads';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'id',
        'hostelId',
        'userId'
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','userId');
    }

    public function queries()
    {
        return $this->hasMany(Queries::class);
    }

    public function getArrayResponse() {
        
        return [

                'id'       =>  $this->id,
                'hostelId' =>  $this->hostelId,
                'userId'   =>  $this->userId

        ];
    }
}
