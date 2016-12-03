;(function(){


  'use strict';
  angular.module('book',[])
    .directive('repeatFinish',function(){
      return {
        link: function(scope,element,attr){
          // console.log(scope.$index);
          if(scope.$last == true){
            waterfall();
            setTimeout(function(){
              waterfall();
              mainBox_height();
            },600)
          }
        }
      }
    })
    .service('BookService',[
      '$state',
      '$http',
      function($state,$http){

        var me = this;
        me.book_data = [];
        me.this_page_end = false;
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
                return
              }
            })
            .finally(function(){
              me.pending = false;
              waterfall();
              setTimeout(function(){

                mainBox_height();
              },600);

            })
        };
        me.makePage = function(){
          //显示宽数
          me.page_list = Math.ceil(me.count/30);
          me.page_item = {};
          for (var i=0;i<me.page_list;i++){
            me.page_item[i] = 1;
          }

        };

        me.changPage = function(page){
          me.no_more_data = false;
          me.book_data = [];
          me.page=page;
          me.little_page = (page-1)*3+1;
          me.get();

          setTimeout(function(){

            waterfall();
            mainBox_height();

          },600);
        };

        me.changTag = function(tag){
          me.no_more_data = false;
          me.get_count =true;
          me.book_data = [];
          me.page=1;
          me.tag=tag;
          me.little_page = 1;
          me.get();

          setTimeout(function(){
            waterfall();
            mainBox_height();

          },600);
        }

        me.reset_state = function(){
          me.book_data = [];
          me.page = 1;
          me.little_page = 1;
          me.no_more_data = false;
        }



      }
    ])
    .controller('BookController',[
      '$scope',
      'BookService',
      function($scope,BookService){
        var $win;
        $scope.Book = BookService;
        BookService.reset_state();
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

            mainBox_height();

        })

      }
    ]);

    setTimeout(function(){
      waterfall();

    },600);


})();


function mainBox_height(){
  var $lastBox = $('#book-mainBox .book-box').last();
  var lastBoxDis = $lastBox.offset().top+Math.floor($lastBox.outerHeight()/2);
  $('#book-mainBox').height(lastBoxDis + 20) ;
}

function waterfall(){
  var main = $('#book-mainBox');
  var $boxs = $('#book-mainBox .book-box');
  var w = $boxs.eq(0).outerWidth();
  var cols = Math.floor(main.width()/w);
  var hArr = [];
  $boxs.each(function(index,value){
    var h = $boxs.eq(index).outerHeight();
    if (index < cols){
      hArr[index] = h;
      $(value).animate({
        opacity:1,
      },600)
    }else{
      var minH = Math.min.apply(null,hArr);
      var minHIndex = $.inArray(minH,hArr);
      $(value).css({
        position:'absolute',

      }).animate({
        top:minH,
        left:minHIndex*w,
        opacity:1,
      },600);
      hArr[minHIndex]+=$boxs.eq(index).outerHeight();

    }
  });
}