<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'longitude',
        'latitude',
        'address',
        'startDateTime',
        'endDateTime',
        'instituteId',
    ];

    public function getArrayResponse() {
        return [
        		'id'  			=> $this->id,
             	'title'   		=> $this->title,
                'description'  	=> $this->description,
             	'longitude' 	=> $this->longitude,
             	'latitude' 		=> $this->latitude,
             	'address' 		=> $this->address,
             	'startDateTime' => $this->startDateTime,
             	'endDateTime' 	=> $this->endDateTime,
        ];
    }
}
