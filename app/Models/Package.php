<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        // 'createdAt',
        // 'updatedAt'
    ];

    public function getArrayResponse() {
        return [
            'title'         => $this->title,
            'description'   => $this->description,
            'price'      	=> $this->price,
        ];
    }
}
