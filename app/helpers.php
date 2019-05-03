<?php

use App\Models\User;
use App\Models\Institute;
use App\Models\ParentStudent;
use App\Models\MyParent;
use App\Models\Student;
use Carbon\Carbon;

function hex2rgb($hex) 
{
  $hex = str_replace("#", "", $hex);

  if(strlen($hex) == 3) {
     $r = hexdec(substr($hex,0,1).substr($hex,0,1));
     $g = hexdec(substr($hex,1,1).substr($hex,1,1));
     $b = hexdec(substr($hex,2,1).substr($hex,2,1));
  } else {
     $r = hexdec(substr($hex,0,2));
     $g = hexdec(substr($hex,2,2));
     $b = hexdec(substr($hex,4,2));
  }
  $rgb = array($r, $g, $b);
  //return implode(",", $rgb); // returns the rgb values separated by commas
  return $rgb; // returns an array with the rgb values
}

function storeMedia($file_data) 
{
    try
    {
        @list($type, $file_data) = explode(';', $file_data);
        @list(, $file_data) = explode(',', $file_data); 
        @list(, $type) = explode('/', $type); 
        
        $file_name = 'media_'.time().'.'.$type; //generating unique file name;
        
        \Storage::disk('public')->put($file_name,base64_decode($file_data));
    }
    catch (\Exception $e) 
    {
        return false;
    }

    return $file_name; 
}

// function postCommentNotify($postId,$commentorId,$comment) 
// {
//     try
//     {
//         $post           = UserPost::find($postId);

//         $postOwner      = UserDetail::find($post->userDetailId);

//         $postCommentor  = UserDetail::find($commentorId);

//         $nameOfCommentor = $postCommentor->firstName." ".$postCommentor->lastName;
        
//         $title   = "Comment On Post";
//         $message = $nameOfCommentor." commented on your post.";

//         $postOwner->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true; 
// }

// function storyCommentNotify($storyId,$commentorId,$comment) 
// {
//     try
//     {
//         $story           = UserStory::find($storyId);

//         $storyOwner      = UserDetail::find($story->userDetailId);

//         $storyCommentor  = UserDetail::find($commentorId);

//         $nameOfCommentor = $storyCommentor->firstName." ".$storyCommentor->lastName;
        
//         $title   = "Comment On Story";
//         $message = $nameOfCommentor." commented on your story.";

//         $storyOwner->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true;
// }

// function postLikeNotify($postId,$likerId) 
// {
//     try
//     {
//         $post           = UserPost::find($postId);

//         $postOwner      = UserDetail::find($post->userDetailId);

//         $postLiker      = UserDetail::find($likerId);

//         $nameOfLiker    = $postLiker->firstName." ".$postLiker->lastName;
        
//         $title   = "Like On Post";
//         $message = $nameOfLiker." likes your post.";

//         $postOwner->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true; 
// }

// function storyLikeNotify($storyId,$likerId) 
// {
//     try
//     {
//         $story           = UserStory::find($storyId);

//         $storyOwner      = UserDetail::find($story->userDetailId);

//         $storyLiker      = UserDetail::find($likerId);

//         $nameOfLiker     = $storyLiker->firstName." ".$storyLiker->lastName;
        
//         $title   = "Like On Story";
//         $message = $nameOfLiker." likes your story.";

//         $storyOwner->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true;
// }

// function receiveFriendRequestNotify($receiver,$sender) 
// {
//     try
//     {
//         $sender          = UserDetail::find($sender);
//         $receiver        = UserDetail::find($receiver);

//         $senderName      = $sender->firstName." ".$sender->lastName;
        
//         $title   = "New Friend Request";
//         $message = $senderName." sent you the friend request.";

//         $receiver->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true;
// } 


// function approveFriendRequestNotify($receiver,$sender) 
// {
//     try
//     {
//         $sender          = UserDetail::find($sender);
//         $receiver        = UserDetail::find($receiver);

//         $senderName      = $sender->firstName." ".$sender->lastName;
        
//         $title   = "Friend Request Accepted";
//         $message = $senderName." has accepted your friend request.";

//         $receiver->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true;
// }

// function newPostNotify($receiver,$sender) 
// {
//     try
//     {
//         $sender          = UserDetail::find($sender);
//         $receiver        = UserDetail::find($receiver);

//         $senderName      = $sender->firstName." ".$sender->lastName;
        
//         $title   = "Friend Request Accepted";
//         $message = $senderName." has accepted your friend request.";

//         $receiver->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true;
// }

// function newStoryNotify($receiver,$sender) 
// {
//     try
//     {
//         $sender          = UserDetail::find($sender);
//         $receiver        = UserDetail::find($receiver);

