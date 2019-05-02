<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentInstitute extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'parent_institute';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parentId',
        'instituteId',
        // 'createdAt',
        // 'updatedAt'
    ];
}
