<div id="userNotifications">        
    @foreach ($notifications as $notif)
    <div class="col-12 notification">
        <div class="col-12">
            <p class="itemname"><a href="{{url('/readNotifications/'. $notif->id)}}" target="_blank">{{$notif->data['item']}}</a></p>
            <p class="description">{{$notif->data['message']}}</p>
            <p class="added">{{$notif->created_at}}</p>
            <div class="col-1 offset-11  orderMenagment">
                <div class="col-12"><span class="editOrder delete deleteNotificaion" data-notification-id="{{$notif->id}}" data-toggle="tooltip" data-bs-placement="top" title="Delete notification"><i class="icon icon-cancel"></i></span></div>
            </div>
        </div>
    </div>
    @endforeach
</div>