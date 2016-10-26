<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1.0', ['namespace' => 'App\Http\Controllers\V1_0'], function ($api) {
  $api->get('/', function () {
    return app()->version();
  });

  $api->get('posts', 'PostsController@index'); // 动态列表-首页
  $api->get('posts/pages', 'PostsController@getPosts'); // 动态列表-首页
});
