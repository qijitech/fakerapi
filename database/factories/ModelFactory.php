<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Post;
use App\Entity\PostCategory;
use App\Entity\User;
use App\Entity\UserInfo;

$factory->define(User::class, function (Faker\Generator $faker) {
  return [
    'mobile'   => '181' . mt_rand(10000000, 99990000),
    'password' => bcrypt('123456'),
  ];
});

$factory->define(UserInfo::class, function (Faker\Generator $faker) {
  return [
    'user_id'  => function () {
      return factory(User::class)->create()->id;
    },
    'nickname' => $faker->name,
  ];
});

$factory->define(Post::class, function (Faker\Generator $faker) {
  return [
    'content'          => $faker->paragraph(3),
    'post_category_id' => PostCategory::all()->random()->id,
    'user_id'          => UserInfo::all()->random()->user_id,
  ];
});

$factory->define(Image::class, function (Faker\Generator $faker) {
  return [
    'url'            => $faker->imageUrl(200, 200),
    'imageable_id'   => Post::all()->random()->id,
    'imageable_type' => Post::class,
  ];
});

$factory->define(Comment::class, function (Faker\Generator $faker) {
  return [
    'content' => $faker->paragraph(2),
    'user_id' => UserInfo::all()->random()->user_id,
    'post_id' => 1,
  ];
});
