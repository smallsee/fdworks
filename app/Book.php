<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Validator;

class Book extends Authenticatable
{

  /**
   * 添加模块
   */
  public function add(){
    $title=rq('title');
    $content = rq('content');
    $tag = rq('tag');
    $thumb = rq('thumb');
    $book_lists = rq('book_lists');
    $all = rq();

    if (!is_logged_in())
      return ['status'=>0,'msg' => 'login required'];

    $rules = array(
      'title'  => 'required',
      'content'  => 'required',
      'thumb'  => 'required',
      'tag'  => 'required',
      'book_lists'  => 'required',
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
    $this->book_lists = $book_lists;
    $this->user_id = session()->get('user_id');
    return $this->save() ? success(['id'=>$this->id])
      : err('db_insert_failed');

  }

  /**
   *  更新模块
   */
  public function change(){
    if (!is_logged_in())
      return err('login is required');

    if (!rq('id'))
      return err('id is required');

    $book = $this->find(rq('id'));

    if ($book->user_id != session('user_id'))
      return err('permission denied');

    if (rq('title'))
      $book->title = rq('title');
    if (rq('content'))
      $book->content = rq('content');
    if (rq('tag'))
      $book->content = rq('tag');
    if (rq('book_lists'))
      $book->content = rq('book_lists');
    if (rq('thumb'))
      $book->thumb = rq('thumb');

    return $book->save() ? success() : err('db_update_failed');
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
      $book_tag = $this->where('tag','like','%'.rq('tag').'%')
        ->with('user')
        ->limit($limit)
        ->skip($skip)
        ->get()
        ->keyBy('id');
      if (!$book_tag->first())
        return err('video no exists');
      return success(['data'=>$book_tag]);
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

    $book = $this->find(rq('id'));
    if (!$book) return err('video no exists');

    if ($book->user_id != session('user_id'))
      return err('permission denied');

    return $book->delete() ? success()
      : err('db_delete_failed');

  }

  /**
   * 关联user表
   */
  public function user(){
    return $this->belongsTo('App\User');
  }

}
