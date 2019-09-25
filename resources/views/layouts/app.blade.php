<!DOCTYPE html>{{--app()->getLocale() 获取的是 config/app.php 中的 locale 选项--}}
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- @yield表示继承此模板可以注入数据 --}}
  <title>@yield('title', 'MoomBBS') - 基于Laravel 6.0</title>

  <!-- Styles mix('css/app.css') 会根据 webpack.mix.js 的逻辑来生成 CSS 文件链接-->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('styles')
</head>

<body> {{--route_class() 是自定义的辅助方法,需要在 helpers.php 文件中添加此方法--}}
  <div id="app" class="{{ route_class() }}-page">
    {{-- 加载顶部导航区块的子模板 --}}
    @include('layouts._header')

    <div class="container">

      @include('shared._messages')
      {{-- @yield表示允许继承此模板的页面注入内容 --}}
      @yield('content')

    </div>

    @include('layouts._footer')
  </div>

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('scripts')
</body>

</html>
