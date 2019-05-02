<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'daily_attendences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendenceDate',
        'checkInTime',
        'checkOutTime',
        'studentId',
        'instituteId',
    ];

    public function getArrayResponse() {
        return [
        		'id'  			=> $this->id,
                'attendenceDate'=> $this->attendenceDate,
             	'checkInTime'   => $this->checkInTime,
                'checkOutTime'  => $this->checkOutTime,
             	'studentId' 	=> $this->studentId,
                'instituteId'   => $this->instituteId,
        ];
    }
}
