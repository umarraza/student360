<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institutes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'longitude',
        'latitude',
        'description',
        'packageId',
        'logo',
        'lastPaymentMade',
        'nextPaymentDue',
        'nextPaymentAmount',
        'lastPaymentAmount',
        // 'createdAt',
        // 'updatedAt'
    ];


    public function getArrayResponse() {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'longitude'     => $this->longitude,
            'latitude'      => $this->latitude,
            'address'       => $this->address,
            'description'   => $this->description,
            'packageId'     => $this->packageId,
            
        ];
    }
}
