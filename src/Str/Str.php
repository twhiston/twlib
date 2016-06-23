<?php
/**
 * Part of twLib
 * http://www.thomaswhiston.com
 * tom.whiston@gmail.com
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 11/12/2015
 * Time: 23:39
 * Part of twLib
 * http://www.thomaswhiston.com
 */
namespace twhiston\twLib\Str;

/**
 * Class Str
 * String helper functions
 * @package twhiston\twLib
 */
class Str
{

    /**
     * Does the string start with?
     * @param $haystack
     * @param $needles
     * @return bool|string if an array is passed in the matching string will be returned, else true/false
     */
    static public function startsWith($haystack, $needles)
    {
        if($haystack === null){
            return false;
        }
        if (is_array($needles)) {
            foreach ((array)$needles as $needle) {
                if ($needle != '' && strpos($haystack, $needle) === 0) {
                    return $needle;
                }
            }
        } else {
            if ($needles != '' && strpos($haystack, $needles) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Does the string end with?
     * @param $haystack
     * @param $needles
     * @return array|bool if an array is passed in the matching string will be returned, else true/false
     */
    static public function endsWith($haystack, $needles)
    {
        if($haystack === null){
            return false;
        }
        if (is_array($needles)) {
            foreach ((array)$needles as $needle) {
                if (($temp = strlen($haystack) - strlen(
                      $needle
                    )) >= 0 && strpos(
                    $haystack,
                    $needle,
                    $temp
                  ) !== false
                ) {
                    return $needle;
                }
            }
        } else {
            if (($temp = strlen($haystack) - strlen($needles)) >= 0 && strpos(
                $haystack,
                $needles,
                $temp
              ) !== false
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Does the haystack contain needles? If array in will return array out or false
     * @param $haystack
     * @param $needles
     * @return array|bool if an array is passed in the matching string will be returned, else true/false
     */
    static public function contains($haystack, $needles)
    {
        if($haystack === null){
            return false;
        }
        if (is_array($needles)) {
            $results = array();
            foreach ((array)$needles as $needle) {
                if (strpos($haystack, $needle) !== false) {
                    $results[] = $needle;
                }
            }
            if (empty($results)) {
                return false;
            }

            return $results;
        } else {
            if (strpos($haystack, $needles) !== false) {
                return true;
            }
        }

        return false;

    }

    /**
     * Get part of a string before a phrase or array of phrases. Returns an array of results keyed by phrase
     * Making recursive true makes this work like tokenizing the string
     * You can preserve the phrase by marking the variable true
     * output array is in the form of
     * $data[$phrase][$index] where index is a numeric value
     * @param $string
     * @param $phrase string|[string]
     * @return array
     */
    static public function getBefore($string, $phrase)
    {

        if (!is_array($phrase)) {
            $phrase = [$phrase];
        }

        $output = [];
        foreach ($phrase as $item) {
            $e = explode($item, $string);
            array_pop($e);//remove the rest of string entry
            $output[$item] = $e;
        }

        return $output;

    }

    /**
     * Get part of a string after a phrase or array of phrases. Returns an array of results keyed by phrase
     * If no instances of the key were found returns false
     * The last member of the array will be blank if the token is the last thing in the string
     * @param $string
     * @param $phrase string|[string]
     * @return array
     */
    static public function getAfter($string, $phrase)
    {

        if (!is_array($phrase)) {
            $phrase = [$phrase];
        }

        $output = [];
        foreach ($phrase as $item) {
            $e = explode($item, $string);
            array_shift($e);//remove the first item always
            $output[$item] = $e;
        }

        return $output;
    }

}