import * as Assets from './assets.js';
import {itemMap} from "./itemFetcher";

$(document).on('click', '#selectItemForm', function() {
    $('#itemForm').show(0);
    $('#itemOrRivenSelector').hide(0);
})

$(document).on('click', '#selectRivenForm', function() {
    $('#rivenForm').show(0);
    $('#itemOrRivenSelector').hide(0);
})

/**
 * make ajax call
 */
$(document).on('submit', '#formFollow', function(e) {
    e.preventDefault();

    let form = $(this),
        item = form.find('#itemNameinput').val(),
        price = form.find('#itemPrice').val(),
        platformid = form.find('#platformChangeUser').val(),
        type = Assets.getItemType(item)
    ;
console.log(itemMap[item], itemMap, item);
    $.ajax({
        url: '/item/add',
        type: "POST",
        data: {
            'name': itemMap[item],
            'price': price,
            'platformId': platformid,
            'type': type
        },
        error: function(message) {
            Assets.forceCloseModal(form)
            Assets.showAlert(
                'error',
                message.responseJSON.message,
                'Error'
            );
            form.show(200);

            Assets.refreshContainerContent('/item/watched', 'watched');

            return false;
        },
        success: function(message) {
            Assets.forceCloseModal(form)
            Assets.showAlert(
                'success',
                message.message,
                'Added item'
            );
            form.show(200);
            Assets.refreshContainerContent('/item/watched', 'watched');

            return true;
        }
    })
});
