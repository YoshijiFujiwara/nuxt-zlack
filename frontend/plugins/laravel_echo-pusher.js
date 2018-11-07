import LaravelEcho from "laravel-echo"

export default ({ app, store, redirect }) => {
  const token = store.getters['auth/token'];

  window.Pusher = require('pusher-js');

  window.Echo = new LaravelEcho({
    authEndpoint: 'http://zlack_backend_1.test/broadcasting/auth',
    broadcaster: 'pusher',
    key: '4d4a8e9e20e8237cf659',
    cluster: 'ap1',
    auth: {
      headers: {
        Authorization: `Bearer ${token}`
      },
    },
  });
}