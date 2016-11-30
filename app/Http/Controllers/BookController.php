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
    $take = rq('limit') ?: 5;
    $page = rq('page') ?: 1;
    $tag = rq('tag');
    $maxtake = 15 * $page;
    if ($little_page * $take > $maxtake)
      return err(['pagedata is done']);

    $data = (object)array();

    $book_data = book_ins()->where('tag','like','%'.rq('tag').'%')->skip(($little_page-1)*$take)->limit($take)->get();
    $book_count = book_ins()->where('tag','like','%'.rq('tag').'%')->skip(($little_page-1)*$take)->limit($take)->count();


    $data->book = $book_data;
    $data->count = $book_count;
//    $book_page = book_ins()->paginate(30);
//    $data->book_page = $book_page;
    return ['status'=>1,'data'=>$data];

  }


}
