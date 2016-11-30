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

        me.get = function(conf){
          if (me.pending || me.no_more_data) return;

          me.pending = true;
          conf = conf || {page:me.page,little_page:me.little_page,tag:me.tag};
          $http.post('data/book/data',conf)
            .then(function(r){
              if (r.data.status){
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