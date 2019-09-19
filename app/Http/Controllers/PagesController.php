<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //root方法用于显示主页
    public function root()
    {
        return view('pages.root');
    }
}
