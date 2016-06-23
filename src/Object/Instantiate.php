<?php
/**
 * Part of twLib
 * http://www.thomaswhiston.com
 * tom.whiston@gmail.com
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 27/01/2016
 * Time: 14:14
 */
namespace twhiston\twLib\Object;

    /**
     * Class Instantiate
     * Create a class
     * @package twhiston\twLib\Object
     */
/**
 * Class Instantiate
 * @package twhiston\twLib\Object
 */
class Instantiate
{


    /**
     * @param $class
     * @param $args
     * @param $namespace string psr-4 style 'whatever\\thing\\another\\'
     * @param null $interface test that class implements this interface
     * @return object
     * @throws \Exception
     */
    public static function make($class, $args, $namespace = null, $interface = null)
    {

//        $count = substr_count($class, '\\');
//        if ($count = 0 || !(0 === strpos($class, 'Drupal'))) {
//            //if there is no '/' we assume this is not a fully qualified namespace and make it our root Constraint namespace
//            //If there is no drupal at the start then we assume its our class further down the tree
//            $class = $namespace.$class;
//        }

        if ($namespace !== null) {
            $class = $namespace . $class;
        }

        try {

            if (!class_exists($class, true)) {
                throw new \Exception('Class does not exist');
            }

            if ($interface !== null) {

                $imp = class_implements($class, true);
                if (!is_array($imp)) {
                    throw new \Exception('Does not implement an interface');
                }
                if (!in_array($interface, $imp)) {
                    throw new \Exception('Does not implement requested interface');
                }

            }
            //Make sure args are an array
            if ($args !== null && $args !== false) {
                $args = (!is_array($args)) ? array($args) : $args;
                if (is_array($args)) {
                    $c = count(array_filter(array_keys($args), 'is_string'));
                    if (count(array_filter(array_keys($args), 'is_string')) > 0) {
                        $args = [$args];
                    }
                }
            }

            $instance = Instantiate::instantiate($class, $args);

        } catch (\Exception $e) {
            throw $e;
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
//BOOOOO, this produces a parse error on less than 5.6.0
//        if (version_compare(phpversion(), '5.6.0') !== -1) {
//            $instance = new $class(...$args);
//        } else {
        $reflect = new \ReflectionClass($class);
        $instance = ($args === null || $args === false) ? $reflect->newInstanceArgs() : $reflect->newInstanceArgs($args);
//        }

        return $instance;
    }

}