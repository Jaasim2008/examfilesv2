const browsersync = require('browser-sync').create();

browsersync.init({
    proxy: '127.0.0.1:8000', // the URL of your Laravel php artisan serve server
    files: [
        'app/**/*.php',
        'resources/views/**/*.blade.php',
        'public/js/**/*.js',
        'public/css/**/*.css',
    ],
    open: false,
    notify: false,
    reloadDelay: 100, // wait 100ms before reload to avoid race condition
});
