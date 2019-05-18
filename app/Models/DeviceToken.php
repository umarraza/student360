<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'device_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deviceToken',
        'deviceType',
        'userId',
    ];

    public function getArrayResponse() {
        return [
        		'id'  			=> $this->id,
             	'deviceToken'   => $this->deviceToken,
                'deviceType'    => $this->deviceType,
             	'userId' 		=> $this->userId,
        ];
    }
}
