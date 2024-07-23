import * as Assets from './assets.js';

/**
 * make ajax call to add ITEM to watchlist
 */
$(document).on('submit', '#formFollow', function(e) {
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
        error: function(message) {
            Assets.forceCloseModal(form)
            Assets.showAlert(
                'error',
                message.responseJSON.message
            );
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

function getItemType(item) {
    let datalist = $("#itemsList"),
        options = datalist.find('option[value="'+item+'"]')
    ;

    return options.attr('label');
}

/*
 * riven section
 */

$("#selectItemForm, #selectRivenForm").on("click", document, function () {
    let selectedForm = $(this);
    if (selectedForm.attr('id') === 'selectItemForm') {
        $("#itemForm").show();
    } else {
        $("#rivenForm").show();
    }

    $("#itemOrRivenSelector")

        .hide(0)
        .children().hide(0);

    return;
})

/**
 * make ajax call to add RIVEN to watchlist
 */

$(document).on('submit', '#rivenForm', function(e) {
    e.preventDefault();

    let form = $(this),
        item = form.find('#rivenWeaponName').val(),
        price = form.find('#rivenPrice').val(),
        attributes = {
            'attrPositive1': form.find('#rivenAttrPositive1').val(),
            'attrPositive2': form.find('#rivenAttrPositive2').val(),
            'attrPositive3': form.find('#rivenAttrPositive3').val(),
            'attrNegative': form.find('#rivenAttrNegative').val(),
        }
    ;

    $.ajax({
        url: '/riven/add',
        type: "POST",
        data: {
            'name': item,
            'price': price,
            'attributes': attributes
        },
        error: function(message) {
            Assets.forceCloseModal(form)
            Assets.showAlert(
                'error',
                message.responseJSON.message
            );
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
