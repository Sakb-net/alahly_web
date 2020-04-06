<?php

//Admin
Route::group([
    'prefix' => $admin_panel,
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['admin']
        ], function () {

    //Pages
    Route::group([
        'prefix' => 'pages',
        'as' => 'pages.',
            ], function () {

        Route::get('contact', ['as' => 'contact', 'uses' => 'pageController@contact']);
        Route::post('contact', ['as' => 'contact.store', 'uses' => 'pageController@contactStore']);
//        Route::get('contact', ['as' => 'contact', 'uses' => 'optionController@contact']);
//        Route::post('contact', ['as' => 'contact.store', 'uses' => 'optionController@contactStore']);

        Route::get('home', ['as' => 'home', 'uses' => 'pageController@homeOption']);
        Route::post('home', ['as' => 'home.store', 'uses' => 'pageController@homeStore']);

        Route::get('about', ['as' => 'about', 'uses' => 'pageController@about']);
        Route::post('about', ['as' => 'about.store', 'uses' => 'pageController@aboutStore']);

        Route::get('terms', ['as' => 'terms', 'uses' => 'pageController@terms']);
        Route::post('terms', ['as' => 'terms.store', 'uses' => 'pageController@termsStore']);

//        Route::get('payment', ['as' => 'payment', 'uses' => 'pageController@payment']);
//        Route::post('payment', ['as' => 'payment.store', 'uses' => 'pageController@paymentStore']);

        Route::get('goal', ['as' => 'goal', 'uses' => 'pageController@goal']);
        Route::post('goal', ['as' => 'goal.store', 'uses' => 'pageController@goalStore']);

        Route::get('message', ['as' => 'message', 'uses' => 'pageController@message']);
        Route::post('message', ['as' => 'message.store', 'uses' => 'pageController@messageStore']);

//        Route::get('manager', ['as' => 'manager', 'uses' => 'pageController@manager']);
//        Route::post('manager', ['as' => 'manager.store', 'uses' => 'pageController@managerStore']);
    });

    //Statistics
    Route::get('', ['as' => 'index', 'uses' => 'StatisticsReportController@homeAdmin']);
    Route::get('statisticsorders', ['as' => 'statisticsorders', 'uses' => 'StatisticsReportController@statisticsOrders']);
    Route::get('statisticsusers', ['as' => 'statisticsusers', 'uses' => 'StatisticsReportController@statisticsUsers']);
    Route::get('statisticspublic', ['as' => 'statisticspublic', 'uses' => 'StatisticsReportController@statisticsPublic']);

    //Setting
    Route::get('options', ['as' => 'options', 'uses' => 'OptionController@options']);
    Route::post('options', ['as' => 'options.store', 'uses' => 'OptionController@optionsStore']);
    //sendmessage
    Route::get('sendmessage', ['as' => 'sendmessage', 'uses' => 'OptionController@sendMessage']);
    Route::post('sendmessage', ['as' => 'sendmessage.store', 'uses' => 'OptionController@sendMessageStore']);

    //User
    Route::get('users/{id}/type/{name}', ['as' => 'users.posttype', 'uses' => 'UserController@postType']);
    Route::get('users/{id}/comments', ['as' => 'users.comments', 'uses' => 'UserController@comments']);
    Route::get('users/search', ['as' => 'users.search', 'uses' => 'UserController@search']);
    Route::post('userstatus', ['as' => 'userstatus', 'uses' => 'AjaxController@userStatus']);

    //Role && Message
    Route::get('roles/search', ['as' => 'roles.search', 'uses' => 'RoleController@search']);
    Route::get('messages/search', ['as' => 'messages.search', 'uses' => 'MessageController@search']);
//permission
    Route::get('permission/search', ['as' => 'permission.search', 'uses' => 'PermissionController@search']);

    //Comment
    Route::get('comments/search', ['as' => 'comments.search', 'uses' => 'CommentController@search']);
    Route::get('comments/type/{type}', ['as' => 'comments.type', 'uses' => 'CommentController@type']);
    Route::get('comments/{id}/reply', ['as' => 'comments.reply', 'uses' => 'CommentController@reply']);
    Route::post('comments/{id}/reply/store', ['as' => 'comments.reply.store', 'uses' => 'CommentController@replyStore']);
    Route::post('comments/allread', ['as' => 'comments.allread', 'uses' => 'CommentController@allread']);
    //Ajax Comment
    Route::post('commentstatus', ['as' => 'commentstatus', 'uses' => 'AjaxController@commentStatus']);
    Route::post('commentread', ['as' => 'commentread', 'uses' => 'AjaxController@commentRead']);

    //Tag
    Route::get('tags/search', ['as' => 'tags.search', 'uses' => 'TagController@search']);
    Route::get('tags/{id}/type/{type}', ['as' => 'tags.type', 'uses' => 'TagController@type']);

    //Search
    Route::get('searches/search', ['as' => 'searches.search', 'uses' => 'SearchController@search']);
    Route::post('searchstatus', ['as' => 'searchstatus', 'uses' => 'AjaxController@searchStatus']);
    Route::delete('usersearches/{id}/delete', ['as' => 'usersearches.destroy', 'uses' => 'SearchController@destroySearch']);

    //Contact
//    Route::get('contacts/search', ['as' => 'contacts.search', 'uses' => 'ContactController@search']);
    Route::get('contacts/search/{type}', ['as' => 'contacts.search', 'uses' => 'ContactController@search']);
    Route::get('contacts/type/{type}', ['as' => 'contacts.type', 'uses' => 'ContactController@type']);
    Route::post('contactread', ['as' => 'contactread', 'uses' => 'AjaxController@contactRead']);
    Route::post('contactreply', ['as' => 'contactreply', 'uses' => 'AjaxController@contactReply']);

    //Ajax Post
    Route::post('posts/{id}/comments/store', ['as' => 'posts.comments.store', 'uses' => 'PostController@commentStore']);
    Route::post('poststatus', ['as' => 'poststatus', 'uses' => 'AjaxController@postStatus']);
    Route::post('postread', ['as' => 'postread', 'uses' => 'AjaxController@postRead']);
    Route::post('posts/ajax_subcategory', ['as' => 'posts.ajax_subcategory', 'uses' => 'AjaxController@ajaxSubcategory']);
    //Category
    Route::get('categories/type/{type}', ['as' => 'categories.type', 'uses' => 'CategoryController@type']);
    Route::get('categories/search', ['as' => 'categories.search', 'uses' => 'CategoryController@search']);
    Route::post('categorystatus', ['as' => 'categorystatus', 'uses' => 'AjaxController@categoryStatus']);
    //Subcategory
    Route::get('subcategories/search', ['as' => 'subcategories.search', 'uses' => 'SubcategoryController@search']);
    //Category and Subcategory
    Route::get('allcategories/search', ['as' => 'allcategories.search', 'uses' => 'CategoryController@allSearch']);
    //team , Subteam and Userteam 
    Route::get('clubteams/search', ['as' => 'clubteams.search', 'uses' => 'TeamController@search']);
    Route::get('subclubteams/creat/{id}', ['as' => 'subclubteams.creat', 'uses' => 'SubteamController@create']);
    Route::get('subclubteams/search', ['as' => 'subclubteams.search', 'uses' => 'SubteamController@search']);
    Route::get('userclubteams/creat/{id}', ['as' => 'userclubteams.creat', 'uses' => 'UserteamController@create']);
    Route::get('userclubteams/search', ['as' => 'userclubteams.search', 'uses' => 'UserteamController@search']);
    Route::get('allclubteams/search', ['as' => 'allclubteams.search', 'uses' => 'TeamController@allSearch']);
   //champions
    Route::get('champions/search', ['as' => 'champions.search', 'uses' => 'ChampionController@search']);
    Route::post('ajax_get_subteam', ['as' => 'ajax_get_subteam', 'uses' => 'AjaxController@ajax_get_subteam']);
    //calendar
    Route::get('calendar/search', ['as' => 'calendar.search', 'uses' => 'CalendarController@search']);
    //audiences
    Route::get('audiences/search', ['as' => 'audiences.search', 'uses' => 'AudienceController@search']);
    //chart or seat
    Route::get('posts/{id}/comments', ['as' => 'posts.comments.index', 'uses' => 'PostController@comments']);
    Route::get('posts/{id}/comments/create', ['as' => 'posts.comments.create', 'uses' => 'PostController@commentCreate']);
    Route::get('posts/{id}/vidoes', ['as' => 'posts.videos.index', 'uses' => 'VideoController@vidoesCourse']);
    Route::get('posts/{id}/files', ['as' => 'posts.files.index', 'uses' => 'FileController@filesCourse']);
    Route::get('posts/type/{type}', ['as' => 'posts.type', 'uses' => 'PostController@type']);
    Route::get('posts/search/{type}', ['as' => 'posts.search', 'uses' => 'PostController@search']);
    Route::get('posts/create/{type}', ['as' => 'posts.creat', 'uses' => 'PostController@create']);
    Route::get('posts/edit/{id}/{type}', ['as' => 'posts.edittype', 'uses' => 'PostController@edit']);

    Route::get('posts/type/{type}/{cat_id}', ['as' => 'posts.type.category', 'uses' => 'PostController@typeCategory']);
    Route::delete('posts/deletetype/{type}/{cat_id}', ['as' => 'posts.deletetype.category', 'uses' => 'PostController@deletetypeCategory']);
    Route::get('posts/createallpost/{type}', ['as' => 'posts.createallpost', 'uses' => 'PostController@createallpost']);
    Route::post('posts/store_allpost', ['as' => 'posts.store_allpost', 'uses' => 'PostController@store_allpost']);

    //videos
    Route::get('videos/search', ['as' => 'videos.search', 'uses' => 'VideoController@search']);
    Route::get('videos/{id}/comments', ['as' => 'videos.comments.index', 'uses' => 'VideoController@comments']);
    Route::get('videos/{id}/comments/create', ['as' => 'videos.comments.create', 'uses' => 'VideoController@commentCreate']);
    Route::post('videos/{id}/comments/store', ['as' => 'videos.comments.store', 'uses' => 'VideoController@commentStore']);
    Route::post('videos/allread/comments', ['as' => 'videos.comments.allread', 'uses' => 'VideoController@commentallread']);
    //videocomments
    Route::get('videocomments/search', ['as' => 'videocomments.search', 'uses' => 'CommentVideoController@search']);
    Route::get('videocomments/type/{type}', ['as' => 'videocomments.type', 'uses' => 'CommentVideoController@type']);
    Route::get('videocomments/{id}/reply', ['as' => 'videocomments.reply', 'uses' => 'CommentVideoController@reply']);
    Route::post('videocomments/{id}/reply/store', ['as' => 'videocomments.reply.store', 'uses' => 'CommentVideoController@replyStore']);
    Route::post('videocomments/allread', ['as' => 'videocomments.allread', 'uses' => 'CommentVideoController@allread']);
    //Ajax videocomments
    Route::post('videocommentsstatus', ['as' => 'videocommentsstatus', 'uses' => 'AjaxController@videocommentsStatus']);
    Route::post('videocommentsread', ['as' => 'videocommentsread', 'uses' => 'AjaxController@videocommentsRead']);

    //orders
    Route::get('orders/search', ['as' => 'orders.search', 'uses' => 'OrderController@search']);
    Route::post('orders/allread', ['as' => 'orders.allread', 'uses' => 'OrderController@allread']);
    //blogs
    Route::get('blog/{id}/createLang/{lang}', ['as' => 'blogs.createLang', 'uses' => 'BlogController@createLang']);
    Route::get('blog/{id}/editLang/{lang}', ['as' => 'blogs.editLang', 'uses' => 'BlogController@editLang']);
    Route::get('blogs/{id}/languages', ['as' => 'blogs.languages.index', 'uses' => 'BlogController@languages']);
    Route::get('blogs/search', ['as' => 'blogs.search', 'uses' => 'BlogController@search']);
    Route::get('blogs/arrange', ['as' => 'blogs.arrange.index', 'uses' => 'BlogController@BlogArrange']);
    Route::PATCH('blogs/Arrange/store', ['as' => 'blogs.arrange.store', 'uses' => 'BlogController@storeBlogArrange']);
    Route::get('blogs/{id}/comments', ['as' => 'blogs.comments.index', 'uses' => 'BlogController@comments']);
    Route::get('blogs/{id}/comments/create', ['as' => 'blogs.comments.create', 'uses' => 'BlogController@commentCreate']);
    Route::post('blogs/{id}/comments/store', ['as' => 'blogs.comments.store', 'uses' => 'BlogController@commentStore']);
    Route::post('blogs/allread/comments', ['as' => 'blogs.comments.allread', 'uses' => 'BlogController@commentallread']);
    //blogcomments
    Route::get('blogcomments/search', ['as' => 'blogcomments.search', 'uses' => 'CommentBlogController@search']);
    Route::get('blogcomments/type/{type}', ['as' => 'blogcomments.type', 'uses' => 'CommentBlogController@type']);
    Route::get('blogcomments/{id}/reply', ['as' => 'blogcomments.reply', 'uses' => 'CommentBlogController@reply']);
    Route::post('blogcomments/{id}/reply/store', ['as' => 'blogcomments.reply.store', 'uses' => 'CommentBlogController@replyStore']);
    Route::post('blogcomments/allread', ['as' => 'blogcomments.allread', 'uses' => 'CommentBlogController@allread']);
    //Ajax blogcomments
    Route::post('blogcommentsstatus', ['as' => 'blogcommentsstatus', 'uses' => 'AjaxController@blogcommentsStatus']);
    Route::post('blogcommentsread', ['as' => 'blogcommentsread', 'uses' => 'AjaxController@blogcommentsRead']);

//album
    Route::get('albums/type/{type}', ['as' => 'albums.type', 'uses' => 'AlbumController@type']);
    Route::get('albums/search', ['as' => 'albums.search', 'uses' => 'AlbumController@search']);
    Route::get('subalbums/Create/{id}', ['as' => 'subalbums.creat', 'uses' => 'SubalbumController@create_subalbum']);
    Route::get('subalbums/search', ['as' => 'subalbums.search', 'uses' => 'SubalbumController@search']);

//Category_Product
    Route::get('categories_product/type/{type}', ['as' => 'categories.product.type', 'uses' => 'CategoryProductController@type']);
    Route::get('categories_product/search', ['as' => 'categories_product.search', 'uses' => 'CategoryProductController@search']);
    Route::post('categorystatus_product', ['as' => 'categorystatus.product', 'uses' => 'AjaxController@categoryProductStatus']);
    //Subcategory_Product
    Route::get('categories_product/creat/{id}', ['as' => 'subcategories_product.creat', 'uses' => 'SubcategoryProductController@create']);
    Route::post('products/ajax_subcategoryProduct', ['as' => 'products.ajax_subcategoryProduct', 'uses' => 'AjaxController@ajax_subcategoryProduct']);
    Route::get('subcategories_product/search', ['as' => 'subcategories_product.search', 'uses' => 'SubcategoryProductController@search']);
    //Category_Product and Subcategory_Product
    Route::get('allcategories_product/search', ['as' => 'allcategories_product.search', 'uses' => 'CategoryProductController@allSearch']);
    //product
    Route::get('products/type/{type}', ['as' => 'products.type', 'uses' => 'ProductController@type']);
    Route::get('products/search', ['as' => 'products.search', 'uses' => 'ProductController@search']);
    Route::get('products/create/{type}', ['as' => 'products.creat', 'uses' => 'ProductController@create']);
    Route::get('products/edit/{id}/{type}', ['as' => 'products.edittype', 'uses' => 'ProductController@edit']);
    Route::get('products/{id}/vidoes', ['as' => 'products.videos.index', 'uses' => 'VideoController@vidoesCourse']);
//    Route::get('products/{id}/files', ['as' => 'products.files.index', 'uses' => 'FileController@filesCourse']);
    //products
    Route::get('products/{id}/comments', ['as' => 'products.comments.index', 'uses' => 'ProductController@comments']);
    Route::get('products/{id}/comments/create', ['as' => 'products.comments.create', 'uses' => 'ProductController@commentCreate']);
    Route::post('products/{id}/comments/store', ['as' => 'products.comments.store', 'uses' => 'ProductController@commentStore']);
    Route::post('products/allread/comments', ['as' => 'products.comments.allread', 'uses' => 'ProductController@commentallread']);
    //productcomments
    Route::get('productcomments/search', ['as' => 'productcomments.search', 'uses' => 'CommentProductController@search']);
    Route::get('productcomments/type/{type}', ['as' => 'productcomments.type', 'uses' => 'CommentProductController@type']);
    Route::get('productcomments/{id}/reply', ['as' => 'productcomments.reply', 'uses' => 'CommentProductController@reply']);
    Route::post('productcomments/{id}/reply/store', ['as' => 'productcomments.reply.store', 'uses' => 'CommentProductController@replyStore']);
    Route::post('productcomments/allread', ['as' => 'productcomments.allread', 'uses' => 'CommentProductController@allread']);
    //Ajax productcomments
    Route::post('productcommentsstatus', ['as' => 'productcommentsstatus', 'uses' => 'AjaxController@productcommentsStatus']);
    Route::post('productcommentsread', ['as' => 'productcommentsread', 'uses' => 'AjaxController@productcommentsRead']);

    //fees
    Route::get('fees/search', ['as' => 'fees.search', 'uses' => 'FeesController@search']);
    //apimessages
    Route::get('apimessages/search', ['as' => 'apimessages.search', 'uses' => 'ApimessagesController@search']);
    //matches
    Route::get('matches/{id}/comments', ['as' => 'matches.comments.index', 'uses' => 'MatchController@comments']);
    Route::get('matches/{id}/comments/create', ['as' => 'matches.comments.create', 'uses' => 'MatchController@commentCreate']);
    Route::get('matches/{id}/vidoes', ['as' => 'matches.videos.index', 'uses' => 'VideoController@vidoesCourse']);
    Route::get('matches/{id}/files', ['as' => 'matches.files.index', 'uses' => 'FileController@filesCourse']);
    Route::get('matches/type/{type}', ['as' => 'matches.type', 'uses' => 'MatchController@type']);
    Route::get('matches/search', ['as' => 'matches.search', 'uses' => 'MatchController@search']);
    Route::get('matches/create/{type}', ['as' => 'matches.creat', 'uses' => 'MatchController@create']);
    Route::get('matches/edit/{id}/{type}', ['as' => 'matches.edittype', 'uses' => 'MatchController@edit']);

    //Resource
    Route::resource('users', 'UserController');
    Route::resource('orders', 'OrderController');
    Route::resource('roles', 'RoleController');
    Route::resource('posts', 'PostController');
    Route::resource('matches', 'MatchController');
    Route::resource('videos', 'VideoController');
    Route::resource('videocomments', 'CommentVideoController');
    Route::resource('blogs', 'BlogController');
    Route::resource('blogcomments', 'CommentBlogController');
//    Route::resource('videos', 'VideoController', ['except' => ['index','store','create','show','edit','destroy']]);
    Route::resource('contacts', 'ContactController', ['except' => ['create', 'store', 'index']]);
    Route::resource('comments', 'CommentController');
//    Route::resource('comments', 'CommentController', ['except' => ['create', 'store']]);
    Route::resource('calendar', 'CalendarController');
    Route::resource('clubteams', 'TeamController');
    Route::resource('subclubteams', 'SubteamController');
    Route::resource('userclubteams', 'UserteamController');
    Route::resource('champions', 'ChampionController');
    Route::resource('audiences', 'AudienceController');
    Route::resource('categories', 'CategoryController');
    Route::resource('subcategories', 'SubcategoryController');
    Route::resource('albums', 'AlbumController');
    Route::resource('subalbums', 'SubalbumController');
    Route::resource('categories_product', 'CategoryProductController');
    Route::resource('subcategories_product', 'SubcategoryProductController');
    Route::resource('products', 'ProductController');
    Route::resource('productcomments', 'CommentProductController');
    Route::resource('fees', 'FeesController');
    Route::resource('apimessages', 'ApimessagesController');
    Route::resource('permission', 'PermissionController');
    Route::resource('tags', 'TagController');
    Route::resource('searches', 'SearchController');
    Route::resource('messages', 'MessageController', ['except' => ['edit', 'destroy']]);
});

