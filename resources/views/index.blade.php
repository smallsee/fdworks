<!doctype html>
<html lang="zh" ng-app="fdword" user-id="{{session('user_id')}}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{asset('/node_modules/normalize-css/normalize.css')}}">
  <link rel="stylesheet" href="{{asset('/node_modules/uploadify/uploadify.css')}}">
  <link rel="stylesheet" href="{{asset('/css/avatar.css')}}">
  <link rel="stylesheet" href="{{asset('/css/iconfont.css')}}">
  <link rel="stylesheet" href="{{asset('/css/common.css')}}">
  <link rel="stylesheet" href="{{asset('/css/animate.min.css')}}">
  <link rel="stylesheet" href="{{asset('/css/base.css')}}">

  <script src="{{asset('/node_modules/jquery/dist/jquery.js')}}"></script>
  <script src="{{asset('/node_modules/cropbox.js')}}"></script>
  <script src="{{asset('/node_modules/uploadify/jquery.uploadify.js')}}"></script>
  <script src="{{asset('/node_modules/angular/angular.js')}}"></script>
  <script src="{{asset('/node_modules/angular-ui-router/release/angular-ui-router.js')}}"></script>
  <script src="{{ asset('/node_modules/kindeditor/kindeditor.js') }}"></script>
  <script src="{{ asset('/node_modules/layer/layer.js') }}"></script>
  <script src="{{ asset('/node_modules/layer/dialog.js') }}"></script>
  <script src="{{asset('/js/base.js')}}"></script>
  <script src="{{asset('/js/user.js')}}"></script>
  <script src="{{asset('/js/video.js')}}"></script>
</head>
<body>
{{--头部--}}
<header class="header animated bounce">
  <div class="container clearfix">
    <div class="fl">
      <div ui-sref="home" class="header-item brand">F.D.Words</div>
      <a ui-sref="home" class="header-item">音乐模式</a>
      <a ui-sref="home" class="header-item">微博</a>
    </div>
    <div class="fr">
      @if(is_logged_in())
        <a ui-sref="login" class="header-item">{{session('username')}}</a>
        <a href="{{url('/api/logout')}}" class="header-item">登出</a>
      @else
        <a ui-sref="login" class="header-item">登录</a>
        <a ui-sref="signup" class="header-item">注册</a>
      @endif
    </div>
  </div>
</header>
{{--旗帜--}}
<div class="banner"></div>
{{--导航--}}

<div class="nav">
  <div class="container clearfix">
    <div class="fl">

      <a ui-sref="home" class="navbar-item">首页</a>
      <a ui-sref="video" class="navbar-item">视频</a>
      <a ui-sref="book" class="navbar-item">本子</a>
      <a ui-sref="home" class="navbar-item">微博</a>
      <a ui-sref="home" class="navbar-item">论坛</a>
      <a ui-sref="home" class="navbar-item">成员</a>
      <div class="navbar-item-cur">
        <div class="navbar-item-cur-tag"></div>
      </div>
    </div>

  </div>
</div>

  <div class="page" ng-controller="CommonController">
    <div ui-view></div>
  </div>
</body>
<script>

  var nav_item =$('.navbar-item');
  var nav_item_cur =$('.navbar-item-cur');

  for(var i=0;i<nav_item.length-1;i++){
    nav_item.on('mouseover',function(){
      nav_item_cur.css({
        'left':$(this).index()* (nav_item.outerWidth() +10 )
      })
    })
  }


</script>

</html>