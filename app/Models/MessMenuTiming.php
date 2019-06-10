<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessMenuTiming extends Model
{
    protected $table = 'mess-menu-timinigs';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'brkfastStartTime',
        'brkfastEndTime',
        'lunchStartTime',
        'lunchEndTime',
        'dinnerStartTime',
        'dinnerEndTime',
        'isSetBreakFast',
        'isSetLunch',
        'isSetDinner',
        'hostelId',
        'price'

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

                'id'               =>  $this->id,
                'brkfastStartTime' =>  $this->brkfastStartTime,
                'brkfastEndTime'   =>  $this->brkfastEndTime,
                'lunchStartTime'   =>  $this->lunchStartTime,
                'lunchEndTime'     =>  $this->lunchEndTime,
                'dinnerStartTime'  =>  $this->dinnerStartTime,
                'dinnerEndTime'    =>  $this->dinnerEndTime,
                'isSetBreakFast'   =>  $this->isSetBreakFast,
                'isSetLunch'       =>  $this->isSetLunch,
                'isSetDinner'      =>  $this->isSetDinner,
                'hostelId'         =>  $this->hostelId,
                'price'            =>  $this->price,

        ];
    }
}
