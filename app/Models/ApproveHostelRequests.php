<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproveHostelRequests extends Model
{
    protected $table = 'approve_hostel_requests';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'approveStatus',
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
                'approveStatus' => $this->approveStatus,
                'hostelId' => $this->hostelId,
        ];
    }
}
