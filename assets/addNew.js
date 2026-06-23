import * as Assets from './assets.js';

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

    $.ajax({
        url: '/item/add',
        type: "POST",
        data: {
            'name': item,
            'price': price,
            'platformId': platformid,
            'type': type
        },
        error: function(message) {
            Assets.forceCloseModal(form)
            Assets.showAlert(
                'error',
                message.responseJSON.message,
                message.statusText
            );
            Assets.refreshContainerContent('/item/watched', 'watched');

            form.show(200);

            return false;
        },
        success: function(message) {
            Assets.forceCloseModal(form)
            Assets.showAlert(
                'success',
                message.message,
                'Added item'
            );
            Assets.refreshContainerContent('/item/watched', 'watched');
            form.show(200);

            return true;
        }
    })
});
