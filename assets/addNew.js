import * as Assets from './assets.js';

/**
 * make ajax call
 */
$(document).on('submit', '#formFollow', function(e){
    e.preventDefault();

    let form = $(this),
        item = form.find('#itemNameinput').val(),
        price = form.find('#itemPrice').val(),
        platformid = form.find('#platformChangeUser').val(),
        type = getItemType(item)
    ;
    $.ajax({
        url: '/item/add',
        type: "POST",
        data: {
            'name': item,
            'price': price,
            'platformId': platformid,
            'type': type
        },
        error: function(message){
            Assets.forceCloseModal($("#formFollow"))
            Assets.showAlert(
                'error',
                message.responseJSON.message
            );

            return false;
        },
        success: function(message){
            Assets.forceCloseModal($("#formFollow"))
            Assets.showAlert(
                'success',
                message.message,
                'Added item'
            );

            return true;
        }
    })
});

function getItemType(item) {
    let datalist = $("#itemsList"),
        options = datalist.find('option[value="'+item+'"]')
    ;

    return options.attr('label');
}