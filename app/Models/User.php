<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use App\Components\PushNotification;

class User extends Authenticatable
{
    //Status Constants
    const STATUS_ACTIVE    =   1;
    const STATUS_INACTIVE  =   0;
    const CREATED_AT       =   'createdAt';
    const UPDATED_AT       =   'updatedAt';
    const SUPER_ADMIN      =   'super_admin';
    const STUDENT          =   'student';    
    const HOSTEL_ADMIN     =   'hostel_admin';    
    
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'roleId',
        'resetPasswordToken',
        'createdResetPToken',
        'avatarFilePath',
        'deviceToken',
        'deviceType',
        'verified',
        'onlineStatus',
        'language',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'resetPasswordToken','deviceToken',
    ];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * @return mixed
     */
    public function role()
    {
        return $this->hasOne(Roles::class,'id','roleId');
    }

    /**
     * @return mixed
     */

    public function statusVerified(){
        return ($this->verified) ? 'Active' : 'In-Active';
    }

    public function isSuperAdmin(){
        if($this->role->label == self::SUPER_ADMIN)
           
            return true;
        return false;
    }


    public function isHostelAdmin(){
        
        if ($this->role->label == self::HOSTEL_ADMIN)
            return true;
                return false;
    }


    public function isStudent(){
        if ($this->role->label == self::STUDENT){
            return true;
                return flase;
        }
    }

    public function isVerified(){
        if($this->verified == self::STATUS_ACTIVE)
            
            return true;
        return false;
    }


      public function isValidUser(){

        if ($this->isSuperAdmin() )
            return true;
        
        elseif ($this->isHostelAdmin() )
            return true;
  
        elseif ($this->isStudent() )
            return true;
                return false;
    }

    public static function getTypes(){
        return [
                self::SUPER_ADMIN => 'super_admin',
            ];
    }
    
    public function getArrayResponse() {
        return [
            'id'            => $this->id,
            'email'         => $this->username,
            'verified'      => $this->statusVerified(),
            'roles' => [
                'id'        => $this->roleId,    
                'label'     => $this->role->label,
            ],
            // 'image'         => $this->getImage(),
            'onlineStatus'  => $this->onlineStatus,
        ];
    }


    public function sendEmailCustomer($mySubject,$content){
        \Mail::send('mails.adminMail', [
                'firstName' => $this->customer->firstName,"content"=>$content,
            ], function ($message) use ($mySubject) {
                $message->from('hassanamir210@gmail.com', 'The Gold Spring Team');
                $message->to($this->username)->subject($mySubject);
        });
        return true;
    }
}
