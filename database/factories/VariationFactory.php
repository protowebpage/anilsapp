<?php

$factory->define(App\Variation::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->word,
		'description' => $faker->sentence,
		'image' => rand(1, 3).'.png'
	];
});