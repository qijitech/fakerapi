<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1.0', ['namespace' => 'App\Http\Controllers\V1_0'], function ($api) {

  $api->get('/', function () { // For Test
    return app()->version();
  });

  // Auth API
  $api->post('auth/third_party', 'Auth\AuthController@postThirdParty'); // 第三方平台登录

  // Posts relation api without jwt
  $api->get('posts', 'PostsController@index'); // 动态列表-首页
  $api->get('posts/{post_id}/comments', 'CommentsController@index'); // 帖子评论

  $api->group(['middleware' => 'api.auth'], function ($api) {

    // Post relation API with jwt
    $api->post('posts', 'PostsController@store'); // 发布帖子
    $api->get('posts/{post_id}', 'PostsController@show'); // 帖子详情
    $api->post('posts/{post_id}/destroy', 'PostsController@destroy'); // 删除帖子

    $api->post('comments', 'CommentsController@store'); //发送评论

    // User relation API
    $api->post('users/update', 'UsersController@update'); // 修改资料
  });
});
