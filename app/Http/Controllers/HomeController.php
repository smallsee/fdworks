<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tool\UUID;

class HomeController extends Controller
{
  /**
   * 显示数据
   */
  public function data(){

    $data = (object)array();

    //本子
    $book = (object)array();
    $book_big = book_ins()
      ->orderBy('created_at','desc')
      ->skip(0)
      ->take(3)
      ->get();
    $book_small = book_ins()
      ->orderBy('created_at','desc')
      ->skip(3)
      ->take(6)
      ->get();
    $book->big = $book_big;
    $book->small = $book_small;
    $data->book=$book;

    //视频
    $video = video_ins()
      ->orderBy('created_at','desc')
      ->skip(0)
      ->take(5)
      ->get();

    $data->video=$video;

    //茶会聊天
    $tea = tea_ins()
      ->orderBy('created_at','desc')
      ->skip(0)
      ->take(5)
      ->get();

    $data->tea=$tea;

    //资源帖子
    $res = res_ins()
      ->orderBy('created_at','desc')
      ->skip(0)
      ->take(5)
      ->get();
    $data->res=$res;

    //资源帖子
    $fam = fam_ins()
      ->with('user')
      ->skip(0)
      ->take(5)
      ->get();
    $data->fam=$fam;
    return ['status'=>1,'data'=>$data];

  }


}
