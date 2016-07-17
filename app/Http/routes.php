<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1.0', ['namespace' => 'App\Http\Controllers\V1_0'], function ($api) {
  $api->get('/', function () {
    return app()->version();
  });

  // auth API
  $api->post('auth/third_party', 'Auth\AuthController@postThirdParty'); // 第三方平台登录


  $api->get('posts', 'PostsController@index'); // 动态列表-首页

  $api->group(['middleware' => 'api.auth'], function ($api) {

    // Post relation API
    $api->post('posts', 'PostsController@store');
    $api->get('posts/{post_id}', 'PostsController@show');
    $api->post('posts/{post_id}/destroy', 'PostsController@destroy');

    $api->post('comments', 'CommentsController@store'); //发送评论
  });
});
