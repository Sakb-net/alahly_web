<?php

Route::post($public_url . 'add_register_buy', ['as' => 'add_register_buy', 'uses' => 'Auth\RegisterController@ajax_add_register_buy']);

Route::group([
    'prefix' => $public_url,
    'namespace' => 'Site',
        ], function () {
//page---->validation register
    Route::post('changeLanguage', ['as' => 'changeLanguage', 'uses' => 'AjaxController@changeLanguage']);
    Route::post('currency_course', ['as' => 'currency_course', 'uses' => 'AjaxController@currency_course']);
    Route::post('check_found_email', ['as' => 'check_found_email', 'uses' => 'AjaxController@check_found_email']);
    Route::post('check_found_phone', ['as' => 'check_found_phone', 'uses' => 'AjaxController@check_found_phone']);
    Route::post('add_image_user', ['as' => 'add_image_user', 'uses' => 'AjaxController@add_image_user']);
    //champions
    Route::post('select_sport', ['as' => 'select_sport', 'uses' => 'AjaxController@select_sport']);
    Route::post('search_champions', ['as' => 'search_champions', 'uses' => 'AjaxController@search_champions']);
//category & Ticket
    Route::post('get_section_modal', ['as' => 'get_section_modal', 'uses' => 'AjaxTicket@get_section_modal']);
    Route::post('tzaker_chair', ['as' => 'tzaker_chair', 'uses' => 'AjaxTicket@tzaker_chair']);
    Route::post('remove_cart_chair', ['as' => 'remove_cart_chair', 'uses' => 'AjaxTicket@remove_cart_chair']);
//comment
    Route::post('add_delete_fav', ['as' => 'add_delete_fav', 'uses' => 'AjaxCommentController@add_delete_fav']);
    Route::post('add_post_comment', ['as' => 'add_post_comment', 'uses' => 'AjaxCommentController@add_post_comment']);
    Route::post('remove_comments', ['as' => 'remove_comments', 'uses' => 'AjaxCommentController@remove_comments']);
    //Product
    Route::post('get_categoriesProduct', ['as' => 'get_categoriesProduct', 'uses' => 'AjaxProduct@get_categoriesProduct']);
    Route::post('sort_cat_Product', ['as' => 'sort_cat_Product', 'uses' => 'AjaxProduct@sort_cat_Product']);
    Route::post('select_weight_fees_Product', ['as' => 'select_weight_fees_Product', 'uses' => 'AjaxProduct@select_weight_fees_Product']);
    Route::post('add_cart_product', ['as' => 'add_cart_product', 'uses' => 'AjaxProduct@add_cart_product']);
    Route::post('add_cart_productDetails', ['as' => 'add_cart_productDetails', 'uses' => 'AjaxProduct@add_cart_productDetails']);
    Route::post('changnum_cartProduct', ['as' => 'changnum_cartProduct', 'uses' => 'AjaxProduct@changnum_cartProduct']);
    Route::post('remove_cartProduct', ['as' => 'remove_cartProduct', 'uses' => 'AjaxProduct@remove_cartProduct']);
    //contact us
    Route::post('add_contact_Us', ['as' => 'add_contact_Us', 'uses' => 'AjaxController@add_contact_Us']);
});
