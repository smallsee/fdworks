;(function(){


  'use strict';
  angular.module('book',[])
    .service('BookService',[
      '$state',
      '$http',
      function($state,$http){

        var me = this;
        me.book_data = [];
        me.page = 1;
        me.little_page = 1;
        me.tag = '';
        me.no_more_data =false;
        me.get_count =true;
        me.count =0;

        me.get = function(conf){
          if (me.pending || me.no_more_data) return;
          me.pending = true;
          conf = conf || {page:me.page,little_page:me.little_page,tag:me.tag};
          $http.post('data/book/data',conf)
            .then(function(r){
              if (r.data.status){

                //获取数据的条数
                if (me.get_count){
                  me.count = r.data.data.count;
                  me.get_count =false;
                  me.makePage();
                }

                if (r.data.data.book.length){
                  me.book_data =me.book_data.concat(r.data.data.book);
                  me.little_page++;
                }else{
                  me.no_more_data = true;
                }

              }else{
                console.log(r);
              }
            })
            .finally(function(){
              me.pending = false;

            })
        };
        me.makePage = function(){
          //显示宽数
          me.page_list = Math.ceil(me.count/15);
          me.page_item = {};
          for (var i=0;i<me.page_list;i++){
            me.page_item[i] = 1;
          }

          console.log(me.page_item)
        };

        me.changPage = function(page){
          me.no_more_data = false;
          me.book_data = [];
          me.page=page;
          me.little_page = (page-1)*3+1;
          console.log(page);
          console.log(me.little_page);
          me.get();
        };

        me.changTag = function(tag){
          me.no_more_data = false;
          me.get_count =true;
          me.book_data = [];
          me.page=1;
          me.tag=tag;
          me.little_page = 1;
          me.get();
        }



      }
    ])
    .controller('BookController',[
      '$scope',
      'BookService',
      function($scope,BookService){
        var $win;
        $scope.Book = BookService;
        BookService.get();

        //类型

        $scope.tags = [
          {
            tag:'',
            name:'全部'
          },
          {
            tag:'zxcxzcsad',
            name:'小海'
          },
          {
            tag:'sadasdsadzxczx',
            name:'大海'
          },
          {
            tag:'zzz',
            name:'中海'
          }
        ];

        //页面滚动时加载数据
        $win = $(window);
        $win.on('scroll',function(){
          $win.scrollTop();
          if ($win.scrollTop() - ($(document).height()-$win.height()) > -30){
            BookService.get();
          }

        });
      }
    ])


})();