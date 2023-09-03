import * as Assets from './assets.js';
// on click on div addFollow on nav.blade show modal with form
$(document).on("click", "#addFollow", function(){
    var div = $('#follow');
    Assets.showModal(div);
    // hide tooltip that is generated on hover on button element
    $('[data-toggle="tooltip"]').tooltip('hide');
});

// show suggestions to search results
(() => {
    $(".itemNameinput").on("keyup", function(){
        searchTrigger($(this).val());
    });

    function searchTrigger(query){
        var datalist = $("#itemsList"),
            maxItems = 5; // max number of suggestions
        // delete all suggestions
        datalist.html('');
        
        // check if query is not empty
        if(query.length == 0) return;
        
        // call all 3 API methods to fill datalist, priority is: warframe, weapon, mod, item
        // api below is nod required since mods are already in items     
        // "https://api.warframestat.us/mods/search/" 
        FetchData("https://api.warframestat.us/warframes/search/");
        FetchData("https://api.warframestat.us/weapons/search/");
        FetchData("https://api.warframestat.us/items/search/");
        /**
         *  Fetch data with data from api server given in parameter
         *  It need to fetch it from 3 different routes:
         *  ITEMS (items like relics), MODS, WARFRAMES (prime warframes parts), WEAPONS
         */
        async function FetchData(api){
        // fetch data from api, fetch only items in english
            fetch(api + query, {
                headers:{
                    "Accept-Language": "en",
                },
            })
                .then(res => { return res.json()})
                .then(data => fillTemplate(data));
        }
        

        // append option to datalist
        function appendOption(itemName){
            var option = '<option option="'+itemName+'">'+itemName+'</option>';
            datalist.append(option);
        } 


        // function to check if item exists in datalist
        function itemExists(item){
            // set var to count failures
            var errors = 0;
            // go through each item in datalist 
            datalist.children().each(function(){
                if($(this).val().toLowerCase() == item.toLowerCase()) errors++;
            });
            // if more than 1 error - return true, because item already exists in datalist
            if(errors > 0) return true;
            return false;
        }

        // fill template function with data
        function fillTemplate(data){
            $(data).each(function(){
                // 0 means index with data
                var item = $(this)[0];
                // check if item is tradeble
                if(item['tradable'] === true){
                    // if max items are set, return function
                    if(datalist.children().length >= maxItems) return;
                    // check if item name starts with query
                    if(item['name'].toLowerCase().startsWith(query) === false) return;
                    // check if item already exists in datalist
                    if(itemExists(item['name']) === true) return;

                    appendOption(item['name']);
                }
                // if item has components to build - check them
                else if(item.hasOwnProperty('components')){
                    var isSetAvaible = false;
                    // on each component run build
                    $(item['components']).each(function(){
                        var part = $(this)[0],
                            partName = part['name'],
                            fullname = item['name'] + " " + partName;
                        if(part['tradable'] === false) return;
                        // if max items are set, return function
                        if(datalist.children().length >= maxItems) return;
                        // check if item name starts with query
                        if(fullname.toLowerCase().startsWith(query) === false) return;
                        // check if item already exists in datalist
                        if(itemExists(fullname) === true) return;
                        // check if compontent required is not an empty resource ingame
                        if(partName == "Orokin Cell" || partName == "Nitain Extract") return;

                        isSetAvaible = true;
                        appendOption(fullname);
                    });
                        
                    // add set to allow buying all parts at once
                    if(isSetAvaible) appendOption(item['name'] + " Set");
                }
                // if item is not tradable - skip it
                else return;
            })
        }
    }
})();


// change user deafult platform 
$(document).on("change", "#platformChangeUser", function(){
    var selectedPlatform = $(this).val().toLowerCase();
    $.ajax({
        url: "changePlatform",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        data: {platform: selectedPlatform},
        error: function(error){
            Assets.showAlert(error);
            return false;
        },
        success: function(data){
            // if platform is not the same as it was - skip alert
            if(data !== 0){
                Assets.showAlert(data);
                return true;
            }
            else return true;
        }
    });
})

// on submiting main nav search query replace page 
$(document).on("submit", "#searchItems", function(e){
    e.preventDefault();
    var search = $(this).find(".itemNameinput").val();
    location.replace('/search/'+search);
});


// enable popovers for bootstrap
// also select to copy text to allow paste it to game
$('.showPopover').popover().on("click", function(){ 
    $(".popover-body").selectText();
});

// on click on div addNewItem on wearch.blade show modal with form filled with item name
$(document).on("click", "#addNewItem", function(){
    var div = $('#follow');
    Assets.showModal(div);
    $("#itemNameinput").val($(this).data("itemname"));
});
// check if error message is filled
$(document).ready(function() {
    if ($('#errorMessage').val().length !== 0) {
        Assets.showAlert('error', $('#errorMessage').val())
    }
});
