<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateRequests extends Model
{
    protected $table = 'update_requests';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'isUpdated',
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
                'isUpdated' =>  $this->isUpdated,
                'hostelId'  =>  $this->hostelId,
        ];
    }
}
