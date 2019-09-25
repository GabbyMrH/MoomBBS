<?php
    function route_class()
    {
        //此方法会将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制
        return str_replace('.', '-', Route::currentRouteName());
    }

    //识别active状态
    function category_nav_active($category_id)
    {
        return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
    }

    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return Str::limit($excerpt, $length);
    }
