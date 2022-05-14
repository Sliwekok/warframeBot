@extends('layouts.app')

@section('content')

    <div class="col-12" id="searched">
        <div class="col-12 mainText"><h3>Best offers of {{$itemName}}</h3></div>

        <div class="col-10 sellerPanel" id="sellerLegend">
            <div class="col-3">
                <p>Seller</p>
            </div>
            <div class="col-2 text-center">
                <p class="text-center col-12">Reputation</p>
            </div>
            <div class="col-2 text-center">
                <p class="text-center col-12">Status</p>
            </div>
            <div class="col-2 text-center">
                <p class="text-center col-12">Price</p>
            </div>
            <div class="col-2 text-center">
                <p class="text-center col-12">Amount</p>
            </div>
        </div>
        @foreach($items as $order)
            <div class="col-10 sellerPanel">
                <div class="col-3">
                    <p>{{$order['user']['ingame_name']}}</p>
                </div>
                <div class="col-2 text-center">
                    <p class="text-center col-12">{{$order['user']['reputation']}}<i class="demo-icon icon-thumbs-up"></i></p>
                </div>
                <div class="col-2 text-center">
                    <p class="text-center col-12">{{$order['user']['status']}}</p>
                </div>
                <div class="col-2 text-center">
                    <p class="text-center col-12">{{$order['platinum']}} platinum</p>
                </div>
                <div class="col-2 text-center">
                    <p class="text-center col-12">{{$order['quantity']}}</p>
                </div>
                <div class="col-1 text-center">
                    <a tabindex="0" class="showPopover text-center buyButton" data-bs-container="body" data-bs-trigger="focus" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="/w {{$order['user']['ingame_name']}} Hi! Want to buy: {{$itemName}} for {{$order['platinum']}} platinum."><i class="demo-icon icon-handshake-o"></i> Buy</a>
                </div>
            </div>
        @endforeach
    </div>

@endsection