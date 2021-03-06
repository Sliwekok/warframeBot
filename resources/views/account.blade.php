@extends('layouts.app')

@section('content')

    <div class="col-8 offset-2" id="wrapper">
        <div class="col-7" id="notifications">
            @if(count($notifications) > 0)
                    
                <div class="col-12">
                    <p><h2>Notifications</h2></p>
                </div>
                @include('layouts.notifications')

            @else
                <h1>No notifications about your items</h1>
            @endif
        </div>
        <div class="col-4 offset-1" id="account">
            <div class="col-12" id="selectPlatform">
                <p><label for="platform">Change default platform for items</label></p>
                <select class="platform" id="platformChangeUser">
                    <option value="PC" @if($platform == "pc") selected @endif>PC</option>
                    <option value="XBOX" @if($platform == "xbox") selected @endif>XBOX</option>
                    <option value="PS4" @if($platform == "ps4") selected @endif>PS4</option>
                    <option value="Switch" @if($platform == "switch") selected @endif>Switch</option>
                </select>
            </div>
            <div class="col-12">
                <p>You're currently logged as {{$user}}</p>
                <a href={{url('logout')}}><button class="btn btn-danger">logout</button></a>
            </div>
        </div>
        
    </div>

@endsection
