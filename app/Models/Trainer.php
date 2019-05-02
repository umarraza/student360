<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trainers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'phoneNumber',
        'instituteId',
        'userId',
        // 'createdAt',
        // 'updatedAt'
    ];

    public function getArrayResponse() {
        return [
            'id'            => $this->id,
            'firstName'     => $this->firstName,
            'lastName'      => $this->lastName,
            'phoneNumber'   => $this->phoneNumber,
            'instituteId'   => $this->instituteId,
        ];
    }
}
