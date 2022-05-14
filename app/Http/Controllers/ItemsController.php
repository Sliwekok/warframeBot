<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Items;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;


class ItemsController extends Controller
{
    
    // show default view
    public function index(){
        $watched = $this->allWatched();
        $platform = DB::table('users')->where('name',  Auth::user()->name)->first()->platform;
        return view('items', [
            'title' => "Watched items",
            'watched' => $watched,
            'platform'=> $platform
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

    // make api call to warframe.market api

    // napisać własny algorytm do sortowania
    public function searchItem($item){
        if(empty($item)) return redirect()->back();
        $data = $this->sortByLowestPrice($this->getData($item));
        $platform = DB::table('users')->where('name',  Auth::user()->name)->first()->platform;
        return view('search', [
            'title' => "Watched items",
            'items' => $data,
            'platform'=> $platform,
            'itemName' => $item
        ]);
    }

    // get data from api
    private function getData($item){
        // replace space to _ as api requirement
        $item = strtolower(preg_replace('/\s+/', '_', $item));
        $url = "https://api.warframe.market/v1/items/$item/orders?include=item";
        $client = new \GuzzleHttp\Client();
        $response = $client->request("GET", $url);
        // transform to json format, on paginate function it returns to colletion format
        return json_decode($response->getBody(), true)['payload']['orders'];
    }

    // sort items by lowest price, only active items, sellable and from active users
    private function sortByLowestPrice($data){
        $fixedItems = [];
        $maxOffers = 10;
        // trim useless data from api response
        foreach($data as $item){
            // check for max offers showed on page
            if(count($fixedItems) >= $maxOffers) break; 
            // if item is not sellable - skip it
            if($item['order_type'] !== 'sell') continue;
            // if user is not in game - skip it
            if($item['user']['status'] !== 'ingame') continue;
            array_push($fixedItems, $item);
        }
        // sort item by lowest price
        // select key from array to sort
        $key = array_column($fixedItems, 'platinum');
        array_multisort($key, SORT_ASC, $fixedItems);
       
        return $fixedItems;
    }
}
