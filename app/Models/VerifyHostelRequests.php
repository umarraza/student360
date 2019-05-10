<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyHostelRequests extends Model
{
    protected $table = 'hostels_registration-requests';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'verificationStatus',
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
                'verificationStatus' => $this->verificationStatus,
                'hostelId' => $this->hostelId,
        ];
    }
}
