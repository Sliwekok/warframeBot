$(document).on('click', '.deleteNotificaion', function(){
    const   text = "Are you sure you want to delete notification?",
            div = $(this).closest('.notification');
    // if confirmed delete - send ajax request
    if(confirm(text) == true){
        var notifId = $(this).data('notification-id');
        $.ajax({
            url: "/deleteNotification/" + notifId,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function(data){
                div.fadeOut(50).delay(50).remove();
                // hide bugged toolitp
                $('[data-toggle="tooltip"]').tooltip('hide');
                // decrease the counter of watched items
                return true;
            }
        });
    }
    else{
        return;
    }
})