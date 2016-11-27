<?php

function create_code(){
  return App\Tool\UUID::create();

}
function user_ins(){
  return  new App\User;
};
function video_ins(){
  return  new App\Video;
};
function book_ins(){
  return  new App\Book;
};
function comment_ins(){
  return  new App\Comment;
};
function rq($key=null,$default=null){
  if (!$key) return Request::all();

  return Request::get($key,$default);
};
function is_logged_in(){
  return session('user_id') ?: false;
}
function err($msg=null){
  return ['status'=>0,'msg'=>$msg];
}

function success($data_to_add=[]){

  $data = ['status'=>1,'data'=>[]];
  if ($data_to_add)
    $data['data'] = $data_to_add;

  return $data;
}


Route::group(['middleware' => ['web']], function () {

  /*用户api*/
  Route::any('api/signup',function(){
    return user_ins()->signUp();
  });
  Route::any('api/login',function(){
    return user_ins()->login();
  });
  Route::any('api/logout',function(){
    return user_ins()->logout();
  });
  Route::any('api/user/exists',function(){
    return user_ins()->check_phone_or_email_is_exists(rq('username'));
  });
  Route::any('api/validateCode',function(){
    return user_ins()->validateCode();
  });
  Route::any('api/validateCode/exists',function(){
    return user_ins()->check_validateCode();
  });

  //视频api
  Route::any('api/video/add',function(){
    return video_ins()->add();
  });
  Route::any('api/video/change',function(){
    return video_ins()->change();
  });
  Route::any('api/video/read',function(){
    return video_ins()->read();
  });
  Route::any('api/video/remove',function(){
    return video_ins()->remove();
  });

  //本子api
  Route::any('api/book/add',function(){
    return book_ins()->add();
  });
  Route::any('api/book/change',function(){
    return book_ins()->change();
  });
  Route::any('api/book/read',function(){
    return book_ins()->read();
  });
  Route::any('api/book/remove',function(){
    return book_ins()->remove();
  });

  //评论
  Route::any('api/comment/add',function(){
    return comment_ins()->add();
  });
  Route::any('api/comment/change',function(){
    return comment_ins()->change();
  });
  Route::any('api/comment/read',function(){
    return comment_ins()->read();
  });


  /**
   * 主页
   */
  Route::get('/', function () {
    return view('index');
  });
  Route::get('tpl/page/home',function(){
    return view('page.home');
  });
  Route::get('tpl/page/login',function(){
    return view('page.login');
  });
  Route::get('tpl/page/signup',function(){
    return view('page.signup');
  });

  /**
   * 视频
   */
  Route::get('tpl/page/video',function(){
    return view('page.video');
  });
  Route::get('tpl/page/video/add',function(){
    return view('page.video_add');
  });

  /**
   * 本子
   */
  Route::get('tpl/page/book',function(){
    return view('page.book');
  });
  Route::get('tpl/page/book/add',function(){
    return view('page.book_add');
  });


  /**
   * 公用上传七牛图片类
   */
  Route::any('api/upload/image','CommonController@image');
});
