<?php

$factory->define(App\Product::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->word,
		'description' => $faker->sentence,
		'image' => rand(1,4).'.png'
	];
});