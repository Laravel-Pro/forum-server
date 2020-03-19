<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'thread_id' => fn() => factory(Thread::class)->create()->id,
        'user_id' => fn() => factory(User::class)->create()->id,
        'body' => fn() => $faker->paragraph,
    ];
});
