<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */
Route::group([
    'namespace' => 'Api\V1',
//        'prefix' => 'v1'
        ], function () {
// Page
    Route::name('version')->post('v1/version', 'PageController@version');
    Route::name('home')->post('v1/home', 'PageController@home');
    Route::name('about')->post('v1/about', 'PageController@about');
    Route::name('terms')->post('v1/terms', 'PageController@terms');
    Route::name('contact_us')->post('v1/contact_us', 'PageController@contact_us');
    Route::name('add_contact_us')->post('v1/add_contact_us', 'PageController@add_contact_us');
    Route::name('champions')->post('v1/champions', 'PageController@champions');
    Route::name('audience')->post('v1/audience', 'PageController@audience');
    Route::name('calendar')->post('v1/calendar', 'PageController@calendar');
// login and register
    Route::name('get_country')->post('v1/get_country', 'AuthController@get_country');
    Route::name('get_city')->post('v1/get_city', 'AuthController@get_city');
    Route::name('register')->post('v1/register', 'AuthController@register');
    Route::name('login.email')->post('v1/login/email', 'AuthController@loginEmail');
    Route::name('logout')->post('v1/logout', 'AuthController@logout');

    //Route::name('login.social')->post('v1/login/social', 'AuthController@loginSocial');
//    Route::name('forgetpassword')->post('v1/forgetpassword', 'AuthController@forgetpassword');
//   
//    // user Rest Password
//    Route::name('create')->post('v1/password/create', 'PasswordResetController@create');
//    Route::name('find')->post('v1/password/find/{token}', 'PasswordResetController@find');
//    Route::name('reset')->post('v1/password/reset', 'PasswordResetController@reset');
// user
    Route::name('profile')->get('v1/profile', 'UserController@profile');
    Route::name('change_password')->post('v1/change_password', 'UserController@change_password');
    Route::name('update_profile')->post('v1/update_profile', 'UserController@update_profile');
    Route::name('update_fcmtoken')->post('v1/update_fcmtoken', 'UserController@update_fcmtoken');
    Route::name('mybill')->post('v1/mybill', 'UserController@mybill');

// master
    Route::name('master_sections')->get('v1/master_sections', 'MasterController@master_sections');
    Route::name('section_seat')->post('v1/section_seat', 'MasterController@section_seat');

// product & categoryProduct
    Route::name('product_categories')->post('v1/product_categories', 'ProductController@product_categories');
//Route::name('subcategories')->post('v1/subcategories', 'ProductController@subcategories');
    Route::name('product_category')->post('v1/product_category', 'ProductController@product_category');
    Route::name('products')->post('v1/products', 'ProductController@products');
    Route::name('products_single')->post('v1/products/single', 'ProductController@productsSingle');
    Route::name('product_cart')->post('v1/product_cart', 'ProductController@product_cart');
    Route::name('product_addupdate_cart')->post('v1/product/addupdate_cart', 'ProductController@product_addupdate_cart');
    Route::name('product_delete_cart')->post('v1/product/delete_cart', 'ProductController@product_delete_cart');
    Route::name('checkoutProduct')->post('v1/product/checkout', 'ProductController@checkoutProduct');
    Route::name('paymentcallback')->get('v1/product/paymentcallback', 'ProductController@paymentcallback');
    Route::name('resultcallback')->post('v1/product/resultcallback', 'ProductController@resultcallback');
//payment from hyper
    Route::name('payment')->post('v1/payment', 'PaymentController@payment');
    Route::name('confirmPayment')->post('v1/confirmPayment', 'PaymentController@confirmPayment');

//comment
//    Route::name('allcomments')->post('v1/allcomments', 'CommentController@allcomments');
    Route::name('comments')->post('v1/comments', 'CommentController@comments');
    Route::name('add_comment')->post('v1/add_comment', 'CommentController@add_comment');
    Route::name('update_comment')->post('v1/update_comment', 'CommentController@update_comment');
    Route::name('delete_comment')->post('v1/delete_comment', 'CommentController@delete_comment');
//action    
    Route::name('add_watch')->post('v1/add_watch', 'ActionController@add_watch');
    Route::name('add_del_like')->post('v1/add_del_like', 'ActionController@add_del_like');
//notifications    
    Route::name('search')->post('v1/search', 'Notif_SearchController@search');
    Route::name('notifications')->get('v1/notifications', 'Notif_SearchController@notifications');
    Route::name('update_notif')->post('v1/update_notif', 'Notif_SearchController@update_notif');
//Route::name('addSubscribe')->post('v1/addSubscribe', 'Notif_SearchController@addSubscribe');
//attachment
    Route::name('uploadImage')->post('v1/uploadImage', 'AttachmentController@uploadImage');
    Route::name('uploadImageFile')->post('v1/uploadImageFile', 'AttachmentController@uploadImageFile');
    Route::name('uploadVideo')->post('v1/uploadVideo', 'AttachmentController@uploadVideo');
    Route::name('uploadAudio')->post('v1/uploadAudio', 'AttachmentController@uploadAudio');
    Route::name('uploadAudioFile')->post('v1/uploadAudioFile', 'AttachmentController@uploadAudioFile');

// teams
    Route::name('teams')->post('v1/teams', 'TeamController@teams');
    Route::name('subteams')->post('v1/subteams', 'TeamController@subteams');
    Route::name('team.player')->post('v1/team/player', 'TeamController@teamplayer');
// news
    Route::name('news')->post('v1/news', 'NewsController@news');
    Route::name('news.single')->post('v1/news/single', 'NewsController@newsSingle');
// videos
    Route::name('videos')->post('v1/videos', 'VideosController@videos');
    Route::name('videos.single')->post('v1/videos/single', 'VideosController@videosSingle');
// albums
    Route::name('albums')->post('v1/albums', 'GalleryController@albums');
    Route::name('albums.single')->post('v1/albums/single', 'GalleryController@albumsSingle');
// matches
    Route::name('matches')->post('v1/matches', 'MatchController@matches');
    Route::name('matches.single')->post('v1/matches/single', 'MatchController@matchesSingle');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
