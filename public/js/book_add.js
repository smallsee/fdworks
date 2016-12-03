;(function(){


  'use strict';
  angular.module('bookAdd',['angularFileUpload'])
    .service('BookAddService',[
      '$http',
      '$state',
      function($http,$state){
        var me = this;
        me.book_data = {};
        me.book_data.thumb = 'avatar.png';
        me.lists = [];
        me.has_lists = false;

        me.add = function(){
          $http.post('api/book/add',me.book_data)
            .then(function(r){
              $state.go('book');
            })
        }
      }
    ])
    .controller('BookAddController',[
      '$scope',
      'BookAddService',
      'FileUploader',
      function($scope,BookAddService,FileUploader){
        $scope.Book = BookAddService;
        $scope.tag = {};
        $scope.look = function(){
          console.log(BookAddService.book_data)
        }


        var uploader = $scope.uploader = new FileUploader({
          url: 'api/upload/image',
          progress:0
        });

        uploader.onAfterAddingFile = function(fileItem) {
          console.info('onAfterAddingFile', fileItem);
          uploader.uploadAll();
        };
        uploader.onProgressItem = function(fileItem, progress) {
          console.info('onProgressItem', fileItem, progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
          console.info('onSuccessItem', response);
          BookAddService.book_data.thumb = response.url
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
          console.info('onErrorItem', fileItem, response, status, headers);
        };


        $scope.$watch(function(){
          return $scope.tag ;
        },function(n,o){

          var tags = '';
          angular.forEach($scope.tag,function(v,k){
            if (v)
              tags +=k+',';
          });
          BookAddService.book_data.tag = tags.substring(0,tags.length-1);

          if (BookAddService.book_data.tag.length>1){
            $scope.has_tag = true;
          }

          console.log(BookAddService.book_data)
        },true);
      }
    ])
    .controller('bookListController',[
      'BookAddService',
      '$scope',
      function(BookAddService,$scope){




        $("#zyupload").zyUpload({
          width            :   "750px",                 // 宽度
          height           :   "400px",                 // 宽度
          itemWidth        :   "140px",                 // 文件项的宽度
          itemHeight       :   "115px",                 // 文件项的高度
          url              :   "/api/upload/image",  // 上传文件的路径
          fileType         :   ["jpg","png","txt","js","exe"],// 上传文件的类型
          fileSize         :   51200000,                // 上传文件的大小
          multiple         :   true,                    // 是否可以多个文件上传
          dragDrop         :   true,                    // 是否可以拖动上传文件
          tailor           :   false,                    // 是否可以裁剪图片
          del              :   true,                    // 是否可以删除文件
          finishDel        :   false,  				  // 是否在上传文件完成后删除预览
          /* 外部获得的回调接口 */
          onSelect: function(selectFiles, allFiles){    // 选择文件的回调方法  selectFile:当前选中的文件  allFiles:还没上传的全部文件
            console.info("当前选择了以下文件：");
            console.info(selectFiles);
          },
          onDelete: function(file, files){              // 删除一个文件的回调方法 file:当前删除的文件  files:删除之后的文件
            console.info("当前删除了此文件：");
            console.info(file.name);
          },
          onSuccess: function(file, response){          // 文件上传成功的回调方法
            console.log(response)
            if(response) {
              var obj = JSON.parse(response); //由JSON字符串转换为JSON对象--}}
              BookAddService.lists.push(obj.url);

            }

          },
          onFailure: function(file, response){          // 文件上传失败的回调方法
            console.info("此文件上传失败：");
            console.info(file.name);
          },
          onComplete: function(response){           	  // 上传完成的回调方法
            BookAddService.book_data.book_lists = angular.toJson(BookAddService.lists);
            console.log(BookAddService.book_data)
            BookAddService.has_lists = true;
          }
        });


      }
    ])


})();