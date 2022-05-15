@extends('layouts.app')

@section('content')

<div class="col-10 offset-1" id="watched">
    @if(count($watched) > 0)
        <div class="col-12 mainText"><h3>You're watching <span id="countWatchedItems">{{count($watched)}}</span> @if(count($watched) == 1) item @else items @endif</h3></div>
        @foreach($watched as $order)
            <div class="col-3 orderPanel">
                <div class="col-12"><p class="itemname"><a href="{{url($order->name)}}">{{$order->name}}</a></p></div>
                <div class="col-12"><p class="price">Price: {{$order->price}} platinum</p></div>
                <div class="col-12"><p class="added">Added at: {{$order->updated_at}}</p></div>
                <div class="col-3 offset-9 orderMenagment">
                    <div class="col-6"><span class="editOrder edit" data-price='{{$order->price}}' data-item='{{$order->name}}' data-platform='{{$order->platform}}' data-toggle="tooltip" data-bs-placement="top" title="Delete from watchlist"><i class="icon icon-pencil"></i></span></div>
                    <div class="col-6"><span class="editOrder delete" data-item='{{$order->name}}' data-platform='{{$order->platform}}' data-toggle="tooltip" data-bs-placement="top" title="Edit price of order"><i class="icon icon-cancel"></i></span></div>
                </div>
            </div>
        @endforeach
    @else
        You don't follow any items on Warframe.market
    @endif
</div>

@endsection