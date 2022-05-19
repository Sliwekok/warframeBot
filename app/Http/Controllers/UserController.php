<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Items;

class UserController extends Controller
{
    public function index(){   
        $platform = DB::table('users')->where('name',  Auth::user()->name)->first()->platform;
        $user = Auth::user();
        // note all notifications as read
        $user->notifications->markAsRead();
        $notifications = $user->notifications->take(15)->sortByDesc('created_at');
        return view('account', [
            'notifications' => $notifications,
            'platform' => $platform,
            'user'  => $user->name
        ]);
    }

    // update user default platform search
    public function changePlatform(Request $request){
        $user = Auth::user()->name;
        $platform = $request->platform;
        $builder = DB::table('users')->where('name', $user);
        if($builder->first()->platform == $platform) return 0;
        if($builder->update(["platform" => $platform])){
            return $this->alertMessage("success", "Platform updated", "Platform updated successfully");
        }
        else{
            return $this->alertMessage("error", "Server error", "Try again later");
        }
        return;
    }


    // mark user notifications as read
    public function setNotificationsAsRead($notifId){
        $user = Auth::user();
        $notification = $user->notifications->find($notifId);
        $notification->markAsRead();
        // redirect to sellers page 
        $data = $notification->data['item'];
        return redirect("/search/$data");
    }

    // delete notification
    public function deleteNotification($notifId){
        $user = Auth::user();
        $notification = $user->notifications->find($notifId);
        $notification->markAsRead();
        $notification->delete();
        return true;
    }
    // return message for user
    // extends blade layout alert and js showAlert()
    private function alertMessage($status, $header, $message){
        $info = [
            'status'    => $status,
            'header'    => $header,
            'message'   => $message
        ];
        return $info;
    }
}
