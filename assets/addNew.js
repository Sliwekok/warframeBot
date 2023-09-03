import * as Assets from './assets.js';

/**
 * make ajax call
 */
$(document).on('submit', '#formFollow', function(e){
    e.preventDefault();
    let form = $(this),
        item = form.find('#itemNameinput').val(),
        price = form.find('#itemPrice').val(),
        platformid = form.find('#platformChangeUser').val()
    ;
    $.ajax({
        url: '/item/add',
        type: "POST",
        data: {
            'name': item,
            'price': price,
            'platformId': platformid
        },
        error: function(error){
            Assets.showAlert(
                'error',
                error.message
            );
            return false;
        },
        success: function(message){
            Assets.showAlert(
                'success',
                message.message
            );
            return true;
        }
    })
});