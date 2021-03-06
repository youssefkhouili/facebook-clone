<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id'   => factory(User::class),
        'body'  => $faker->paragraphs(rand(3, 5), true),
        'post_img'   => 'img.jpg'
    ];
});