//         $senderName      = $sender->firstName." ".$sender->lastName;
        
//         $title   = "Friend Request Accepted";
//         $message = $senderName." has accepted your friend request.";

//         $receiver->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true;
// } 

// function newPostTagNotify($receiver,$sender) 
// {
//     try
//     {
//         $sender          = UserDetail::find($sender);
//         $receiver        = UserDetail::find($receiver);

//         $senderName      = $sender->firstName." ".$sender->lastName;
        
//         $title   = "Tagged in a post";
//         $message = $senderName." has tagged you in a post.";

//         $receiver->user->sendNotifications($title,$message);
//     }
//     catch (\Exception $e) 
//     {
//         return false;
//     }

//     return true;
// }

function makeArrayString($arrString)
{
    $removedInvertedCommas = str_replace("\"", "",$arrString);
    $removedBraces = str_replace("[","",$removedInvertedCommas);
    $removedBraces = str_replace("]","",$removedBraces);
    

    return $removedBraces;
}

function instituteSignup($id)
{
    try 
    {
        $user = User::find($id);
        $email = $user->username;
        $name  = $user->admin->firstName." ".$user->admin->lastName;
        \Mail::send('Mails2.instituteSignup', [
                    'name'    => $name,
                ], function ($message) use ($email){
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($email)->subject('Successfull Signup');
            });
    } 
    catch (Exception $e) 
    {
      
    }
    return true;
}


function parentSignup($id,$password,$instituteId)
{
    //try 
    {
        $user = User::find($id);
        $email = $user->username;
        $name  = $user->parent->firstName." ".$user->parent->lastName;

        $institute = Institute::find($instituteId);
        $schoolName  = $institute->name;
        \Mail::send('Mails2.parentSignup', [
                    'name'       => $name,
                    'email'      => $email,
                    'password'   => $password,
                    'schoolName' => $schoolName,
                ], function ($message) use ($email){
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($email)->subject('Wellcome');
            });
    } 
    //catch (Exception $e) 
    {
      
    }
    return true;
}


function trainerSignup($id,$password)
{
    //try 
    {
        $user = User::find($id);
        $email = $user->username;
        $name  = $user->trainer->firstName." ".$user->trainer->lastName;

        $institute = Institute::find($user->trainer->instituteId);
        $schoolName  = $institute->name;
        \Mail::send('Mails2.secondaryAdminSignup', [
                    'name'       => $name,
                    'email'      => $email,
                    'password'   => $password,
                    'schoolName' => $schoolName,
                ], function ($message) use ($email){
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($email)->subject('Wellcome');
            });
    } 
    //catch (Exception $e) 
    {
      
    }
    return true;
}

function secondaryAdminSignup($id,$password)
{
    //try 
    {
        $user = User::find($id);
        $email = $user->username;
        $name  = $user->admin->firstName." ".$user->admin->lastName;

        $institute = Institute::find($user->admin->instituteId);
        $schoolName  = $institute->name;
        \Mail::send('Mails2.secondaryAdminSignup', [
                    'name'       => $name,
                    'email'      => $email,
                    'password'   => $password,
                    'schoolName' => $schoolName,
                ], function ($message) use ($email){
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($email)->subject('Wellcome');
            });
    } 
    //catch (Exception $e) 
    {
      
    }
    return true;
}
function markAttendence($studentId,$instituteId,$dateTime,$subject)
{
    //try 
    {
        $student       = Student::find($studentId);
        $studentUser   = User::find($student->userId);

        $parentStudent = ParentStudent::where('studentId',$student->id)->first();

        $parent        = MyParent::find($parentStudent->parentId);
        $parentUser    = User::find($parent->userId);

        $email       = $parentUser->username;
        $parentName  = $parent->firstName." ".$parent->lastName;
        $studentName = $student->firstName." ".$student->lastName;

        $institute = Institute::find($instituteId);
        $schoolName  = $institute->name;

        $scanDate = Carbon::parse($dateTime)->format('Y-m-d');
        $scanTime = Carbon::parse($dateTime)->format('H:i:s');

        \Mail::send('Mails2.scanQRcode', [
                    'studentName'   => $studentName,
                    'parentName'    => $parentName,
                    'schoolName'    => $schoolName,
                    'scanDate'      => $scanDate,
                    'scanTime'      => $scanTime,
                ], function ($message) use ($email,$subject){
                    $message->from('info@asuretots.com', 'The Asure Tots Team');
                    $message->to($email)->subject($subject);
            });
    } 
    //catch (Exception $e) 
    {
      
    }
    return true;
}