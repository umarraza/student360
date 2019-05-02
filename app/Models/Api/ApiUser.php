<?php

/* Folder Location */

namespace App\Models\Api;

/* Dependencies */

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ApiUser.
 */
class ApiUser extends User {
    public static function loginUser($id,$token,$message = '') {

        /* Find User For Provided Email */
        $model = Self::where(['id' => $id])->first();

        // if ($model->verified == Self::STATUS_INACTIVE) {
        //     return Self::generateErrorMessage(false, 400, 'Account not verified. Please verify your account through the verification email sent to your email id.');
        // }
        return $token;
        return [
            'status' => true,
            'data' => [
                'message' => ($message == '') ? 'User Login successfully.' : $message,
                'user' => $model->getArrayResponse(),
                'token' => $token
            ]
        ];
    }

    public function sendEmailForgotPassword($token,$firstName)
    {
        try
        {
            \Mail::send('Mails.forgotPassword', [
                    'token' => $token,
                    'firstName' => $firstName,
                    'userId' => $this->id,
                ], function ($message) {
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($this->username)->subject('Password Reset');
            });
        }
        catch (\Exception $e) 
        {
        }

        return true;
    }


    public function sendWellcomeEmailParent($password,$SFN,$SLN,$IN,$PFN,$PLN)
    {
        try
        {
           \Mail::send('Mails.welcomeParent', [
                    'password'  => $password,
                    'SFN'       => $SFN,
                    'SLN'       => $SLN,
                    'PFN'       => $PFN,
                    'PLN'       => $PLN,
                    'IN'        => $IN,
                    'UN'        => $this->username,
                ], function ($message) {
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($this->username)->subject('Wellcome!');
            });
        }
        catch (\Exception $e) 
        {
        }

        return true; 
    }

    public function sendWellcomeTrainer($password,$TFN,$TLN,$IN)
    {
        try
        {
           \Mail::send('Mails.welcomeTrainer', [
                    'password'  => $password,
                    'TFN'       => $TFN,
                    'TLN'       => $TLN,
                    'IN'        => $IN,
                    'UN'        => $this->username,
                ], function ($message) {
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($this->username)->subject('Wellcome!');
            });
        }
        catch (\Exception $e) 
        {
        }

        return true; 
    }
}