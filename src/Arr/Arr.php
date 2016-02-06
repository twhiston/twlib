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

namespace twhiston\twLib\Arr;

use twhiston\twLib\Str\Str;

/**
 * Class Arr
 * Array helper functions, reKey arrays, filter arrays, get Keys for 2D Arrays
 * 3D arrays will only work on the top level
 * @package twhiston\twLib
 */
class Arr
{

    /**
     * convenience function to see if an array definately has a key in an efficient way
     * @param $arr
     * @param $key
     * @return bool
     */
    static public function hasKey(&$arr, $key)
    {

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
    static public function getKeysByLastDivision(&$arr, $division)
    {

        $return = array();
        foreach ($arr as $key => $value) {
            if (($pos = strrpos($key, $division)) !== false) {
                $return[] = substr($key, $pos + 1);
            }
        }

        return $return;
    }

    /**
     * Convenience function to get keys containing a string
     * @param $arr      array to test
     * @param $contains string to test for
     * @return array  members of $arr whos key contains $contains
     */
    static public function getKeyContains(&$arr, $contains)
    {
        $results = array();
        foreach ($arr as $key => $value) {
            if (($pos = strpos($key, $contains)) !== false) {
                $results[] = $key;
            }
        }

        return $results;
    }

    /**
     * Convenience function to get the first part of a key from an array by a division character
     * With this functions an array of ['node_edit_form' = 'whatever', 'user_edit_form' = new stdClass ]
     * would return an array of ['node','user']
     * @param $arr
     * @param $division
     * @return array
     */
    static public function getKeysByFirstDivision(&$arr, $division)
    {

        $return = array();
        foreach ($arr as $key => $value) {
            if (($pos = strpos($key, $division)) !== false) {
                $return[] = substr($key, 0, $pos);
            }
        }

        return $return;

    }

    /**
     * Convenience function to rekey an array by a division
     * With this functions an array of ['node_edit_form' = 'whatever', 'user_edit_form' = new stdClass ]
     * would return an array of ['form' = stdClass]
     * If your keys share a final part of their key they will get overwritten. Sucks to be you
     * @param $arr
     * @param $division
     * @return array
     */
    static public function reKeyByLastKeyDivision(&$arr, $division)
    {

        $return = array();
        foreach ($arr as $key => $value) {
            if (($pos = strrpos($key, $division)) !== false) {
                $return[substr($key, $pos + 1)] = $value;
            }
        }

        return $return;
    }

    /**
     * Convenience function to rekey an array by a division
     * With this functions an array of
     * ['node_edit_form' = 'whatever', 'user_edit_form' = new stdClass , 'nodelimiterhere' = 0]
     * with division '_'
     * would return an array of ['node' = 'whatever','user' = stdClass]
     * @param $arr
     * @param $division
     * @return array
     */
    static public function reKeyByFirstKeyDivision(&$arr, $division)
    {

        $return = array();
        foreach ($arr as $key => $value) {
            if (($pos = strpos($key, $division)) !== false) {
                $return[substr($key, 0, $pos)] = $value;
            }
        }

        return $return;

    }

    /**
     * Convenience function to filter arrays by their key containing a string
     * @param $arr      array to test
     * @param $contains string to test for
     * @return array  members of $arr whos key contains $contains
     */
    static public function filterKeyContains(&$arr, $contains)
    {
        $results = array();
        foreach ($arr as $key => $value) {
            if (($pos = strpos($key, $contains)) !== false) {
                $results[$key] = $value;
            }
        }

        return $results;
    }

    /**
     * Convenience function to filter arrays by their key !containing a string
     * @param $arr      array to test
     * @param $contains string to test for
     * @return array  members of $arr whos key !contains $contains
     */
    static public function filterKeyNotContains(&$arr, $contains)
    {
        $results = array();
        foreach ($arr as $key => $value) {
            if (($pos = strpos($key, $contains)) === false) {
                $results[$key] = $value;
            }
        }

        return $results;
    }

    /**
     * return an array of values filtered by the key starting with $startswith
     * @param $arr []
     * @param $startwith string
     * @return array
     */
    static public function filterKeyStartsWith(&$arr, $startwith)
    {
        $results = array();
        foreach ($arr as $key => $value) {
            if (Str::startsWith($key, $startwith) === true) {
                $results[$key] = $value;
            }
        }

        return $results;
    }

    /**
     * return an array of values filtered by the key ending with $endswith
     * @param $arr []
     * @param $endswith string
     * @return array
     */
    static public function filterKeyEndsWith(&$arr, $endswith)
    {
        $results = array();
        foreach ($arr as $key => $value) {
            if (Str::endsWith($key, $endswith) === true) {
                $results[$key] = $value;
            }
        }

        return $results;
    }


    /**
     * Filter an array by value
     * @param $arr
     * @param $value
     * @return array Array of entries that contain $value
     */
    static public function filterHasValue(&$arr, $value)
    {
        $results = array();

        //test what type the value is
        $type = gettype($value);
        foreach ($arr as $key => $val) {
            //we can only compare if the types match
            if (gettype($val) === $type) {
                if ($val == $value) {
                    $results[$key] = $val;
                }
            }
        }

        return $results;
    }

    /**
     * Filter an array by !value
     * @param $arr
     * @param $value
     * @return array Array of entries that do not contain $value
     */
    static public function filterHasNotValue(&$arr, $value)
    {
        $results = array();

        //test what type the value is
        $type = gettype($value);
        foreach ($arr as $key => $val) {
            //we can only compare if the types match
            if (gettype($val) === $type) {
                if ($val !== $value) {
                    $results[$key] = $val;
                }
            }
        }

        return $results;
    }

    /**
     * Filter by a type, takes internal type or fully qualified class name
     * @param $arr
     * @param $type
     * @return array Array of entries that are of $type
     */
    static public function filterByType(&$arr, $type)
    {
        $results = array();

        if (!is_string($type)) {
            $type = gettype($type);
        }

        foreach ($arr as $key => $val) {
            //do types match

            if (is_object($val)) {
                $t = get_class($val);
            } else {
                $t = gettype($val);
            }
            if ($t === $type) {
                $results[$key] = $val;
            }
        }

        return $results;
    }

}