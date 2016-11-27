<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tool\UUID;

include app_path().'/Tool/Qiniu/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
class CommonController extends Controller
{
  /**
   * 上传图片
   */
    public function image(){
      $image = $_FILES['imgFile'];

      // 需要填写你的 Access Key 和 Secret Key
      $accessKey = '-xpzbXEV0gDocV0_SsQFn-WYczH9kPQr27wtYQ_2';
      $secretKey = 'Lpynlw9BBhexmODsMV0a4-v-Kzp6zm_njdXaTUxJ';

      // 构建鉴权对象
      $auth = new Auth($accessKey, $secretKey);
      $bucket = 'fd-book';
      $filePath = $image['tmp_name'];

      $uploadMgr = new UploadManager();
      $key = UUID::create();
      $token = $auth->uploadToken($bucket);

      list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
      if ($err !== null) {
        return ['status'=>0,'msg'=>$err];
      }

      $thumb = ('http://ohadc19qz.bkt.clouddn.com/'.$ret['key']);

      return json_encode(['error'=>0,'url'=>$thumb]);


    }

}
