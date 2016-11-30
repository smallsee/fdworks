<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tool\UUID;

class BookController extends Controller
{
  /**
   * 显示数据
   */
  public function data(){
    $little_page = rq('little_page') ?: 1;
    $take = rq('limit') ?: 10;
    $page = rq('page') ?: 1;
    $tag = rq('tag');
    $maxtake = 30 * $page;
    if ($little_page * $take > $maxtake)
      return err(['pagedata is done']);

    $data = (object)array();

    $book_data = book_ins()->with('user')->where('tag','like','%'.rq('tag').'%')->orderBy('created_at','desc')->skip(($little_page-1)*$take)->limit($take)->get();
    $book_count = book_ins()->where('tag','like','%'.rq('tag').'%')->count();


    $data->book = $book_data;
    $data->count = $book_count;

    return ['status'=>1,'data'=>$data];

  }


}
