<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Items;

class ScanMarket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        $users = User::all();  
        // go through each user, next item and search in api for prices
        foreach($users as $user){
            $watchlist = Items::where('user', $user->name)->get();
            foreach ($watchlist as $followed){
                $itemname = $followed->name;
                $price = $followed->price;
                $platform = $followed->platform;
                $data = $this->checkPriceRange($this->getData($itemname, $platform), $price, $itemname);
                // if returned array is not empty - offers is available
                if(count($data) > 0){
                    // write some notification plugin
                }
            }  
        }
        
    }

    // get data from api
    private function getData($item, $platform){
        // replace space to _ as api requirement
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
    private function checkPriceRange($data, $price, $itemname){
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
            // check if price is in range
            if($item['platinum'] > $price) continue;
            $item['item'] = $itemname;
            array_push($fixedItems, $item);
        }
        // sort item by lowest price
        // select key from array to sort
        $key = array_column($fixedItems, 'platinum');
        array_multisort($key, SORT_ASC, $fixedItems);
        
        return $fixedItems;
    }
}
