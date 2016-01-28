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

use App\Entity\Feed;
use App\Entity\Image;
use App\Entity\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'phone'    => '181' . mt_rand(1000, 9999) . '8181',
        'nickname' => $faker->name,
        'email'    => $faker->email,
        'password' => bcrypt('111111'),
        'avatar'   => $faker->imageUrl(180, 180),
    ];
});

$factory->define(Feed::class, function (Faker\Generator $faker) {
    return [
        'user_id'       => User::all()->random()->id,
        'content'       => $faker->paragraph(),
        'share_times'   => $faker->randomNumber(),
        'browse_times'  => $faker->randomNumber(),
        'comment_times' => $faker->randomNumber(),
    ];
});


$factory->define(Image::class, function (Faker\Generator $faker) {
    $widths = [720, 1080, 480, 480, 540, 720, 480, 1080, 320];
    $heights = [1290, 1920, 854, 800, 960, 1184, 728, 1776, 480];
    $index = $faker->numberBetween(0, count($widths) - 1);
    return [
        'user_id'        => User::all()->random()->id,
        'url'            => $faker->imageUrl($widths[$index], $heights[$index]),
        'width'          => $widths[$index],
        'height'         => $heights[$index],
        'imageable_id'   => Feed::all()->random()->id,
        'imageable_type' => Feed::class,
    ];
});