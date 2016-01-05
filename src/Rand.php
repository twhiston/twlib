<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 04/01/2016
 * Time: 23:04
 */

namespace twhiston\twLib;

use twhiston\twLib\TwLibException;


class Rand {

  /**
   * Get a random int between min and max according to best practices
   * @param $min
   * @param $max
   * @return int|null
   */
  static public function Int($min, $max){

    //Ensure order correctness
    if($min > $max){
      $temp = $max;
      $max = $min;
      $min = $temp;
    }
    $rand = null;
    if(phpversion() >= 7){
      //random_int is php7 only
      try{
        $rand = \random_int ( $min , $max );
      } catch (\Exception $e){
        $rand = \mt_rand ( $min , $max );
      }
    } else {
      $rand = \mt_rand ( $min , $max );
    }

    if($rand === NULL){
      //We must not be NULL here, we could be 0, but if we are NULL then something went wrong with generation
      //Therefore throw
      throw new TwLibException('Rand could not be generated');
    }

    return $rand;
  }

}