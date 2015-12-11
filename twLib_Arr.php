<?php
/**
 * Part of twLib
 * http://www.thomaswhiston.com
 */

/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 12/12/2015
 * Time: 00:15
 */

namespace twLib;

class Arr {

  static public function hasKey(&$arr,$key){

    if (isset($arr[$key]) || array_key_exists($key, $arr)) {
        return true;
    }
    return false;
  }


}

