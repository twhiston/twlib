<?php
/**
 * Part of twLib
 * http://www.thomaswhiston.com
 */

/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 11/12/2015
 * Time: 23:39
 * Part of twLib
 * http://www.thomaswhiston.com
 */

namespace twhiston\twLib;

class Str {

  /**
   * @param $haystack
   * @param $needles
   * @return bool
   */
  static public function startsWith($haystack, $needles)
  {
    if(is_array($needles)){
      foreach ((array) $needles as $needle)
      {
        if ($needle != '' && strpos($haystack, $needle) === 0) return $needle;
      }
    } else {
        if ($needles != '' && strpos($haystack, $needles) === 0) return TRUE;
    }
    return false;
  }

  /**
   * @param $haystack
   * @param $needles
   * @return bool
   */
  static public function endsWith($haystack, $needles) {
    if(is_array($needles)){
      foreach ((array) $needles as $needle)
      {
        if (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE) return $needle;
      }
    } else {
      if (($temp = strlen($haystack) - strlen($needles)) >= 0 && strpos($haystack, $needles, $temp) !== FALSE) return true;
    }
    return FALSE;
  }

  /**
   * Does the haystack contain needles? If array in will return array out or false
   * @param $haystack
   * @param $needles
   * @return array|bool
   */
  static public function contains($haystack, $needles){

    if(is_array($needles)){
      $results = array();
      foreach ((array) $needles as $needle)
      {
        if (strpos($haystack, $needle) !== FALSE) $results[] =  $needle;
      }
      if(empty($results)) return false;
      return $results;
    } else {
      if (strpos($haystack, $needles) !== FALSE) return TRUE;
    }
    return FALSE;

  }


};

