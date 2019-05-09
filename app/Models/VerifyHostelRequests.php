<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyHostelRequests extends Model
{
    protected $table = 'approve_hostel_requests';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'approvalStatus',
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
                'approvalStatus' => $this->approvalStatus,
                'hostelId' => $this->hostelId,
        ];
    }
}
