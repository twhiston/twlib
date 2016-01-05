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

    //Ensure order correctness
    if($min > $max){
      $temp = $max;
      $max = $min;
      $min = $temp;
    }

    $rand = null;
    if(phpversion() >= 7){
      try{
        $rand = \random_int ( $min , $max );
      } catch (\Exception $e){
        $rand = \mt_rand ( $min , $max );
      }
    } else {
      $rand = \mt_rand ( $min , $max );
    }

    return $rand;
  }

}