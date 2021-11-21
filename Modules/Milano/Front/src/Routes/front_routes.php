<?php
Route::group(['middleware' => ['web'], 'namespace' => 'Milano\Front\Http\Controllers'],  function ($router){
    $router->get('/', 'FrontController@index');

    $router->get('/search' , 'FrontController@search')->name('search.index');

    $router->get('/c-{slug}', 'FrontController@singleProduct')->name('singleProduct');
    $router->get('/product/allProduct' , 'FrontController@allProducts')->name('allProducts.product');
    $router->post('/product/{product}/comment' , 'FrontController@productComment')->name('comment.product');

    $router->get('/c1-{slug}', 'FrontController@singleArticle')->name('singleArticle');
    $router->get('/article/allArticle' , 'FrontController@allArticles')->name('allArticles.article');
    $router->post('/articles/{articles}/comment' , 'FrontController@articleComment')->name('comment.articles');

    $router->get('/tutors/{username}', 'FrontController@singleTutor')->name('singleTutor');

    $router->get('/seller' , ['uses'=>'FrontController@seller']);
    $router->post('/seller' ,['uses'=> 'FrontController@singleStore', 'as' => 'seller.singleStore']);

    $router->get('/contact-us','FrontController@setting')->name('setting.contact-us');

    });
