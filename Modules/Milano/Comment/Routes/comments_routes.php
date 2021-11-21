<?php

Route::group(["namespace" => "Milano\Comment\Http\Controllers", 'middleware' => ['web', 'auth', 'verified']], function ($router) {
    $router->resource('comments', 'CommentController');
    $router->patch('comments/{comment}/accept', 'CommentController@accept')->name('comments.accept');
    $router->patch('comments/{comment}/reject', 'CommentController@reject')->name('comments.reject');
    $router->get('comments/{comment}/details', 'CommentController@details')->name('comments.details');
    $router->post('/comments/{comment}/comment' , 'CommentController@details')->name('comment.details');
    $router->get('comments/{comment}/search', 'CommentController@search')->name('comments.search');
    $router->post('comments/{comment}/buy', 'CommentController@buy')->name('comments.buy');

    $router->get('comments/{comment}/reply' , 'CommentController@reply')->name('comments.reply');
    $router->post('comments' , 'CommentController@replyStore')->name('comments.replyStore');
});
