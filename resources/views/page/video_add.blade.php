<div class="video container" ng-controller="VideoAddController">
  <div class="card">



      <form name="videoAdd_form" ng-submit="Video.add()">

        <div class="input-group">
          <label>标题:</label>
          <input name="title" type="text" ng-model="Video.video_data.title" required>
        </div>
        <div ng-if="videoAdd_form.title.$touched" class="input-err-set">
          <div ng-if="videoAdd_form.title.$error.required">标题为必填项</div>
        </div>


        <div class="input-group">
          <label>缩略图:</label>
          <input type="file" name="video_thumb" nv-file-select uploader="uploader" />
          <img ng-src="[: Video.video_data.thumb :]" alt="" width="150px" height="150px">
        </div>

        <div class="input-group">
          <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.renqi" />人妻
          <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.luoli" />萝莉
          <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.zhifu" />制服
          <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.chinv" />痴女
          <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.chushou" />触手
        </div>

        <progress id="progress" value="0" max="100"></progress>
        <input type="file" id="xiaohai_video" onchange="angular.element(this).scope().video_upload(this.files)">


        {{--<textarea  id="video_content" ng-click="uploadVideo()"></textarea>--}}

        <textarea ng-model="Video.video_data.content" required></textarea>

        <input type="submit" ng-disabled="videoAdd_form.$invalid || !has_tag"   value="提交">
      </form>



  </div>
</div>







<script type="text/javascript">

  $('#VideoUploading').hide();


  var  video_url ='';
  KindEditor.ready(function(K){
    window.editor = K.create('#video_content',{
      uploadJson : "{{asset('api/upload/image')}}",
      afterBlur : function(){this.sync();} //
    })
  });


  {{--$('#file_upload').uploadify({--}}
    {{--'swf'      : "{{asset('uploadify.swf')}}",--}}
    {{--'uploader' : "{{asset('api/upload/image')}}",--}}
    {{--'buttonText': '上传图片',--}}
    {{--'fileTypeDesc': 'Image Files',--}}
    {{--'fileObjName' : 'imgFile',--}}
    {{--//允许上传的文件后缀--}}
    {{--'fileTypeExts': '*.gif; *.jpg; *.png',--}}
    {{--'onUploadSuccess' : function(file,data,response) {--}}
      {{--// response true ,false--}}
      {{--if(response) {--}}
        {{--var obj = JSON.parse(data); //由JSON字符串转换为JSON对象--}}
        {{--$('#' + file.id).find('.data').html(' 上传完毕');--}}
        {{--$("#upload_org_code_img").show();--}}
        {{--$("#upload_org_code_img").attr('src',obj.url);--}}
      {{--}else{--}}
        {{--alert('上传失败');--}}
      {{--}--}}
    {{--}--}}
  {{--});--}}


//  function upload(){
//    var Cts = $('#xiaohai_video')[0].files[0];
//    if (Cts.type.indexOf("video") < 0  ){
//      dialog.error('最好上传mp4格式的视频')
//      return
//    }
//    var fd = new FormData();
//    fd.append("file",$('#xiaohai_video')[0].files[0]);
//    fd.append("token","-xpzbXEV0gDocV0_SsQFn-WYczH9kPQr27wtYQ_2:PATP7JrQ2CNNUokqLJqRDvFwYlc=:eyJzY29wZSI6ImZkLXZpZGVvIiwiZGVhZGxpbmUiOjE0ODAyNDY5ODN9");
//    fd.append("key","xiaohai-video"+randNumber);
//    var xhr = new XMLHttpRequest();
//    xhr.addEventListener('progress', function(e) {
//      var done = e.loaded || e.loaded, total = e.total || e.total;
//      console.log('xhr上传进度: ' + (Math.floor(done/total*1000)/10) + '%');
//    }, false);
//    if ( xhr.upload ) {
//      xhr.upload.onprogress = function(e) {
//        var done = e.loaded || e.loaded, total = e.total || e.total;
//        console.log('xhr.upload上传进度: ' + done + ' / ' + total + ' = ' + (Math.floor(done/total*1000)/10) + '%');
//        $('#progress_uploading').html( (Math.floor(done/total*1000)/10) + '%');
//        document.getElementById("progress").value = Math.floor(done/total*1000)/10;
//        $('#VideoUploading').show().html((Math.floor(done/total*1000)/10) + '%')
//        if ((Math.floor(done/total*1000)/10) == 100 ){
//          $('#VideoUploading').removeClass('btn-warning').addClass('btn-success');
//          video_url = "http://ohae2zc8b.bkt.clouddn.com/xiaohai-video"+randNumber;
//        }
//      };
//    }
//    xhr.onreadystatechange = function(e) {
//      if ( 4 == this.readyState ) {
//        console.log(['xhr upload complete', e]);
//      }
//    };
//    xhr.open('post', 'http://up.qiniu.com?', true);
//    xhr.send(fd);
//  }

</script>