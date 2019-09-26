<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    // 随机取一个月以内的时间
    //ps:假数据生成顺序：1、数据模型工厂定义，2、到seeds内编写填充逻辑，3、运行php artisan migrate:refresh --seed
    $time = $faker->dateTimeThisMonth();
    return [
        'content' => $faker->sentence(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
