<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    protected $table = 'features';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';


     protected $fillable = [

        'featureName',
    ];


    public function getArrayResponse() {
        
        return [

            'id' => $this->id,
            'featureName' => $this->featureName,
        ];
    }
}
