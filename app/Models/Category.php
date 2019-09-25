<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //告知框架不需要维护时间戳，因为没设置
    //同时需要开启过滤白名单
    public $timestamps = false;

    protected $fillables = [
        'name','description',
    ];
}
