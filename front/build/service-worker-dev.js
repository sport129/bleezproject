// This service worker file is effectively a 'no-op' that will reset any
// previous service worker registered for the same host:port combination.
// In the production build, this file is replaced with an actual service worker
// file that will precache your site's local assets.
// See https://github.com/facebookincubator/create-react-app/issues/2272#issuecomment-302832432

// self.addEventListener('install', () => self.skipWaiting());

self.addEventListener('install', function (event) {
  console.log('SW Installed');
  event.waitUntil(
    caches.open('static')
      .then(function (cache) {
        cache.addAll([
          '/',
          '/index.html',
          '/dist/static/img/logos/main.png',
          '/dist/static/modules/cashAll/images/payment-elo.png',
          '/dist/static/modules/cashAll/images/payment-visa.png',
          '/dist/static/modules/cashAll/images/payment-debit.png',
          '/dist/static/modules/cashAll/images/payment-credit.png',
          '/dist/static/modules/cashAll/images/payment-hipercard.png',
          '/dist/static/modules/cashAll/images/payment-mastercard.png',
          'http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
          'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
          'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons',
        ]);
      })
  );
});

self.addEventListener('activate', function () {
  console.log('SW Activated');
  self.clients.matchAll({ type: 'window' }).then(windowClients => {
    for (let windowClient of windowClients) {
      // Force open pages to refresh, so that they have a chance to load the
      // fresh navigation response from the local dev server.
      windowClient.navigate(windowClient.url);
    }
  });
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(res) {
        if (res) {
          return res;
        } else {
          return fetch(event.request);
        }
      })
  );
});