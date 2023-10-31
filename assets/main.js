import * as Assets from './assets.js';
// on click on div addFollow on nav.blade show modal with form
$(document).on("click", "#addFollow", function(){
    var div = $('#follow');
    Assets.showModal(div);
});

// change user deafult platform 
$(document).on("change", "#platformChangeGlobalUser", function(){
    var selectedPlatform = $(this).val();
    $.ajax({
        url: "/user/change_platform",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'post',
        data: {platformId: selectedPlatform},
        error: function(message) {
            Assets.showAlert(
                'error',
                message.responseJSON.message
            );

            return false;
        },
        success: function(message) {
            Assets.showAlert(
                'success',
                message.message,
                'Changed platform'
            );

            return true;
        }
    });
})

// on submiting main nav search query replace page
// change to refresh content on watchlist
$(document).on("submit", "#searchItems", function(e){
    e.preventDefault();
    var search = $(this).find(".itemNameinput").val();
    location.replace('/item/search_market/'+search);
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
