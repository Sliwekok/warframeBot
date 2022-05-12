@extends('layouts.app')

@section('content')

    <div class="col-8" id="account">
        <div class="col-3">
            <a href={{url('logout')}}><button class="btn btn-danger">logout</button></a>
        </div>
        <div class="col-4" id="selectPlatform">
            <label for="platform">Change default platform for items</label>
            <select class="platform" id="platformChangeUser">
                <option value="PC" @if($platform == "pc") selected @endif>PC</option>
                <option value="XBOX" @if($platform == "xbox") selected @endif>XBOX</option>
                <option value="PS" @if($platform == "ps") selected @endif>PS</option>
                <option value="Switch" @if($platform == "switch") selected @endif>Switch</option>
            </select>
        </div>
    </div>

@endsection
