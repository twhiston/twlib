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
 */

namespace twhiston\twLib\Enum;

/**
 * Class Enum
 *  PHP Enum implementation
 *   abstract class DaysOfWeek extends twLib\Enum {
 *     const Sunday = 0;
 *     const Monday = 1;
 *     const Tuesday = 2;
 *     const Wednesday = 3;
 *     const Thursday = 4;
 *     const Friday = 5;
 *     const Saturday = 6;
 *   }
 * @package twhiston\twLib
 */
abstract class Enum {

  /**
   * Class constants from reflection
   * @var null
   */
  private static $constCacheArray = NULL;

  /**
   * Enum constructor.
   * Private to prevent instantiation
   */
  private function __construct() {
  }

  /**
   * get internal functions
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
   * Is this name valid?, accepts string
   * @param $name string
   * @param bool|FALSE $strict
   * @return bool
   */
  public static function isValidName($name, $strict = FALSE) {
    $constants = self::getConstants();

    if ($strict) {
      return array_key_exists($name, $constants);
    }

    $keys = array_map('strtolower', array_keys($constants));
    return in_array(strtolower($name), $keys);
  }

  /**
   * Is the value valid for our enum, accepts int
   * @param $value
   * @return bool
   */
  public static function isValidValue($value) {
    $values = array_values(self::getConstants());
    return in_array($value, $values, $strict = TRUE);
  }

  /**
   * Get the enum member name as a string from the value
   * @param $value
   * @return mixed
   */
  public static function getName($value) {
    return array_search($value, self::getConstants());
  }
}


