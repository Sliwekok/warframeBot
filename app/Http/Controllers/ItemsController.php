<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Items;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


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
        $user = Auth::user()->name;
        $watched = Items::where('user', $user)->get();
        return $watched;
    }
    
    // add item to be followed
    public function addToWatch(Request $request){
        // validate data
        $validatedData = Validator::make($request->all(),[
            'name'    => ['required', 'string'],
            'platform'=> ['required', 'string'],
            'price'   => ['required', 'integer']
        ]);
        if($validatedData->fails()) return $this->alertMessage('error', 'Bad credentials', 'Check your data provided');
        // if item is already in watch list - update price of it
        $builder = Items::where('user', Auth::user()->name)->where('name', $request->name)->where('platform', $request->platform);
        if($builder->exists()){
            $builder->update(['price' => $request->price]);
        }
        else{
            // fill model with data
            $item = new Items;
            $item->user = Auth::user()->name;
            $item->name = $request->name;
            $item->price = $request->price;
            $item->platform = $request->platform;
            $item->save();
        }
        return redirect('watched');
        return $this->alertMessage('success', 'Item followed', "$request->name added to your watch list");
    }

    // make api call to warframe.market api
    public function searchItem($item){
        if(empty($item)) return redirect()->back();
        $data = $this->sortByLowestPrice($this->getData($item));
        $platform = DB::table('users')->where('name',  Auth::user()->name)->first()->platform;
        return view('search', [
            'title' => $item,
            'items' => $data,
            'platform'=> $platform,
            'itemName' => $item
        ]);
    }

    // delete from watched items list
    public function delete(Request $request){
        $user = Auth::user()->name;
        $action = Items::where('user', $user)->where('name', $request->item)->where('platform', $request->platform)->delete();
        if($action){
            return $this->alertMessage('success', 'Item deleted', 'You no longer watch for this item.');
        }
        else{
            return $this->alertMessage('error', 'Server error', 'Something went wrong during operation');
        }
    }

    // update item from watch list
    public function update(Request $request){
        // validate data
        $validatedData = Validator::make($request->all(),[
            'name'    => ['required', 'string'],
            'platform'=> ['required', 'string'],
            'price'   => ['required', 'integer']
        ]);
        if($validatedData->fails()) return $this->alertMessage('error', 'Bad credentials', 'Check your data provided');
        // check if item exists
        $builder = Items::where('user', Auth::user()->name)->where('name', $request->name)->where('platform', $request->platform);
        if($builder->exists()){
            $builder->update(['price' => $request->price]);
            return redirect('/watched');
        }
        else{
            return redirect()->back();
        }
    }

    // get data from api
    private function getData($item){
        // replace space to _ as api requirement
        $platform = DB::table('users')->where('name',  Auth::user()->name)->first()->platform;
        $item = strtolower(preg_replace('/\s+/', '_', $item));
        $url = "https://api.warframe.market/v1/items/$item/orders?include=item";
        // set up headers to get right platform offers
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Platform: '. $platform;
        $client = new \GuzzleHttp\Client(['headers' => $headers]);

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
