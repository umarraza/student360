<?php

use App\Models\User;
use App\Models\Institute;
use App\Models\ParentStudent;
use App\Models\MyParent;
use App\Models\Student;
use App\Models\DeviceToken;

use Carbon\Carbon;

function findDeviceToken($userId, $title, $message){

    $deviceTokens= DeviceToken::where('userId', '=', $userId)->get();

    foreach ($deviceTokens as $value) {

        sendPushNotification($title,$message,$value->deviceToken,$value->deviceType);

    }

}

function sendPushNotification($title,$myMessage,$deviceToken,$deviceType)
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
            'to' => $deviceToken, //single token
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