<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Items;
use GuzzleHttp\Client;

class ItemsController extends Controller
{
    
    // show default view
    public function index(){
        $watched = $this->allWatched();
        return view('items', [
            'title' => "Watched items",
            'watched' => $watched,
        ]);
    }

    // show all followed items
    public function allWatched(){
        $user = Auth::user();
        $watched = Items::where('user', $user)->get();
        return $watched;
    }
    
    // add item to be followed
    public function addToWatch(Request $request){
        
        // validate data
        $validatedData = Validator::make($request->all(),[
            'name'    => ['required', 'string'],
            'platform'=> ['required', 'in:pc,xbox,ps,switch', 'string'],
        ]);
        if($validatedData->fails()) return $this->alertMessage('error', 'Bad credentials', 'Check your data provided');
        
        // fill model with data
        $item = new Items;
        $item->user = Auth::user();
        $item->name = $request->name;
        $item->platform = $request->platform;

        // check if that worked
        if($comment->save()) $this->alertMessage('success', 'Item followed', "$request->name added to your watch list");
        else $this->alertMessage('error', 'Server Error', 'Try again later');
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
