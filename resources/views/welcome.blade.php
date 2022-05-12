@extends('layouts.app')

@section('content')
<div class="title">
    <p>
        <h2>A <a class="special" href="https://warframe.market">Warframe.market</a> live tracker</h2> 
        <p>That allows you to follow item prices with notifications</p>
        
        <p>
            <span>To begin with just</span>
            <a href="{{url('register')}}"><button class="btn btn-primary">Sign up</button></a>
            or 
            <a href="{{url('login')}}"><button class="btn btn-secondary">Sign in</button></a>
        </p>
    </p>
</div>
        
@endsection
