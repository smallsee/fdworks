<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Validator;

class Family extends Authenticatable
{


  /**
   * 关联user表
   */
  public function user(){
    return $this->belongsTo('App\User');
  }

}
