<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiUser extends User {
    public static function loginUser($id,$token,$message = '') {
        /* Find User For Provided Email */
        $model = Self::where(['id' => $id])->first();
        if ($model->verified == Self::STATUS_INACTIVE) {
            // return Self::generateErrorMessage(false, 400, 'Account not verified. Please verify your account through the verification email sent to your email id.');
            return "Your account is on approval by administrator";
        }
        return $token;
    }

    public function sendEmailForgotPassword($token,$firstName){
        $link = "http://antonionascimentofrancisco.pt/GoldSpring/pages/resetPassword/".$this->id."/".$token;
        \Mail::send('mails.forgot-password', [
                'link'       =>  $link,
                'firstName'  =>  $firstName,
            ], function ($message) {
                $message->from('info@antonionascimentofrancisco.pt', 'The Gold Spring Team');
                $message->to($this->username)->subject('Password Reset');
        });
        return true;
    }

    public function sendWellcomeEmailCustomer(){
        \Mail::send('mails.wellcome', [
                'firstName' => $this->customer->firstName,
            ], function ($message) {
                $message->from('info@antonionascimentofrancisco.pt', 'The Gold Spring Team');
                $message->to($this->username)->subject('Wellcome To Gold Spring');
        });
        return true;
    }


    public function sendWellcomeEmailSP($password){
        \Mail::send('mails.wellcomeSP', [
                'name'      => $this->ServiceProvider->name,
                'password'  => $password,
                'username'  => $this->username,
            ], function ($message) {
                $message->from('info@antonionascimentofrancisco.pt', 'The Gold Spring Team');
                $message->to($this->username)->subject('Wellcome To Gold Spring');
        });
        return true;
    }

    public function approvePendingMail(){
        \Mail::send('mails.approvePending', [
                'name'      => $this->ServiceProvider->name
            ], function ($message) {
                $message->from('info@antonionascimentofrancisco.pt', 'The Gold Spring Team');
                $message->to($this->username)->subject('Wellcome To Gold Spring');
        });
        return true;
    }

    // public function sendEmailCustomer($mySubject,$content){
    //     \Mail::send('mails.adminMail', [
    //             'firstName' => $this->customer->firstName,$content,
    //         ], function ($message) use ($mySubject) {
    //             $message->from('hassanamir210@gmail.com', 'The Gold Spring Team');
    //             $message->to($this->username)->subject($mySubject);
    //     });
    //     return true;
    // }
}