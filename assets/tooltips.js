let createdTooltips = [];

$(document).on("mouseover", ".tooltipButton", function(){
    let title = $(this).data('title'),
        divId = `tooltipButton_${$(this).attr('id')}`
    ;

    if (!createdTooltips.includes(divId)) {
        let positionFixed = getPositionFixed($(this));
        createTooltip(divId, title, positionFixed);
        createdTooltips.push(divId)
    }

});

$(document).on("mouseleave", ".tooltipButton", function(){
    let divId = `tooltipButton_${$(this).attr('id')}`;

    if (createdTooltips.includes(divId)) {
        hide(divId);
    }
});

function createTooltip(divId, title, position){
    $('<div>', {
        id: divId,
        class: "tooltipBox",
    })
        .html(
        `<span>${title}</span>`
    )
        .appendTo("body")
        .fadeIn(250)
        .css({
            "top": position.top,
            "left": position.left
        })
    ;
}

function getPositionFixed(clickedElement) {
    let positionElement = clickedElement.offset(),
        placement = clickedElement.data('tooltip-placement'),
        elementWidth = clickedElement.innerWidth(),
        elementHeight = clickedElement.innerHeight(),
        positionFixed = {}
    ;

    switch (placement) {
        case "top":
            console.log('top');
            positionFixed = {
                top: positionElement.top - (elementHeight * 2) - 15,
                left: positionElement.left
            }
            break;
        case "bottom":
            console.log('bottom');
            positionFixed = {
                top: positionElement.top + elementHeight + 15,
                left: positionElement.left
            }
            break;
        case "right":
            console.log('right');
            positionFixed = {
                top: positionElement.top,
                left: positionElement.left + elementWidth + 15
            }
            break;
        case "left":
            console.log('left');
            positionFixed = {
                top: positionElement.top,
                left: positionElement.left - elementWidth - 15
            }
            break;
        default:
            console.log('def');
            positionFixed = {
                top: positionElement.top,
                left: positionElement.left
            }
            break;
    }

    return positionFixed;
}

function hide(div) {
    $('#'+div).fadeOut(250);

    setTimeout(function(){
        $('#'+div).remove();
    }, 250);

    createdTooltips.splice(createdTooltips.indexOf(div), 1);
}