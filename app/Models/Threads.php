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
        'studentId',
        'adminId',
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','studentId');
    }

    public function getArrayResponse() {
        
        return [

                'id'       =>  $this->id,
                'studentId'   =>  $this->studentId,
                'adminId'  =>  $this->adminId,
        ];
    }
}
