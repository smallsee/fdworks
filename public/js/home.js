;(function(){


  'use strict';
  angular.module('home',['angularFileUpload'])
    .controller('HomeController',['$scope', 'FileUploader', function($scope, FileUploader) {

      $scope.img = '1.jpg';

      var uploader = $scope.uploader = new FileUploader({
        url: 'api/upload/image',
        progress:0
      });
      // uploader.filters.push({
      //
      //   fn: function(item /*{File|FileLikeObject}*/, options) {
      //     var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
      //     return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
      //   }
      // });

      uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
        console.info('onWhenAddingFileFailed', item, filter, options);
      };
      uploader.onAfterAddingFile = function(fileItem) {
        console.info('onAfterAddingFile', fileItem);
        uploader.uploadAll();

      };
      uploader.onAfterAddingAll = function(addedFileItems) {
        console.info('onAfterAddingAll', addedFileItems);
      };
      uploader.onBeforeUploadItem = function(item) {
        console.info('onBeforeUploadItem', item);
      };
      uploader.onProgressItem = function(fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
      };
      uploader.onProgressAll = function(progress) {
        console.info('onProgressAll', progress);
      };
      uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', response.url);
        $scope.img = response.url

      };
      uploader.onErrorItem = function(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
      };
      uploader.onCancelItem = function(fileItem, response, status, headers) {
        console.info('onCancelItem', fileItem, response, status, headers);
      };
      uploader.onCompleteItem = function(fileItem, response, status, headers) {
        console.info('onCompleteItem', fileItem, response, status, headers);
      };
      uploader.onCompleteAll = function() {
        console.info('onCompleteAll');
      };

      console.info('uploader', uploader);

      $scope.UploadFile = function(){
        console.log('1');
        uploader.uploadAll();

      }
      $scope.reader = new FileReader();   //创建一个FileReader接口



    }])


})();