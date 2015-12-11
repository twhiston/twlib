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

namespace twLib;

class Str {

  /**
   * @param $haystack
   * @param $needles
   * @return bool
   */
  static public function startsWith($haystack, $needles)
  {
    foreach ((array) $needles as $needle)
    {
      if ($needle != '' && strpos($haystack, $needle) === 0) return true;
    }
    return false;
  }


};

