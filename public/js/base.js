;(function(){
  'use strict';

  window.his = {
    id:parseInt($('html').attr('user-id'))
  };

  angular.module('fdword',[
    'ui.router',
    'user',
    'videoAdd',
    'home',
    'book',
    'bookAdd'
  ])
    .config(['$interpolateProvider','$stateProvider','$urlRouterProvider',
      function($interpolateProvider,$stateProvider,$urlRouterProvider){
        $interpolateProvider.startSymbol('[:');
        $interpolateProvider.endSymbol(':]');

        $urlRouterProvider.otherwise('/home');

        $stateProvider
          .state('home',{
            url:'/home',
            templateUrl:'tpl/page/home' //若在当前页面找不到home.tpl 就会到服务端去找
          })
          .state('login',{
            url:'/login',
            templateUrl:'tpl/page/login'
          })

          .state('signup',{
            url:'/signup',
            templateUrl:'tpl/page/signup'
          })
          .state('video',{
            url:'/video',
            templateUrl:'tpl/page/video'
          })

          .state('video.add',{
            url:'/add/:id',
            templateUrl:'tpl/page/video/add'
          })

          .state('book',{
            url:'/book',
            templateUrl:'tpl/page/book'
          })

          .state('book/add',{
            url:'/book/add/:id',
            templateUrl:'tpl/page/book/add'
          })


      }])
    .controller('CommonController',[
      '$scope',
      '$location',
      function($scope,$location){


        $scope.$watch(function(){
          return $location.url();
        },function(n,o){
          var   url_str_ten = n.substr(0, 8);
          var  url_exists_video = url_str_ten.indexOf('/video');
          var  url_exists_home = url_str_ten.indexOf('/home');
          var  url_exists_book = url_str_ten.indexOf('/book');
          var nav_item_cur_page = 0;

          if (url_exists_home == 0){
            nav_item_cur_page = 0;
          }
          if (url_exists_book == 0){
            nav_item_cur_page = 2;
          }
          if (url_exists_video == 0){
            nav_item_cur_page = 1;
          }

          nav_item_cur.css({
            'left':nav_item_cur_page * (nav_item.outerWidth() +10 )
          });

          nav_item.on('mouseout',function(){
            nav_item_cur.css({
              'left':nav_item_cur_page * (nav_item.outerWidth() +10 )
            })
          })

        },true);
      }
    ])






})();