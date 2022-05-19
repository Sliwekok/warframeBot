<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use App\Notifications\PriceNotifications;


class sendNotification implements ShouldBroadcastNow
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $user;
  public $message;
  public $channel;
  public $event;

  public function __construct($user, $message)
  {
      $this->user = $user;
      $this->message = $message;
      $this->channel = $this->broadcastOn();
      $this->event = $this->broadcastAs();
  }

  // set the channel of the pusher
  public function broadcastOn()
  {
    return new Channel($this->user->name);
  }

  // set event for pusher
  public function broadcastAs()
  {
    return "NotifyUser";
  }
  public function toArray($notifiable)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'amount' => $this->invoice->amount,
        ];
    }
}