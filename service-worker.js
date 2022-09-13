importScripts(
  'https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js'
);

workbox.routing.registerRoute(
    ({request}) => request.Destination === 'image',
    new workbox.strategies.NetworkFirst()
);

// <script>
//
//     if ('serviceWorker' in navigator) {
//
//       navigator.serviceWorker.register('/sw.js')
//
//     }
//
//     </script>
