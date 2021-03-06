<nav class="nav col-12" id="mainNav">
    <div class="logo col-3">
        <a href="{{url('/')}}"><h2>WarframeBot</h1></a>
    </div>
    <div class="col-4 search">
        <form class="form-search col-12" method="get" id="searchItems">
            @csrf
            <input list="itemsList" type="text" value="{{$itemName ?? ''}}" class="col-12 itemNameinput" placeholder="Search for desired item">
        </form>
    </div>
    <div class="col-5 menu-items">
        <div class="col-4" data-toggle="tooltip" data-bs-placement="bottom" title="Add new item to follow prices"><button class="btn btn-outline-primary col-12" id="addFollow">Follow new</button></div>
        <div class="col-4"><a href="{{url('watched')}}"><button class="btn btn-outline-primary col-12">Show current</button></a></div>
        <div class="col-4"><a href="{{url('account')}}"><button class="btn btn-outline-primary col-12">Account <span class="notificationCounter ringAnimated"></span></button></a></div>
    </div>
</nav>
