@extends('layouts.app')

@section('content')

    @if(count($watched) > 0)
        <div class="col-12" id="watched">
            <div class="col-12 mainText"><h3>You're watching {{count($watched)}} @if(count($watched) == 1) item @else items @endif</h3></div>
            @foreach($watched as $order)

            @endforeach
        </div>
    @else
        You don't follow any items on Warframe.market
    @endif

@endsection