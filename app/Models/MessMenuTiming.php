<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessMenuTiming extends Model
{
    protected $table = 'mess-menu-timinigs';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'bkfastStartTime',
        'bkfastEndTime',
        'lunchStartTime',
        'lunchEndTime',
        'dinnerStartTime',
        'dinnerEndTime',
        'isSetBreakFast',
        'isSetLunch',
        'isSetDinner',
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

                'id'               =>  $this->id,
                'bkfastStartTime'  =>  $this->bkfastStartTime,
                'bkfastEndTime'    =>  $this->bkfastEndTime,
                'lunchStartTime'   =>  $this->lunchStartTime,
                'lunchEndTime'     =>  $this->lunchEndTime,
                'dinnerStartTime'  =>  $this->dinnerStartTime,
                'dinnerEndTime'    =>  $this->dinnerEndTime,
                'isSetBreakFast'   =>  $this->isSetBreakFast,
                'isSetLunch'       =>  $this->isSetLunch,
                'isSetDinner'      =>  $this->isSetDinner,
                'hostelId'         =>  $this->hostelId,

        ];
    }
}
