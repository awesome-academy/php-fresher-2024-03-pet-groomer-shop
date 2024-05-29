const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js(
    [
        "resources/js/app.js",
        "resources/js/translate.js",
        "resources/js/user.js",
        "resources/js/pet.js",
        "resources/js/coupon.js",
        "resources/js/pet-service.js",
        "resources/js/pet-service-price.js",
        "resources/js/breed.js",
        "resources/js/care-order.js",
        "resources/js/payment.js",
        "resources/js/branch.js",
        'resources/js/care-order-history.js',
        'resources/js/image.js',
        "resources/js/notification.js",
        "node_modules/pusher-js/dist/web/pusher.min.js",
        "node_modules/pusher-js/dist/web/pusher.js",
    ],
    "public/js/app.js"
)
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .postCss("node_modules/toastr/build/toastr.min.css", "public/css")
    .sass("resources/css/confirm-page.scss", "public/css");

mix.disableNotifications();
