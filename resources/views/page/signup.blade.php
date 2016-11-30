<div class="signup container" ng-controller="SignupController">
  <div class="card">
    <h1>注册</h1>
    {{--[: User.signup_data :]--}}
    <form name="signup_form" >


      <div class="input-group">
        <label>用户名:</label>

        <input type="radio" ng-model="phone_or_email" ng-value="1" >邮箱注册
        <input type="radio" ng-model="phone_or_email" ng-value="0">手机注册
        <div class="email" ng-if="phone_or_email==1">
          <input
                  name="username"
                  type="text"
                  ng-minlength="4"
                  ng-maxlength="24"
                  ng-model="User.signup_data.username"
                  ng-model-options="{debounce:500}"
                  placeholder="填写邮箱"
                  required
          >
        </div>

        <div class="phone" ng-if="phone_or_email==0">
          <input
                  name="username"
                  type="text"
                  ng-minlength="4"
                  ng-maxlength="24"
                  ng-model="User.signup_data.username"
                  placeholder="填写手机号"
                  ng-model-options="{debounce:500}"
                  required
          >
          <input
                  name="phone_code"
                  type="text"
                  ng-model="User.signup_data.phone_code"
                  placeholder="手机验证码"
                  required
          >

          <button ng-disabled="signup_form.username.$error.required" ng-click="User.sendSms()">发送短信</button>
        </div>


        <div ng-if="signup_form.username.$touched" class="input-err-set">
          <div ng-if="signup_form.username.$error.required">用户名为必填项</div>

          <div ng-if="signup_form.username.$error.minlength ||
            signup_form.username.$error.maxlength"
          >用户名长度需在4至24位之间</div>

          <div ng-if="User.signup_username_exists">用户名已存在</div>
        </div>
      </div>

      <div class="input-group">
        <label>密码:</label>
        <input
                name="password"
                type="password"
                ng-minlength="6"
                ng-maxlength="255"
                ng-model="User.signup_data.password"
                placeholder="填写密码"
                required
        >
        <div ng-if="signup_form.password.$touched" class="input-err-set">
          <div ng-if="signup_form.password.$error.required">密码为必填项</div>
          <div ng-if="signup_form.password.$error.minlength ||
            signup_form.password.$error.maxlength"
          >密码长度需在6至255位之间</div>
        </div>
      </div>

      <div class="input-group">
        <label>验证码:</label>

        <input
                name="validateCode"
                type="text"
                ng-model="User.signup_data.validateCode"
                ng-model-options="{debounce:500}"
                required
                placeholder="验证码"
        >
        <img src="{{asset('api/validateCode')}}" alt="1" onclick="$(this).attr('src',$(this).attr('src')+'?'+Math.random())">
        <div ng-if="signup_form.validateCode.$touched" class="input-err-set">
          <div ng-if="signup_form.validateCode.$error.required">验证码为必填项</div>
          <div ng-if="User.signup_validateCode_right">验证码错误</div>
        </div>
      </div>



      <div class="hr"></div>
      <div class="improve-info">是否完善信息</div>
      <div class="norequired-info">
        <div class="input-group">
          <label>昵称:</label>
          <input name="nickname" type="text" ng-model="User.signup_data.nickname">
        </div>

        <div class="input-group">
          <label>简介:</label>
          <input name="info" type="text" ng-model="User.signup_data.info">
        </div>
        <div class="input-group">
          <div id="norequired-info">
            <div class="container">
              <div class="imageBox">
                <div class="thumbBox"></div>
                <div class="spinner" style="display: none">Loading...</div>
              </div>
              <div class="action">
                <!-- <input type="file" id="file" style=" width: 200px">-->
                <div class="new-contentarea tc"><a href="javascript:void(0)" class="upload-img">
                    <label for="upload-file">上传图像</label>
                  </a>
                  <input type="file" class="" name="upload-file" id="upload-file"/>
                </div>
                <input type="button" id="btnCrop" class="Btnsty_peyton" value="裁切">
                <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+">
                <input type="button" id="btnZoomOut" class="Btnsty_peyton" value="-">
              </div>

              <div class="cropped"></div>

            </div>
          </div>


        </div>
      </div>

      <button class="primary" type="submit"
              ng-disabled="signup_form.$invalid" ng-click="User.signup()">注册</button>
    </form>
  </div>
</div>

<script>


    $('.norequired-info').hide();
    $('.improve-info').click(function(){
      $('.norequired-info').show();
    });
    var options =
    {
      thumbBox: '.thumbBox',
      spinner: '.spinner',
      imgSrc: 'avatar.png'
    };
    var cropper = $('.imageBox').cropbox(options);
    var img = "";
    $('#upload-file').on('change', function () {
      var reader = new FileReader();
      reader.onload = function (e) {
        options.imgSrc = e.target.result;
        cropper = $('.imageBox').cropbox(options);
      };
      reader.readAsDataURL(this.files[0]);
      this.files = [];
      $('#btnCrop').click();
    });
    $('#btnCrop').on('click', function () {
      img = cropper.getDataURL();
      $('.cropped').html('');
      $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;" ><p>64px*64px</p>');
      $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
      $('.cropped').append('<img class="username_avatar" src="' + img + '" align="absmiddle" style="width:180px;margin-top:4px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>');
    });
    function getImg() {

    }
    $('#btnZoomIn').on('click', function () {
      cropper.zoomIn();
    });
    $('#btnZoomOut').on('click', function () {
      cropper.zoomOut();
    })





</script>