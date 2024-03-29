<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessMenuMeal extends Model
{
    protected $table = 'mess_menu-meal';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'day',
        'breakFastMeal',
        'lunchMeal',
        'dinnerMeal',
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

                'id' => $this->id,
                'day' => $this->day,
                'breakFastMeal' => $this->breakFastMeal,
                'lunchMeal'=> $this->lunchMeal,
                'dinnerMeal'=> $this->dinnerMeal,
                'hostelId'=> $this->hostelId,


        ];
    }
}
