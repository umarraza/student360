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
        'type',
        'threadId',
        'hostelId',

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

                'id'        =>  $this->id,
                'message'   =>  $this->message,
                'type'      =>  $this->type,
                'threadId'  =>  $this->threadId,
                'hostelId'  =>  $this->hostelId,
        ];
    }
}
