<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Discussion;
use Faker\Generator as Faker;

$factory->define(Discussion::class, function (Faker $faker) {
	$title = $faker->sentence(6);
	$slug = str_slug($title);
    return [
        'user_id' => 1,
        'channel_id' => 1,
        'title' =>$title,
        'slug' =>$slug,
        'content' =>$faker->paragraph(3),
    ];
});
