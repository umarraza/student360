<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileImages extends Model
{
    protected $table = 'profile_pictures';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'imageName',
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

                'id'        =>  $this->id,
                'imageName' =>  $this->imageName,
                'userId'    =>  $this->userId,
        ];
    }
}
