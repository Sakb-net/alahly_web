<?php

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});
$public_url = ''; //public/
$admin_panel = $public_url . 'admin';
//https://www.alahlifc.sa
// Close
Route::get('close', ['as' => 'close', 'uses' => 'Site\SiteController@close']);
Route::group([
    'prefix' => $public_url,
    'namespace' => 'Site',
        ], function () {
// Pages
    Route::get('home', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::get('/logout', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::get('', ['as' => 'home', 'uses' => 'HomeController@home']);
    Route::get('/payment/mobile/{checkoutId}', ['as' => 'mobile.checkoutId', 'uses' => 'HomeController@mobile']);
    Route::get('about', ['as' => 'about', 'uses' => 'HomeController@about']);
    Route::get('champions', ['as' => 'champions', 'uses' => 'HomeController@champions']);
    Route::get('audience', ['as' => 'audience', 'uses' => 'HomeController@audience']);
    Route::get('game', ['as' => 'game', 'uses' => 'HomeController@game']);
    Route::get('calendar', ['as' => 'calendar', 'uses' => 'HomeController@calendar']);
    Route::get('contact', ['as' => 'contact', 'uses' => 'HomeController@contact']);
    Route::post('contact', ['as' => 'contact.store', 'uses' => 'HomeController@contactStore']);
});

// categories product
Route::group([
    'prefix' => 'categories' . $public_url,
    'as' => 'categories.',
        ], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Site\ProductController@index']);
    Route::get('/{cat_link}/products', ['as' => 'category.single', 'uses' => 'Site\ProductController@categorySingle']);
    Route::get('/{cat_link}/products/{link}', ['as' => 'category.products.single', 'uses' => 'Site\ProductController@productSingle']);
});
// cart product
Route::group([
    'prefix' => 'products' . $public_url,
    'as' => 'products.',
        ], function () {
    Route::get('/cart', ['as' => 'cart', 'uses' => 'Site\ProductController@cartProduct']);
    Route::get('/checkout', ['as' => 'checkout', 'uses' => 'Site\ProductController@checkoutProduct']);
    Route::get('/payment/callback', ['as' => 'payment.callback', 'uses' => 'Site\ProductController@paymentcallback']);
});

// team
Route::group([
    'prefix' => 'teams' . $public_url,
    'as' => 'teams.',
        ], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Site\TeamController@index']);
    Route::get('/{cat_link}/team', ['as' => 'teams.single', 'uses' => 'Site\TeamController@TeamSingle']);
    Route::get('/{cat_link}/team/{link}', ['as' => 'teams.team.single', 'uses' => 'Site\TeamController@SubteamSingle']);
    Route::get('/user/{link}', ['as' => 'user.single', 'uses' => 'Site\TeamController@UserteamSingle']);
});
// matches
Route::group([
    'prefix' => 'matches' . $public_url,
    'as' => 'matches.',
        ], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Site\MatchController@index']);
    Route::get('/next', ['as' => 'next', 'uses' => 'Site\MatchController@nextMatch']);
    Route::get('/previous', ['as' => 'previous', 'uses' => 'Site\MatchController@previousMatch']);
    Route::get('/match/{link}', ['as' => 'match.single', 'uses' => 'Site\MatchController@single']);
});
// videos
Route::group([
    'prefix' => 'videos' . $public_url,
    'as' => 'videos.',
        ], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Site\VideosController@index']);
    Route::get('/{link}', ['as' => 'single', 'uses' => 'Site\VideosController@single']);
});
// gallery
Route::group([
    'prefix' => 'gallery' . $public_url,
    'as' => 'gallery.',
        ], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Site\GalleryController@index']);
    Route::get('/{link}', ['as' => 'single', 'uses' => 'Site\GalleryController@single']);
});
// news
Route::group([
    'prefix' => 'news' . $public_url,
    'as' => 'news.',
        ], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Site\NewsController@index']);
    Route::get('/{link}', ['as' => 'single', 'uses' => 'Site\NewsController@single']);
    Route::get('/league/table', ['as' => 'league', 'uses' => 'Site\NewsController@league']);
});
// master
Route::group([
    'prefix' => 'tickets' . $public_url,
    'as' => 'tickets.',
    'middleware' => ['auth']
        ], function () {
//    Route::get('', ['as' => 'index', 'uses' => 'Site\TicketController@index']);
    Route::get('/match/{match_link}', ['as' => 'index.match', 'uses' => 'Site\TicketController@index_match']);
    Route::get('/payment', ['as' => 'payment.match', 'uses' => 'Site\TicketController@checkoutTicket']);
    Route::get('/callback', ['as' => 'callback.match', 'uses' => 'Site\TicketController@paymentcallback']);
});
// Profile
Route::group([
    'prefix' => 'profile' . $public_url,
    'as' => 'profile.',
    'middleware' => ['auth']
        ], function () {
    Route::get('', ['as' => 'index', 'uses' => 'Site\ProfileController@index']);
    Route::post('', ['as' => 'store', 'uses' => 'Site\ProfileController@store']);
    Route::get('mycart', ['as' => 'mycart', 'uses' => 'Site\ProfileController@mycart']);
    Route::get('myticket', ['as' => 'myticket', 'uses' => 'Site\ProfileController@myticket']);
});

//ajax
if (Request::ajax()) {
    require __DIR__ . '/ajax_site.php';
}
Auth::routes();

// Auth Admin
Route::get($admin_panel . '/login', ['as' => 'admin.login', 'uses' => 'Auth\LoginAdminController@showLoginForm']);
Route::post($admin_panel . '/login', ['uses' => 'Auth\LoginAdminController@login']);
Route::post($admin_panel . 'logout', ['as' => 'admin.logout', 'uses' => 'Auth\LoginAdminController@logout']);

Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

//Admin
require __DIR__ . '/admin.php';
