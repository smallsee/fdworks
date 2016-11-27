<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Tool\Validate\ValidateCode;
use App\Tool\M3Email;
use App\Tool\SMS\Sms;
use Mail;
use Hash;
use Validator;

class Video extends Authenticatable
{

  /**
   * 添加模块
   */
    public function add(){
      $title=rq('title');
      $content = rq('content');
      $tag = rq('tag');
      $thumb = rq('thumb');
      $video_url = rq('video_url');
      $all = rq();

      if (!is_logged_in())
        return ['status'=>0,'msg' => 'login required'];

      $rules = array(
        'title'  => 'required',
        'content'  => 'required',
        'thumb'  => 'required',
        'tag'  => 'required',
        'video_url'  => 'required',
      );
      $messages = [
        'title.numeric'  => 'title must be number'

      ];
      $validation = Validator::make($all, $rules,$messages);

      if ($validation->fails())
      {
        return err($validation->errors()->all());
      }


      if( is_array( $tag ) ){
        $tabs  = '';
        foreach ($tag as $img){
          $tabs.=$img.',';
        }
        $tag = rtrim($tabs, ',');
      }


      $this->title = $title;
      $this->content = $content;
      $this->tag = $tag;
      $this->thumb = $thumb;
      $this->video_url = $video_url;
      $this->user_id = session()->get('user_id');
      return $this->save() ? success(['id'=>$this->id])
        : err('db_insert_failed');

    }

  /**
   *  更新模块
   */
    public function change(){
      if (!is_logged_in())
        return ['status'=>0,'msg' => 'login required'];

      if (!rq('id'))
        return ['status'=>0,'msg' => 'id is required'];

        $video = $this->find(rq('id'));

      if ($video->user_id != session('user_id'))
        return ['status'=>0,'msg' => 'permission denied'];

      if (rq('title'))
        $video->title = rq('title');
      if (rq('content'))
        $video->content = rq('content');
      if (rq('tag'))
        $video->tag = rq('tag');
      if (rq('video_url'))
        $video->video_url = rq('video_url');
      if (rq('thumb'))
        $video->thumb = rq('thumb');

      return $video->save() ? success() : err('db_update_failed');
    }

  /**
   * 观看模块
   */
    public function read(){

      if (rq('id'))
        return ['status'=>1,'data'=>$this->with('user')->find(rq('id'))];


      $limit = rq('limit') ?: 15;
      $skip = ((rq('page') ?: 1) -1)* $limit;

      if (rq('tag')){
        $video_tag = $this->where('tag','like','%'.rq('tag').'%')
                      ->with('user')
                      ->limit($limit)
                      ->skip($skip)
                      ->get()
                      ->keyBy('id');
        if (!$video_tag->first())
          return err('video no exists');
        return success(['data'=>$video_tag]);
      }



      $r = $this->orderBy('created_at')
        ->with('user')
        ->limit($limit)
        ->skip($skip)
        ->get()
        ->keyBy('id');

      return ['status' => 1,'data'=>$r];
    }


  /**
   * 删除模块
   */
  public function remove(){

    if (!is_logged_in())
      return err('login required');

    if (!rq('id'))
      return err('id is required');

    $video = $this->find(rq('id'));
    if (!$video) return err('video no exists');

    if ($video->user_id != session('user_id'))
      return err('permission denied');

    return $video->delete() ? success()
      : err('db_delete_failed');

  }

  /**
   * 关联user表
   */
    public function user(){
      return $this->belongsTo('App\User');
    }

}
