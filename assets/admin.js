$(document).on("change", '#version', async function () {
    let version = this.value;

    if (await showAlert(
        "warning",
        "Are you sure you want to update server version control? This will lead to server maintenance and may cause problems!",
        "Change version?",
        true
    )) {
        $.ajax({
            url: "",
            method: 'get',
            data: {
                'version': version,
            },
            error: function(message) {
                showAlert(
                    'danger',
                    "Unknown error occurred",
                    'Oops! Something went wrong. ' + message
                );

                return false;
            },

            success: function(message) {
                showAlert(
                    'success',
                    message,
                    'Success'
                );
                return true;
            }
        });

    }
});
