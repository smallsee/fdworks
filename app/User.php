<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Tool\Validate\ValidateCode;
use App\Tool\M3Email;
use App\Tool\SMS\Sms;
use Mail;
use Hash;

class User extends Authenticatable
{

    //检查手机或邮箱是存在
    public function check_phone_or_email_is_exists($user){

      $email_exists = $this::where('email',$user)
        ->exists();
      $phone_exists = $this::where('phone',$user)
        ->exists();
      if (($email_exists || $phone_exists) && $user)
        dd(err('email or phone exists'));

    }

    //  注册
    public function signUp(){
      $email = rq('email');
      $phone = rq('phone');
      $username = rq('username');
      $password = rq('password');
      $nickname =rq('nickname');
      $avatar =rq('avatar');
      $info =rq('info');
      $validateCode = rq('validateCode');

      if (strstr($username,'@'))
        $email = $username;
      else
        $phone = $username;

      if (!$validateCode)
        return err('validateCode is required');
      if ($validateCode != session()->get('validate_code') )
        return err('validate_code not right');

      if (!$phone && !$email)
        return err('email or phone required');
      if (!$password)
        return err('password is required');
      $this->check_phone_or_email_is_exists($email);
      $this->check_phone_or_email_is_exists($phone);
      $uuid = create_code();

      if ($email){//邮箱注册
        $m3_email = new M3Email;
        $m3_email->to = $email;
        $m3_email->cc = 'xiaohai@speakez.cn';
        $m3_email->subject = '小海';
        $m3_email->content = 'http://www.Hlifan.com/api/validate_email'
          . '?member_id=454578'
          . '&code=' . $uuid
          . '&time=' . date('Y-m-d H-i-s', time() + 24*60*60);
        session()->put('email_code',$uuid);

        $sendSMS = Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
          // $m->from('hello@app.com', 'Your Application');
          $m->to($m3_email->to,"xiaohai")
            ->cc($m3_email->cc)
            ->subject($m3_email->subject);
        });

        if (!$sendSMS)
          return err('send email is fail');
      }
      if ($phone){ //手机注册


        if (session('phone_code') != rq('phone_code'))
          return err('phone_code not right');

      }

      /*加密密码*/
      $hashed_password = Hash::make($password);

      /*存入数据库*/
      $user = $this;
      $user->password = $hashed_password;
      $user->email = $email;
      $user->phone = $phone;
      $user->avatar = $avatar;
      $user->info = $info;
      $user->nickname = $nickname ?: '游客'.$uuid;
      if(!$user->save()){
        return err('db_save_fail');
      }

      return success(['id'=>$user->id]);

    }

    //登录
    public function login(){
      $username = rq('username');
      $password = rq('password');
      if (!$username || !$password)
        return err(' username or password is required');
      $user_email = $this->where('email',$username)->first();
      $user_phone = $this->where('phone',$username)->first();

      if (!$user_email && !$user_phone){
        return err('user is not exists');
      }
      if ($user_phone)
        $user = $user_phone;
      if ($user_email)
        $user = $user_email;
      $hashed_password = $user->password;
      if (!Hash::check($password,$hashed_password)){
        return err('密码有误');
      }
      session()->put('username',$user->nickname);
      session()->put('user_id',$user->id);
      return success(['id'=>session('user_id'),'nickname'=>session('username')]);
    }

  //  登出
    public function logout(){
  //    session()->flush();
  //    session()->put('username',null);
  //    session()->put('user_id',null);
      session()->forget('username');
      session()->forget('user_id');
  //    return success();
      return redirect('/');
    }



  //制作验证码
  public function validateCode(){
    $validateCode = new ValidateCode;
    session()->put('validate_code', $validateCode->getCode());
    return $validateCode->doimg();
  }
  public function check_validateCode(){
    $validateCode = rq('validateCode');
    if (!$validateCode)
      return err('validateCode is required');
    if ($validateCode != session()->get('validate_code') )
      return err('validate_code not right');

    return success();
  }

  //手机发送验证码
  public function sendSms(){
    $phone = rq('username');
    $code = '';
    $charset = '1234567890';
    $_len = strlen($charset) - 1;
    for ($i = 0;$i < 6;++$i) {
      $code .= $charset[mt_rand(0, $_len)];
    }
    $sms = new Sms(array('api_key' => '99ebc75be305718b0e66c5a37ce6f1fc' , 'use_ssl' => FALSE ));
    $res = $sms->send( $phone, '验证码:'.$code.'【动漫说】');

    if (isset( $res['error'] ) &&  $res['error'] == 0)
      session()->put('phone_code',$code);
    else
      return err($res['error']);
  }
}
