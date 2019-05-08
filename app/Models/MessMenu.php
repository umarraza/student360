<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessMenu extends Model
{
    protected $table = 'mess_menu';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'day',
        'breakFastTiming',
        'dinnerTiming',

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
                'breakFastTiming' => $this->breakFastTiming,
                'dinnerTiming'=> $this->dinnerTiming,

        ];
    }
}
