@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card shadow bg-white">
      <img class="card-img-top" src="{{$user->avatar}}" alt="{{ $user->name }}">
      <div class="card-body">
            <h5><strong>个人简介</strong></h5>
            {{-- 此处执行后仍然不显示，数据表内也没数据，原因是还需要在User模型中将introduction字段加入过滤(允许修改) --}}
            <p>{{$user->introduction}}</p>
            <hr>
            <h5><strong>注册于</strong></h5>
            <p>{{ $user->created_at->diffForHumans() }}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card shadow bg-white">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} /<small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

      {{-- 用户发布的内容 --}}
      <div class="card shadow bg-white">
        <div class="card-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">
                Ta 的话题
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
                Ta 的回复
              </a>
            </li>
          </ul>
          @if (if_query('tab', 'replies'))
            @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
          @else
            @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
          @endif
        </div>
      </div>

    </div>
</div>
@stop
