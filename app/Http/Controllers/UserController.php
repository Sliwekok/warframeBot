<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){   
        $platform = DB::table('users')->where('name',  Auth::user()->name)->first()->platform;
        return view('account', [
            'platform' => $platform
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
