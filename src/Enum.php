<?php
/**
 * Part of twLib
 * http://www.thomaswhiston.com
 */

/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 12/12/2015
 * Time: 00:47
 *
 *   abstract class DaysOfWeek extends twLib\Enum {
 *     const Sunday = 0;
 *     const Monday = 1;
 *     const Tuesday = 2;
 *     const Wednesday = 3;
 *     const Thursday = 4;
 *     const Friday = 5;
 *     const Saturday = 6;
 *   }
 */

namespace twhiston\twLib;

abstract class Enum {

  private static $constCacheArray = NULL;

  /**
   * Enum constructor.
   * Private to prevent instantiation
   */
  private function __construct(){}

  /**
   * @return mixed
   */
  private static function getConstants() {
    if (self::$constCacheArray == NULL) {
      self::$constCacheArray = [];
    }
    $calledClass = get_called_class();
    if (!array_key_exists($calledClass, self::$constCacheArray)) {
      $reflect = new \ReflectionClass($calledClass);
      self::$constCacheArray[$calledClass] = $reflect->getConstants();
    }
    return self::$constCacheArray[$calledClass];
  }

  /**
   * @param $name
   * @param bool|FALSE $strict
   * @return bool
   */
  public static function isValidName($name, $strict = false) {
    $constants = self::getConstants();

    if ($strict) {
      return array_key_exists($name, $constants);
    }

    $keys = array_map('strtolower', array_keys($constants));
    return in_array(strtolower($name), $keys);
  }

  /**
   * @param $value
   * @return bool
   */
  public static function isValidValue($value) {
    $values = array_values(self::getConstants());
    return in_array($value, $values, $strict = true);
  }

  /**
   * @param $value
   * @return mixed
   */
  public static function getName($value){
    return array_search($value, self::getConstants());
  }
}


