;(function(){



  'use strict';
  angular.module('video',[])

    .service('VideoService',[
      '$state',
      '$http',
      function($state,$http){
        var me = this;
        me.add_data = {};

        me.add = function(){
          var video_content= $('#video_content').val();
          var thumb = $('#upload_org_code_img').attr('src');
          var $checkbox = $('.lifan-video-checkBox');
          var checkArr = [];
          $.each($checkbox,function(index,val){
            if (val.checked){
              checkArr.push(val.value);
            }
          });
          if (video_content.length <6){
            dialog.error('简介不能小于六个字符');
            return;
          }
          if (!thumb.length >0){
            dialog.error('请选择缩略图');
            return;
          }
          if (!checkArr[0]){
            dialog.error('请选择标签');
            return;
          }
          if (video_url == ''){
            dialog.error('请上传视频');
            return;
          }

          me.add_data.thumb = thumb;
          me.add_data.tag = checkArr;
          me.add_data.video_url = video_url;
          me.add_data.content = video_content;

          $http.post('api/video/add',me.add_data)
            .then(function(data){

              console.log(data);

            },function(e){

              console.log('e',e);
            })



        };

      }
    ])
    .controller('VideoAddController',[
      '$scope',
      'VideoService',
      function($scope,VideoService){
        $scope.Video = VideoService;


      }
    ]);


  KindEditor.ready(function(K){

  });



})();