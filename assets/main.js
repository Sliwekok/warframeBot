import * as Assets from './assets.js';
// on click on div addFollow on nav.blade show modal with form
$(document).on("click", "#addFollow", function(){
    var div = $('#follow');
    Assets.showModal(div);
});

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
// change to refresh content on watchlist
$(document).on("submit", "#searchItems", function(e){
    e.preventDefault();
    var search = $(this).find(".itemNameinput").val();
    location.replace('/search/'+search);
});

// allow editing item on watchlist
$(document).on("click", "#addNewItem", function(){
    var div = $('#follow');
    Assets.showModal(div);
    $("#itemNameinput").val($(this).data("itemname"));
});
// check if error message is filled
$(document).ready(function() {
    if ($('#errorMessage').length !== 0) {
        Assets.showAlert('error', $('#errorMessage').val())
    }
})
