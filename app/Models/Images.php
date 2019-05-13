<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'hostel_images';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';


     protected $fillable = [

        'imageName',
        'isThumbnail',
        'hostelId',
    ];

    /**
     * @return mixed
     */

    public function hostel(){

        return $this->belongsTo(Hostel::class);
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','userId');
    }

    public function getArrayResponse() {
        
        return [

                'id' => $this->id,
                'isThumbnail' => $this->isThumbnail,
                'imageName' => $this->imageName,
                'hostelId' => $this->hostelId,
        ];
    }
}
