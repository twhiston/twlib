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

namespace twhiston\twLib;

class Arr {

  /**
   * convenience function to see if an array definately has a key in an efficient way
   * @param $arr
   * @param $key
   * @return bool
   */
  static public function hasKey(&$arr,$key){

    if (isset($arr[$key]) || array_key_exists($key, $arr)) {
        return true;
    }
    return false;
  }


  /**
   * Convenience function to get the last part of a key from an array by a division character
   * With this functions an array of ['node_edit_form' = 'whatever', 'user_edit_form' = new stdClass ]
   * would return an array of ['form','form']
   * @param $arr
   * @param $division
   * @return array
   */
  static public function getKeysByLastDivision(&$arr,$division){

    $return = array();
    foreach ($arr as $key => $value) {
      if (($pos = strrpos($key, $division)) !== FALSE) {
        $return[] = substr($key, $pos+1);
      } else {
        //TODO if the key does not exist then do something?
      }
    }
    return $return;
  }

  /**
   * Convenience function to get the first part of a key from an array by a division character
   * With this functions an array of ['node_edit_form' = 'whatever', 'user_edit_form' = new stdClass ]
   * would return an array of ['node','user']
   * @param $arr
   * @param $division
   * @return array
   */
  static public function getKeysByFirstDivision(&$arr,$division){

    $return = array();
    foreach ($arr as $key => $value) {
      if (($pos = strpos($key, $division)) !== FALSE) {
        $return[] = substr($key, 0,$pos);
      } else {
        //TODO if the key does not exist then do something?
      }
    }
    return $return;

  }


}

