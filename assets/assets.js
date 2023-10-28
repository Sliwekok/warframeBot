// show alert with return message from server
export function showAlert(status, message, header = 'Error occurred'){
    let className = (status === 'error') ? "danger" : "success";

    $(".alert").addClass('alert-'+className).fadeIn(50);
    $("#alertHeader").text(header);
    $("#alertContent").text(message);
    
    // hide alert by hand, because by default (bootstrap), it's getting deleted
    (() => {
        let div = $(".alert");
        
        function hideMethod(){
            div.fadeOut(100);
            setTimeout(function(){
                div.removeClass("alert-success alert-danger");
            }, 100);
        }
        
        // on click on alert close button
        $(document).on('click', ".btn-close", function(){
            hideMethod();
        });
        
        // after 10sec hide it automatically
        setTimeout(function(){
            hideMethod();
        }, 10000)
        
    })();
}

// add ways to exit modal
// clicking esc, click outside of modal, click on exit button or on cancel button
export function closeModal(container){
    // on click on exit button leave upload form
    $(document).on('click', '.closeButton', function(e){
        e.preventDefault();
        forceCloseModal(container);
    });
    // on clicking esc leave upload form
    document.onkeydown = function(e) {
        e = e || window.event;
        if(e.keyCode == 27){
            forceCloseModal(container);
        }
    }
    // on clicking outside of upload form - exit
    container.mouseup(function(e){
        if(!$(".wrapper").is(e.target) && $(".wrapper").has(e.target).length === 0){
            forceCloseModal(container);
        }
    });
}
// add animation to closing modal
export function forceCloseModal(div){
    // clear data before exiting
    // add index since it's jquery selector
    document.querySelector("#formFollow").reset();
    div.fadeOut(100)
        .parents(".modal").fadeOut(100);
}

// show modal background color and div on call
export function showModal(div){
    // get parent div to show background as in background
    var background = div.parents(".modal");
    background.fadeIn(100);
    // hide other modals and show only 1 specified
    div.fadeIn(100)
        .siblings().hide(0);
    closeModal(div);
    // enable inputs in case they were closed from edit form
    $("#platformChangeUser").prop("disabled", false);
    $("#itemNameinput").prop("disabled", false)
}

// allow copying text in div
$.fn.selectText = function(){
    this.find('input').each(function() {
        if($(this).prev().length == 0 || !$(this).prev().hasClass('p_copy')) { 
            $('<p class="p_copy" style="position: absolute; z-index: -1;"></p>').insertBefore($(this));
        }
        $(this).prev().html($(this).val());
    });
    var element = this[0];
    if (document.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
    } else if (window.getSelection) {
        var selection = window.getSelection();        
        var range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range);
    }
};
// upon webstocket have data - add bell to navbar and add div to account in notification box
export function showNotification(){
    const icon = "<i class='icon icon-bell-alt'></i>";
    $(".notificationCounter").html(icon);
    refreshContainerContent("/account", 'userNotifications');
}

export function refreshContainerContent(url, div){
    $.ajax({
        url: url,
        method: 'get',
        error: function(error){
            console.log("=========");
            console.log(error); 
            return false;
        },

        success: function(){
            $(`#${div}`)
                .html('')
                .load(url+" #"+div);
            return true;
        }
    });
}