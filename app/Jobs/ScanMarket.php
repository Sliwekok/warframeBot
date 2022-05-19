<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;
use App\Items;
// use App\Events\sendNotification;
use App\Notifications\PriceNotifications;
use Pusher\Pusher;


class ScanMarket
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
                    $message = "$itemname is available in lower price!";
                    // save notification in database
                    // since broadcasting doesn't work as expected - notifications are sent here
                    
                    // in notification handler - we want to send notification about cheapest offer available at a time
                    // so we access $data array at the index of 0 and send notification about data details, seller and item details
                    $seller = $data[0]['seller'];
                    // check if user has been already notified about price - if so, skip notification
                    if($this->checkIfUserHasNotificationAboutItem($user, $seller, $itemname) === true) continue 2;
                    
                    // trigger notification to DB
                    $user->notify(new PriceNotifications($user, $message, $itemname, $seller));
                    // send an event trigger about item offer
                    $this->runEventNotif($user, $message);
                }
            }  
        }
        return;
        
    }

    // get data from api
    // return array
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
    // return array
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
            // set up item name and seller of item
            $item['item'] = $itemname;
            $item['seller'] = $item['user']['ingame_name'];
            // merge arrays
            array_push($fixedItems, $item);
        }
        // sort item by lowest price
        // select key from array to sort
        $key = array_column($fixedItems, 'platinum');
        array_multisort($key, SORT_ASC, $fixedItems);
        return $fixedItems;
    }

    // check if user has been already notified of offer
    // returns bool
    private function checkIfUserHasNotificationAboutItem($user, $seller, $itemname){
        // create counter, that counts the number of notifications that are already received about item (with peculiar seller)
        $counter = 0;
        // access each user unread notification
        foreach($user->unreadNotifications as $notification){
            // check notification data
            if(
                $notification->data['seller'] == $seller &&
                $notification->data['item'] == $itemname
            ){   
                $counter++;
            }
        }   
        if($counter > 0) return true;
        else return false;
    }

    // send user a notification about price change
    private function runEventNotif($user, $message){
        // call an event 
        /*  With current version of laravel it doesn't work
        *   broadcast event file (App\Events\sendNotification.php) has error:
        *       array_merge(): Expected parameter 2 to be an array, null given 
        *   Switched to using pusher by hand without any laravel support
        *   Even in prevous version of development - broadcast event logged successfully data, but did't send it to frontend (even though channel and event were set up correctly)
        */
        // event(new sendNotification($user, $message));

        // set up variables for pusher
        $key = env('PUSHER_APP_KEY');
        $secret = env('PUSHER_APP_SECRET');
        $app_id = env('PUSHER_APP_ID');
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
            'encrypted' => true,
        ];
        $pusher = new Pusher($key, $secret, $app_id, $options);
        // channel, event, data
        $pusher->trigger($user->name, 'NotifyUser', $message);
        
    }
}
