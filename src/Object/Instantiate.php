<?php

namespace twhiston\twLib\Object;

/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 27/01/2016
 * Time: 14:14
 */


/**
 * Class Instantiate
 * Create a class
 * @package twhiston\twLib\Object
 */
class Instantiate
{

    /**
     * @param $class
     * @param $args
     * @param $namespace string psr-4 style 'whatever\\thing\\another\\'
     *
     * @return null
     */
    public static function make($class, $args, $namespace, $interface = null)
    {

        $count = substr_count($class, '\\');
        if ($count = 0 || !(0 === strpos($class, 'Drupal'))) {
            //if there is no '/' we assume this is not a fully qualified namespace and make it our root Constraint namespace
            //If there is no drupal at the start then we assume its our class further down the tree
            $class = $namespace.$class;
        }

        try {
            $imp = class_implements($class, true);
            if (!is_array($imp)) {
                return null;
            }

            if ($interface !== null) {
                if (!in_array($interface, $imp)) {
                    return null;
                }
            }
            //Make sure args are an array
            $args = (!is_array($args) && $args != null) ? array($args) : $args;
            $instance = Instantiate::instantiate($class, $args);

        } catch (\Exception $e) {
            return null;
        }

        return $instance;
    }

    /**
     * @param $class
     * @param $args
     * @return object
     */
    private static function instantiate($class, $args)
    {

        if (version_compare(phpversion(), '5.6.0', '>=')) {
            $instance = new $class(...$args);
        } else {
            $reflect = new \ReflectionClass($class);
            $instance = ($args === null || $args === false) ? $reflect->newInstanceArgs(
            ) : $reflect->newInstanceArgs($args);
        }

        return $instance;
    }

}