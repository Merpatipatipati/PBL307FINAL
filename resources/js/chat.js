import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-app-key',
    cluster: 'your-app-cluster',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false, // Atur menjadi true jika Anda menggunakan HTTPS
    disableStats: true
});

echo.channel('chat.1')
    .listen('MessageSent', (event) => {
        console.log(event);
    });
