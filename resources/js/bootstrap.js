    window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}

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

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// var channel = Echo.channel('send-chat');
// channel.listen('TaskAdded', function(data) {
//   alert(JSON.stringify(data));
// });

window.Echo.channel('send-chat')
            .listen('TaskAdded',function(data){
                let send_user = document.getElementById('send_id').value;
                console.log('received a message');
                console.log(data['chats']);
                if(data['chats']['send_user'] == send_user){
                    let add_chat = "<div class='send' style='text-align: right'><p>" + data['chats']['contents'] + "</p></div>";
                    $('#room').append(add_chat);
                }else{
                    let add_chat = "<div class='receive' style='text-align: left'><p>" + data['chats']['contents'] + "</p></div>";
                    $('#room').append(add_chat);
                }
            });
