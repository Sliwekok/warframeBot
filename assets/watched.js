import * as Assets from './assets.js';
// on delete from watched click show confirmation
$(document).on('click', '.deleteWatched', function(){
    const   text = "Are you sure you want to delete item from you watchlist?",
            div = $(this).closest('.orderPanel');
    // if confirmed delete - send ajax request
    if(confirm(text) == true){
        var item = $(this).data('item'),
            platform = $(this).data('platform');
        $.ajax({
            url: "delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            data: {
                platform: platform,
                item: item    
            },
            error: function(error){
                console.log(error);
                Assets.showAlert(error);
                return false;
            },
            success: function(data){
                // if platform is not the same as it was - skip alert
                if(data !== 0){
                    Assets.showAlert(data);
                    div.fadeOut(50).delay(50).remove();
                    // hide bugged toolitp
                    $('[data-toggle="tooltip"]').tooltip('hide');
                    // decrease the counter of watched items
                    var current = $("#countWatchedItems").text();
                    $("#countWatchedItems").text(parseInt(current)-1);
                    return true;
                }
                else return true;
            }
        });
    }
    else{
        return;
    }
})
$(document).on('click', '.edit', function(){
    var item = $(this).data('item'),
        price = $(this).data('price'), 
        platform = $(this).data('platform');
    Assets.showModal($("#follow"));
    // hide tooltip that is generated on hover on button element
    $('[data-toggle="tooltip"]').tooltip('hide');
    // edit follow div data and disable some inputs
    $("#itemNameinput").val(item).prop("disabled", true);   
    $("#itemPrice").val(price);   
    $("#platformChangeUser").val(platform).prop("disabled", true);
    //change url of form to send req to the right url
    // also enable buttons to send all data to server
    $("#formFollow").attr('action', 'update')
        .on("submit", function(){
            $("#platformChangeUser").prop("disabled", false);
            $("#itemNameinput").prop("disabled", false)
        });
    
})