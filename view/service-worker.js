const CACHE_NAME = 'static-cache-v1';  // if you change this value, then ignore cache and download again. 

const FILES_TO_CACHE = [
    './index.html', 
    './css/styles.css', 
    './js/scripts.js', 
    './img/logo3_48.png', 
    './img/logo3_96.png',
    './img/logo3_192.png',
    './img/logo3_smallsize.png'
];

// codelabs 
// self.addEventListener('fetch', (event) => {
//     event.respondWith(caches.open('cache').then((cache) => {
//         return cache.match(event.request).then((response) => {
//             console.log("cache request: " + event.request.url);
//             var fetchPromise = fetch(event.request).then((networkResponse) => {           
//                 // Update the cache...                   
//                 console.log("fetch completed: " + event.request.url, networkResponse);
//                 if (networkResponse) {
//                     console.debug("updated cached page: " + event.request.url, networkResponse);
//                     cache.put(event.request, networkResponse.clone());
//                 }
//                 return networkResponse;
//             }, 
//             event => {   
//                 // Rejected promise - just ignore it, we're offline...  
//                 console.log("Error in fetch()", event);
//                 event.waitUntil(
//                     // Name the *cache* in the caches.open()...
//                     caches.open(CACHE_NAME).then((cache) => { 
//                         // Take a list of URLs, then fetch them from the server and add the response to the cache...
//                         return cache.addAll(FILES_TO_CACHE);
//                     })
//                 );
//             });
//             // Respond from the cache, or the network...
//             return response || fetchPromise;
//         });
//     }));
// });

// self.addEventListener('activate', (event) => {
//     event.waitUntil(
//         caches.keys().then((keyList) => {
//             return Promise.all(keyList.map((key) => {
//                 if (key !== CACHE_NAME) {
//                     console.log("[Service Worker] Removing old cache", key);
//                     return caches.delete(key);
//                 }
//             }));
//         })
//     );
// });
   

// // Always updating i.e latest version available...
// self.addEventListener('install', (event) => {
//     self.skipWaiting();
//     console.log("Latest version installed!");
// });

self.addEventListener("install", function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
            console.log("Opened cache");
            return cache.addAll(FILES_TO_CACHE);
        })
    );
});
self.addEventListener("fetch", function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            if (response) return response;
            return fetch(event.request);
        })
    );
});
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