<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\Thread;
use App\User;
use DavidBadura\FakerMarkdownGenerator\FakerProvider as MarkdownFakerProvider;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    $faker->addProvider(new MarkdownFakerProvider($faker));
    $channels = Channel::query()->get();
    if ($channels->count() === 0) {
        factory(Channel::class, 5)->create();
    }
    return [
        'author_id' => fn() => factory(User::class)->create()->id,
        'channel_id' => fn() => Channel::query()->inRandomOrder()->first()->id,
        'title' => $faker->sentence,
        'body' => $faker->markdown,
        'rendered' => $faker->randomHtml(),
        'replies_count' => 0,
        'activity_at' => now(),
    ];
});
