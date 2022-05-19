import Echo from "laravel-echo";
import * as Assets from './assets.js';
window.Pusher = require('pusher-js');
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// enable loggin for debugging
// Pusher.logToConsole = true;

// current user logged in system. It defines channel based on username
// and event is sendNotification
var currentLoggedPusherUser = document.querySelector("#currentLoggedPusherUser").value;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '5f9f72827b50205b5550',
    cluster: 'eu',
    forceTLS: true
});

window.Echo.channel(currentLoggedPusherUser)
    .listen(".NotifyUser", (e) => {
        Assets.showNotification();
    })


// var pusher = new Pusher('5f9f72827b50205b5550', {
//     cluster: 'eu'
// });

// var channel = pusher.subscribe(currentLoggedPusherUser);
// channel.bind('NotifyUser', function(data) {
//     alert(JSON.stringify(data));
// });
