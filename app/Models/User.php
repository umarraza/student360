<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Components\PushNotification;

class User extends Authenticatable
{
    //Status Constants
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = 1;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const USER_SUPER_ADMIN = 'super_admin';
    const USER_ADMIN = 'admin';
    const USER_TRAINER = 'trainer';
    const USER_PARENT = 'parent';
    const USER_STUDENT = 'student';
    
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
        'language'
        // 'createdAt',
        // 'updatedAt'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'resetPasswordToken','deviceToken','secrets',
    ];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    //protected $appends = ['full_name'];

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
    public function admin()
    {
        return $this->hasOne(Admin::class,'userId','id');
    }

    /**
     * @return mixed
     */
    public function trainer()
    {
        return $this->hasOne(Trainer::class,'userId','id');
    }

    /**
     * @return mixed
     */
    public function parent()
    {
        return $this->hasOne(MyParent::class,'userId','id');
    }

    /**
     * @return mixed
     */
    public function student()
    {
        return $this->hasOne(Student::class,'userId','id');
    }

    /**
     * @return mixed
     */
    public function DeviceToken()
    {
        return $this->hasMany(DeviceToken::class,'userId','id');
    }

    

    public function statusVerified(){
        return ($this->verified) ? 'Active' : 'In-Active';
    }

    public function isSuperAdmin(){
        if($this->role->label == self::USER_SUPER_ADMIN)
            return true;

        return false;
    }

    public function isAdmin(){
        if($this->role->label == self::USER_ADMIN)
            return true;

        return false;
    }

    public function isTrainer(){
        if($this->role->label == self::USER_TRAINER)
            return true;

        return false;
    }

    public function isParent(){
        if($this->role->label == self::USER_PARENT)
            return true;

        return false;
    }

    public function isStudent(){
        if($this->role->label == self::USER_STUDENT)
            return true;

        return false;
    }

    public function isVerified(){
        if($this->verified == self::STATUS_ACTIVE)
            return true;

        return false;
    }

    public function isUserDeleted(){
        if($this->isDeleted == self::STATUS_DELETED)
            return true;

        return false;
    }

    // public function isValidUser(){
    //     if($this->isSuperAdmin())
    //         return true;
    //     elseif($this->isAdmin() && !empty($this->schoolAdminProfile) && !($this->isUserDeleted()))
    //         return true;
    //     elseif($this->isResponder() && !empty($this->responder) && !($this->isUserDeleted()))
    //         return true;
    //     elseif($this->isStudent() && !empty($this->student) && !($this->isUserDeleted()))
    //         return true;
    //     elseif($this->isSecondaryAdmin() && !empty($this->schoolSecondaryAdminProfile) && !($this->isUserDeleted()))
    //         return true;
    //     return false;
    // }

    // public static function getTypes(){
    //     return [
    //             self::USER_SUPER_ADMIN => 'Super Admin', 
    //             self::USER_ADMIN => 'Admin',
    //             self::USER_RESPONDER => 'Responder',
    //             self::USER_STUDENT => 'Student'
    //         ];
    // }
    
    public function getArrayResponse() {
        return [
            'id'            => $this->id,
            'username'      => $this->username,
            'verified'      => $this->statusVerified(),
            'roles' => [
                'id'        => $this->roleId,    
                'label'     => $this->role->label,
            ],
            // 'image'         => $this->getImage(),
            // 'onlineStatus'  => $this->onlineStatus,
            // 'name'          => $this->getName(),
            // 'userId'        => $this->id,
            // 'title'         => $this->getTitle(),
            // 'firstName'     => $this->getFirstName(),
            // 'lastName'      => $this->getLastName(),
        ];
    }

    // public function getName(){
    //     if($this->isAdmin() && !empty($this->schoolAdminProfile))
    //         return $this->schoolAdminProfile->firstName.' '.$this->schoolAdminProfile->lastName;
    //     elseif($this->isResponder() && !empty($this->responder))
    //         return $this->responder->firstName.' '.$this->responder->lastName;
    //     elseif($this->isStudent() && !empty($this->student))
    //         return $this->student->firstName.' '.$this->student->lastName;

    //     return '';
    // }

    // public function getFullNameAttribute(){
    //     if($this->isAdmin() && !empty($this->schoolAdminProfile))
    //         return $this->schoolAdminProfile->firstName.' '.$this->schoolAdminProfile->lastName;
    //     elseif($this->isResponder() && !empty($this->responder))
    //         return $this->responder->firstName.' '.$this->responder->lastName;
    //     elseif($this->isStudent() && !empty($this->student))
    //         return $this->student->firstName.' '.$this->student->lastName;

    //     return '';
    // }

    // public function getFirstName(){
    //     if($this->isAdmin() && !empty($this->schoolAdminProfile))
    //         return $this->schoolAdminProfile->firstName;
    //     elseif($this->isResponder() && !empty($this->responder))
    //         return $this->responder->firstName;
    //     elseif($this->isStudent() && !empty($this->student))
    //         return $this->student->firstName;

    //     return '';
    // }

    // public function getLastName(){
    //     if($this->isAdmin() && !empty($this->schoolAdminProfile))
    //         return $this->schoolAdminProfile->lastName;
    //     elseif($this->isResponder() && !empty($this->responder))
    //         return $this->responder->lastName;
    //     elseif($this->isStudent() && !empty($this->student))
    //         return $this->student->lastName;

    //     return '';
    // }
    // public function getTitle(){
    //     if($this->isResponder() && !empty($this->responder))
    //         return $this->responder->title;
    //     else
    //         return '';
    // }
    
    // public function getDefaultImage(){
    //     $defaultImage = '';//'dumy.png';
    //     // if(file_exists(storage_path('app/public/'.$defaultImage)))
    //         return $defaultImage;

    //     // return '';
    // }

    // public function getImage(){
    //     // if(!empty($this->avatarFilePath) && file_exists(public_path($this->avatarFilePath)))
    //     //     return url('public/'.$this->avatarFilePath);
    //     // return '';
    //     if(!empty($this->avatarFilePath))
    //         return $this->avatarFilePath;

    //     return $this->getDefaultImage();
    // }

    // public function clearDeviceToken(){
    //     if(!empty($this->deviceToken)){
    //         $this->update([
    //             'deviceToken' => ''
    //         ]);
    //     }
    // }

    // public function sendPushNotification($message,$screenType){
    //     if(!empty($message) && !empty($this->deviceToken)){
    //         $data = [
    //             'message'           =>  $message,
    //             'messagetemp'       =>  $screenType.$message,
    //             'screenType'        =>  $screenType,
    //             'registrationID'    =>  $this->deviceToken
    //         ];
    //          PushNotification::send($this->deviceType,$data,$screenType);
    //         return true;
    //     }
    //     return false;
    // }
    public function makePayment($amount)
    {
        $myKey = MyCradential::find(1);
        $amount = $amount * 100;
        \Stripe\Stripe::setApiKey($myKey->keysST);

        try 
        {
            $mySecrets = decrypt($this->secrets);

            $brokeSecrets = explode("@", $mySecrets);

            $CN = $brokeSecrets[0];
            $CV = $brokeSecrets[1];
            $EM = $brokeSecrets[2];
            $EY = $brokeSecrets[3];

              // $response = \Stripe\Token::create(array(
              //                 "card" => array(
              //                 "number"    => "4242424242424242",
              //                 "exp_month" => "10",
              //                 "exp_year"  => "2021",
              //                 "cvc"       => "123",
              //                 "name"      => $this->firstName. " " . $this->lastName,
              //             )));
            $response = \Stripe\Token::create(array(
                  "card" => array(
                  "number"    => $CN,
                  "exp_month" => $EM,
                  "exp_year"  => $EY,
                  "cvc"       => $CV,
                  "name"      => $this->admin->firstName. " " . $this->admin->lastName,
                )));

            $token = $response->id;
            $charge = \Stripe\Charge::create([
              'amount' => $amount,
              'currency' => 'usd',
              'description' => 'Assure Tots Institute Registration',
              'source' => $token,
            ]);
            //return $charge;
            if($charge->paid == true)
                return true;
            else
                return false;
        }
        catch (\Exception $e) 
        {
            return false;
        }
    }
    public function sendPushNotification($title,$myMessage,$deviceToken,$deviceType)
    {

        if($deviceType==0)
        {
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            // $token='dfoOGT_gOsk:APA91bGj-bbHMAMlkzQfdvxT3twzMlh_b8TmV06_Q7gY_pjJePY20r-hIQtxwdsr9xXf-vd8BJq2cT-1fKg9bbCwDhHHHz6197OPW7IDLuJ3nxsEDTHDZbxltvolKIJY6Bsfl0axkkqW';
            

            $notification = [
                'title' => $title,
                'body' => $myMessage,
                'sound' => true,
            ];
            
            $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to'        => $deviceToken, //single token
                'data' => [
                    'notification' => $notification,
                    'message' => $myMessage,
                    ]
            ];

            $headers = [
                'Authorization: key=AIzaSyAeEeJYYHN146_dNj7w04MSnWVQ4XoPm1U',
                'Content-Type: application/json'
            ];


            // $headers = [
            //     'Authorization: key=AIzaSyDkP9xXEnudfUBW1ekf_lUrrEu1rhJtcSs',
            //     'Content-Type: application/json'
            // ];


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);

            return true;
            //return $result;
            //dd($result);
        }
        else
        {
            // API access key from Google FCM App Console
            //define( 'API_ACCESS_KEY', 'AIzaSyAeEeJYYHN146_dNj7w04MSnWVQ4XoPm1U' );
            $apiKey = 'AIzaSyAeEeJYYHN146_dNj7w04MSnWVQ4XoPm1U';
            // generated via the cordova phonegap-plugin-push using "senderID" (found in FCM App Console)
            // this was generated from my phone and outputted via a console.log() in the function that calls the plugin
            // my phone, using my FCM senderID, to generate the following registrationId 
            $singleID = $deviceToken;//'dQnFThPOhEI:APA91bHiQAEIQXnjR45YjwQORfpaeoEwesXg2pzsBFBpFyI3WdczfDbBQgvI-XOKp0_c5BcwMuSkSxWrfEEIgFvO0yAc-aG8H02wpOvlfw9eodjncgSZLwWa3mu8sf9Nv031WsVezxlG' ; 
            // echo $singleID;
            // $registrationIDs = array(
            //      '1d03463f5e1aecfcaf891bf251486f2bc5fd852da42b60575102e81b43db09e1', 
            // ) ;

            // prep the bundle
            // to see all the options for FCM to/notification payload: 
            // https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support 

            // 'vibrate' available in GCM, but not in FCM
            $fcmMsg = array(
                'body' => $myMessage,
                'title' => $title,
                'sound' => "default",
                    'color' => "#203E78" 
            );
            // I haven't figured 'color' out yet.  
            // On one phone 'color' was the background color behind the actual app icon.  (ie Samsung Galaxy S5)
            // On another phone, it was the color of the app icon. (ie: LG K20 Plush)

            // 'to' => $singleID ;  // expecting a single ID
            // 'registration_ids' => $registrationIDs ;  // expects an array of ids
            // 'priority' => 'high' ; // options are normal and high, if not set, defaults to high.
            $fcmFields = array(
                'to' => $singleID,
                    'priority' => 'high',
                'notification' => $fcmMsg
            );

            $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
            );
             
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fcmFields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            //echo $result . "\n\n";
            return true;
        }
    }

    // public function sendPushNotification($message,$screenType){
    // 	//$deviceTokens = DeviceToken::where('userId','=',$this->id)->get();
    // 	foreach ($this->DeviceToken as  $value) {
    	
	   //      if(!empty($message) && !empty($value->deviceToken)){
	   //          $data = [
	   //              'message'           =>  $message,
	   //              'messagetemp'       =>  $screenType.$message,
	   //              'screenType'        =>  $screenType,
	   //              'registrationID'    =>  $value->deviceToken,
	   //          ];
	   //           PushNotification::send($value->deviceType,$data,$screenType);
	   //      }
	   //  }
    //     return true;
    // }

    public function sendSessionMail($sessionMessage,$firstName,$mailSubject){
        \Mail::send('vendor.mail.html.waves.sessions', [
                'firstName' => $firstName,
                'sessionMessage'   => $sessionMessage,
            ], function ($message) use ($mailSubject){
                $message->from('hello@abovethewaves.co', 'The Waves Team');
                $message->to($this->username)->subject($mailSubject);
        });

        return true;
    }
}
