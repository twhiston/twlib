<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 04/01/2016
 * Time: 23:04
 */

namespace twhiston\twLib;


class Rand {

  static public function Int($min, $max){

    $rand = null;
    try{
      $rand = random_int ( $min , $max );
    } catch (\Exception $e){
      $rand = mt_rand ( $min , $max );
    }
    return $rand;
  }

}