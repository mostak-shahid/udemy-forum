<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
	$title = $faker->sentence(6);
	$slug = str_slug($title);
    return [
        'title' =>$title,
        'slug' =>$slug,
    ];
});
