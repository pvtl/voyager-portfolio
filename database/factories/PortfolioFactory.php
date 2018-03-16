<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Pvtl\VoyagerPortfolio\Portfolio::class, function (Faker $faker) {
    return [
        'title' => 'Hello World!',
        'slug' => 'hello-world',
        'status' => 'PUBLISHED',
        'featured' => 1,
        'category_id' => 1,
        'image' => 'posts/post1.jpg',
        'excerpt' => 'Lorem ipsum die sip petris...',
        'body' => '<p>' . $faker . '</p>',
        'testimonial' => '<p>' . $faker . '</p>',
        'testimonial_author' => 'John Smith',
        'meta_title' => 'Hello World! - From Pivotal',
        'meta_description' => 'There is no one who loves pain itself, who seeks after',
    ];
});
