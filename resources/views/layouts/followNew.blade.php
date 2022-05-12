<div class="modal">
    <div id="background">
        <div class="row">
            <div class="col-6 offset-3 container wrapper" id="follow">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12 modalBody">
                            <div class="row">
                                <div class="col-12 title">
                                    <div class="col-11"><p>Search up for item</p></div>
                                    <div class="col-1 closeButton smallExit" title="Close form"><i class="icon icon-cancel"></i></div>
                                </div>
                            </div>
                            <div class="row col-12" id="content">
                                <div class="col-12">
                                    <form action="{{url('add')}}" method="post" id="formFollow" class="col-12" autocomplete="off">
                                        @csrf
                                        <div class="form-group col-8">
                                            <span><label for="itemNameinput">Search for item part</label></span><br>
                                            <input list="itemsList" class="col-12 itemNameinput" name="name" placeholder="Search...">
                                        </div>
                                        <div class="form-group col-3 offset-1">
                                            <span><label for="itemPrice">Price</label></span><br>
                                            <input type="number" name="price" placeholder="10" id="itemPrice">
                                        </div>
                                        <div class="form-group col-3 offset-1">
                                            <select class="platform" id="platformChangeUser" name="platform">
                                                <option value="PC" @if($platform == "pc") selected @endif>PC</option>
                                                <option value="XBOX" @if($platform == "xbox") selected @endif>XBOX</option>
                                                <option value="PS" @if($platform == "ps") selected @endif>PS</option>
                                                <option value="Switch" @if($platform == "switch") selected @endif>Switch</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12" id="buttons">
                                    <div class="col-4">
                                        <button class="btn btn-outline-secondary closeButton" title="Close uploader">Cancel</button>
                                    </div>
                                    <div class="col-2 offset-6">
                                        <button type="submit" class="btn btn-outline-primary submit" title="Rename file">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>