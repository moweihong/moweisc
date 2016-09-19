<?php

/*
 * Ajax or App json参数返回模板
 * @return Json
 * */

namespace App\Mspecs;

class M3Result {

  public $status;
  public $message;
  public $data;

  public function toJson()
  {
    return json_encode($this, JSON_UNESCAPED_UNICODE);
  }

}
