<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  /**
   * 添加评论
   */
  public function add(){
    if (!is_logged_in())
      return err('login is required');

    if (!rq('content'))
      return err('empty content');

    if (
      (!rq('video_id') && !rq('book_id') && !rq('tea_id') && !rq('res_id') ) || //none
      (rq('video_id') && rq('book_id') && rq('tea_id') && rq('res_id')) // all
    )
      return err('tea_id or or res_id or video_id or book_id is required');

    if (rq('video_id')){
      $video = video_ins()->find(rq('video_id'));
      if (!$video) return err('video_id is not exists');
      $this->video_id = rq('video_id');
    }else if (rq('book_id')){
      $book = book_ins()->find(rq('book_id'));
      if (!$book) return err('book_id is not exists');
      $this->book_id = rq('book_id');
    }else if (rq('tea_id')){
      $tea = tea_ins()->find(rq('tea_id'));
      if (!$tea) return err('tea_id is not exists');
      $this->tea_id = rq('tea_id');
    }else{
      $res = res_ins()->find(rq('res_id'));
      if (!$res) return err('resource is not exists');
      $this->res_id = rq('res_id');
    }

    if (rq('reply_to')){
      $target = $this->find(rq('reply_to'));
      if (!$target) return err('target comment is not exists');

      if ($target->user_id == session('user_id'))
        return err('cannot reply to yourSelf');
      $this->reply_to = rq('reply_to');
    }

    $this->content = rq('content');
    $this->user_id=session('user_id');

    return $this->save() ? ['status' => 1,'id'=>$this->id]
      : ['status' => 0,'db_insert_failed'];

  }

  /**
   * 查看评论
   */
  public function read(){

    if (!rq('video_id') && !rq('book_id') && !rq('tea_id') && !rq('res_id'))
      return err('tea_id or or tea_id or video_id or book_id is required');

    if (rq('video_id')){
      $video = video_ins()->find(rq('video_id'));
      if (!$video) return err('video is not exists');
      $data = $this->where('video_id',rq('video_id'))->with('user')->get();
    }else if (rq('book_id')){
      $book = book_ins()->find(rq('book_id'));
      if (!$book) return err('book is not exists');
      $data = $this->where('book_id',rq('book_id'))->with('user')->get();
    }else if (rq('tea_id')){
      $tea = tea_ins()->find(rq('tea_id'));
      if (!$tea) return err('tea is not exists');
      $data = $this->where('tea_id',rq('tea_id'))->with('user')->get();
    }else{
      $res = res_ins()->find(rq('res_id'));
      if (!$res) return err('res is not exists');
      $data = $this->where('res_id',rq('res_id'))->with('user')->get();
    }

    if (!$data->first())
      return err('comment is not exists');
    return success(['data'=>$data->keyBy('id')]);
  }

  //    删除api
  public function remove(){
    if (!is_logged_in())
      return err('login required');

    if (!rq('id'))
      return err('id is required');

    $comment = $this->find(rq('id'));
    if (!$comment) return err('comment no exists');

    if ($comment->user_id != session('user_id'))
      return err('permission denied');

    $this->where('reply_to',rq('id'))->delete();

    return $comment->delete() ? ['status' => 1]
      : ['status' => 0,'db_delete_failed'];
  }

  /**
   * 关联user表
   */
  public function user(){
    return $this->belongsTo('App\User');
  }
}
