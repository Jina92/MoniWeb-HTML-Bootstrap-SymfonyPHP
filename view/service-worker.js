const CACHE_NAME = 'static-cache-v1';  // if you change this value, then ignore cache and download again. 

const FILES_TO_CACHE = [
    './index.html', 
    './css/styles.css', 
    './js/scripts.js', 
    './img/logo3_48.png', 
    './img/logo3_96.png',
    './img/logo3_192.png',
    './img/logo3_256.png',
    './img/logo3_512.png',
    './img/logo3_smallsize.png'
];

self.addEventListener("install", function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
            console.log("Opened cache - Service Worker");
            return cache.addAll(FILES_TO_CACHE);
        })
    );
});

self.addEventListener("fetch", function(event) {
    event.respondWith(
        fetch(event.request).catch(function() {
            return caches.match(event.request);
        })
    );
});
//Machello changed 
// self.addEventListener("fetch", function(event) {
//     event.respondWith(
//         caches.match(event.request).then(function(response) {
//             if (response) return response;
//             return fetch(event.request);
//         })
//     );
// });
self.addEventListener("activate", function(event) {
    const cacheWhitelist = [];
    cacheWhitelist.push(CACHE_NAME);
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// self.addEventListener('fetch', function(event) {
//     event.respondWith(
//       caches.match(event.request)
//         .then(function(response) {
//           // Cache hit - return response
//           if (response) {
//             return response;
//           }
  
//           return fetch(event.request).then(
//             function(response) {
//               // Check if we received a valid response
//               if(!response || response.status !== 200 || response.type !== 'basic') {
//                 return response;
//               } // IMPORTANT: Clone the response. A response is a stream
//               // and because we want the browser to consume the response
//               // as well as the cache consuming the response, we need
//               // to clone it so we have two streams.
//               var responseToCache = response.clone();
  
//               caches.open(CACHE_NAME)
//                 .then(function(cache) {
//                   cache.put(event.request, responseToCache);
//                 });
  
//               return response;
//             }
//           );
//         })
//       );
//   });
            
