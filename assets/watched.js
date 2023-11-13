import * as Assets from './assets.js';
// on delete from watched click show confirmation
$(document).on('click', '.deleteWatched', function(){
    const   text = "Are you sure you want to delete item from you watchlist?";
    // if confirmed delete - send ajax request
    if(confirm(text) === true){
        var id = $(this).data('id');
        $.ajax({
            url: "delete",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'delete',
            data: {
                id: id
            },
            error: function(message){
                Assets.showAlert(
                    'error',
                    message.responseJSON.message
                );
                return false;
            },
            success: function(message){
                Assets.showAlert(
                    'success',
                    message.message,
                    'Item has been deleted');
                Assets.refreshContainerContent('/item/watched', 'watched');

                return true;
            }
        });
    }
})
$(document).on('click', '.edit', function(){
    var item = $(this).data('item'),
        price = $(this).data('price'), 
        platform = $(this).data('platform');
    Assets.showModal($("#follow"));
    // edit follow div data and disable some inputs
    $("#itemNameinput").val(item).prop("disabled", true);   
    $("#itemPrice").val(price);   
    $("#platformChangeUser").val(platform).prop("disabled", true);
    // change url of form to send req to the right url
    // also enable buttons to send all data to server
    $("#formFollow").attr('action', 'update')
        .on("submit", function(){
            $("#platformChangeUser").prop("disabled", false);
            $("#itemNameinput").prop("disabled", false)
        });
    
})