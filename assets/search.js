import {reloadTooltipValue} from "./tooltips";
$(document).on('click', '.copyTextToClipboard', function () {
    // change tooltip
    const newValue = 'Copied!';
    $(this).attr('data-title', newValue);
    reloadTooltipValue($(this).attr('id'), newValue);
    // show input and copy text to paste in game
    let item = $(this).parents('.itemRow'),
        sellerDiv = item.find('.dmSellerInput'),
        sellerInput = sellerDiv.find('input')
    ;
    sellerDiv.show(0);
    sellerInput
        .select()
    ;
    navigator.clipboard.writeText(sellerInput.val());
})
