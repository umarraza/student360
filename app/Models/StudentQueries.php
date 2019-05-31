<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQueries extends Model
{
    protected $table = 'queries_by_student';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     protected $fillable = [

        'question',
        'answers',
        'type',
        'hostelId',
        'userId',

    ];

    public function getArrayResponse() {
        
        return [

                'id'        =>  $this->id,
                'question'  =>  $this->question,
                'answers'   =>  $this->answers,
                'type'      =>  $this->type,
                'hostelId'  =>  $this->hostelId,
                'userId'    =>  $this->userId,
        ];
    }
}
