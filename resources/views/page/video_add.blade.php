<div class="video container" ng-controller="VideoAddController">
  <div class="card">


    <div class="pd-20">
      <form name="video_add_form" ng-submit="Video.add()"  class="form form-horizontal" id="form-member-add">


        <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>视频标题：</label>
          <div class="formControls col-5">
            <input ng-model="Video.add_data.title" type="text" class="input-text" value="" placeholder="" id="member-name" name="video_title" datatype="*2-16" nullmsg="视频名称不能为空">
          </div>
          <div class="col-4"> </div>
        </div>


        <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>缩略图：</label>
          <div class="formControls col-5">
            <img style="display: none"  id="upload_org_code_img"   src="" width="150" height="150">
            <input id="file_upload" name="file_upload" type="file" multiple="true">
          </div>
          <div class="col-4"> </div>
        </div>
        <div class="row cl">
          <label class="form-label col-3">视频：</label>
          <div class="formControls col-9"> <span class="btn-upload form-group">
        {{--<input class="input-text upload-url" type="text" name="uploadfile-2" id="uploadfile-2" readonly  datatype="*" nullmsg="请添加视频！" style="width:200px">--}}
              <progress id="progress" value="0" max="100"></progress>
          <button id="VideoUploading" class="btn btn-warning radius" ></button>
        <a href="javascript" class="btn btn-primary radius upload-btn"><i class="Hui-iconfont">&#xe642;</i> 上传视频</a>
        <input id="xiaohai_video" multiple name="file" type="file" class="input-file" onchange="upload()">

        </span> </div>
        </div>

        <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>标签:</label>
          <div class="formControls col-5 skin-minimal">
            <div class="radio-box">
              <input class="lifan-video-checkBox"  type="checkbox"  value="人妻" datatype="*" nullmsg="是否发布！">
              <label>人妻</label>
            </div>
            <div class="radio-box">
              <input class="lifan-video-checkBox"  type="checkbox"  value="萝莉" >
              <label>萝莉</label>
            </div>
            <div class="radio-box">
              <input class="lifan-video-checkBox"  type="checkbox"  value="制服" >
              <label>制服</label>
            </div>

            <div class="radio-box">
              <input class="lifan-video-checkBox"  type="checkbox"  value="痴女" >
              <label>痴女</label>
            </div>

            <div class="radio-box">
              <input class="lifan-video-checkBox"  type="checkbox"  value="触手" >
              <label>触手</label>
            </div>

            <div class="radio-box">
              <input class="lifan-video-checkBox"  type="checkbox"  value="MAD" >
              <label>MAD</label>
            </div>
          </div>
          <div class="col-4"> </div>
        </div>



        <div class="row cl">
          <label class="form-label col-3">视频简介：</label>
          <div class="formControls col-5">
            <textarea name="baidu" id="video_content" cols="50" rows="20"></textarea>
          </div>
          <div class="col-4"> </div>
        </div>
        <div class="row cl">
          <div class="col-9 col-offset-3">
            <input class="btn btn-primary radius" onclick="video_upload()" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
          </div>
        </div>
      </form>
    </div>
  </div>



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


  $('#file_upload').uploadify({
    'swf'      : "{{asset('uploadify.swf')}}",
    'uploader' : "{{asset('api/upload/image')}}",
    'buttonText': '上传图片',
    'fileTypeDesc': 'Image Files',
    'fileObjName' : 'imgFile',
    //允许上传的文件后缀
    'fileTypeExts': '*.gif; *.jpg; *.png',
    'onUploadSuccess' : function(file,data,response) {
      // response true ,false
      if(response) {
        var obj = JSON.parse(data); //由JSON字符串转换为JSON对象
        $('#' + file.id).find('.data').html(' 上传完毕');
        $("#upload_org_code_img").show();
        $("#upload_org_code_img").attr('src',obj.url);

      }else{
        alert('上传失败');
      }
    }
  });
  var randNumber = Math.random() * 10000;
  function upload(){
    var Cts = $('#xiaohai_video')[0].files[0];
    console.log(Cts);
    if (Cts.type.indexOf("video") < 0  ){
      dialog.error('最好上传mp4格式的视频')
      return
    }
    var fd = new FormData();
    fd.append("file",$('#xiaohai_video')[0].files[0]);
    fd.append("token","-xpzbXEV0gDocV0_SsQFn-WYczH9kPQr27wtYQ_2:PATP7JrQ2CNNUokqLJqRDvFwYlc=:eyJzY29wZSI6ImZkLXZpZGVvIiwiZGVhZGxpbmUiOjE0ODAyNDY5ODN9");
    fd.append("key","xiaohai-video"+randNumber);
    var xhr = new XMLHttpRequest();
    xhr.addEventListener('progress', function(e) {
      var done = e.loaded || e.loaded, total = e.total || e.total;
      console.log('xhr上传进度: ' + (Math.floor(done/total*1000)/10) + '%');
    }, false);
    if ( xhr.upload ) {
      xhr.upload.onprogress = function(e) {
        var done = e.loaded || e.loaded, total = e.total || e.total;
        console.log('xhr.upload上传进度: ' + done + ' / ' + total + ' = ' + (Math.floor(done/total*1000)/10) + '%');
        $('#progress_uploading').html( (Math.floor(done/total*1000)/10) + '%');
        document.getElementById("progress").value = Math.floor(done/total*1000)/10;
        $('#VideoUploading').show().html((Math.floor(done/total*1000)/10) + '%')
        if ((Math.floor(done/total*1000)/10) == 100 ){
          $('#VideoUploading').removeClass('btn-warning').addClass('btn-success');
          video_url = "http://ohae2zc8b.bkt.clouddn.com/xiaohai-video"+randNumber;
        }
      };
    }
    xhr.onreadystatechange = function(e) {
      if ( 4 == this.readyState ) {
        console.log(['xhr upload complete', e]);
      }
    };
    xhr.open('post', 'http://up.qiniu.com?', true);
    xhr.send(fd);
  }

</script>