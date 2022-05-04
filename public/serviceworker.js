var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [

    '/offline',
    '/css/app.css',
    'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
    'https://documentcloud.adobe.com/view-sdk/main.js',
    '/assets/plugins/global/plugins.bundle.css',
    '/assets/css/style.bundle.css',
    '/assets/plugins/custom/datatables/datatables.bundle.css',
    '/js/app.js',
    '/assets/plugins/global/plugins.bundle.js',
    '/assets/js/scripts.bundle.js',
    '/assets/plugins/custom/datatables/datatables.bundle.js',
    '/assets/plugins/custom/tinymce/tinymce.bundle.js',
    '/assets/plugins/custom/fslightbox/fslightbox.bundle.js',

    '/js/custom.js',
    '/js/main.js',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});
