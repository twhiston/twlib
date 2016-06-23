<?php
/**
 * Part of twLib
 * http://www.thomaswhiston.com
 * tom.whiston@gmail.com
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 04/01/2016
 * Time: 23:04
 */
namespace twhiston\twLib\Rand;

/**
 * Class Rand
 * Generate random ints within range or random string
 * Will always try to use php7 functions where possible, but if earlier only semi secure int generation is possible
 * @package twhiston\twLib
 * @deprecated use the symfony polyfill for real secure numbers
 */
class Rand
{


    /**
     * Generate random int or throws exception. NON SECURE
     * @param $min
     * @param $max
     * @return int|null
     * @throws \twhiston\twLib\TwLibException
     */
    static public function Int($min, $max)
    {

        //Ensure order correctness
        if ($min > $max) {
            $temp = $max;
            $max = $min;
            $min = $temp;
        }
        $rand = null;
        if (phpversion() >= 7) {
            //random_int is php7 only
            try {
                $rand = \random_int($min, $max);
            } catch (\Exception $e) {
                $rand = \mt_rand($min, $max);
            }
        } else {
            $rand = \mt_rand($min, $max);
        }

        if ($rand === null) {
            //We must not be NULL here, we could be 0, but if we are NULL then something went wrong with generation
            throw new TwLibException('Rand could not be generated');
        }

        return $rand;
    }

    /**
     * Manual secure int version based on http://stackoverflow.com/questions/1313223/replace-rand-with-openssl-random-pseudo-bytes SECURE-ish
     * @param $min
     * @param $max
     * @param bool|TRUE $pedantic
     * @return int|null
     * @throws \twhiston\twLib\TwLibException
     */
    static public function SecureInt($min, $max, $pedantic = true)
    {

        //Ensure order correctness
        if ($min > $max) {
            $temp = $max;
            $max = $min;
            $min = $temp;
        }
        $rand = null;
        $manual = true;
        if (phpversion() >= 7) {
            try {
                $rand = random_int($min, $max);
                $manual = false;
            } catch (\Exception $e) {
                $manual = true;
            }
        }

        if ($manual === true) {
            //http://stackoverflow.com/questions/1313223/replace-rand-with-openssl-random-pseudo-bytes
            $secure = false;
            $diff = $max - $min;
            if ($diff <= 0) {
                return $min;
            } // not so random...
            $range = $diff + 1; // because $max is inclusive
            $bits = ceil(log(($range), 2));
            $bytes = ceil($bits / 8.0);
            $bits_max = 1 << $bits;
            // e.g. if $range = 3000 (bin: 101110111000)
            //  +--------+--------+
            //  |....1011|10111000|
            //  +--------+--------+
            //  bits=12, bytes=2, bits_max=2^12=4096
            $num = 0;
            do {
                $num = hexdec(
                        bin2hex(openssl_random_pseudo_bytes($bytes, $secure))
                    ) % $bits_max;
                if ($secure === false) {
                    throw new TwLibException(
                        'Non secure value generated. This is a system issue'
                    );
                }
                if ($num >= $range) {
                    if ($pedantic) {
                        continue;
                    } // start over instead of accepting bias
                    // else
                    $num = $num % $range;  // to hell with security
                }
                break;
            } while (true);
            $rand = $num + $min;
        }
        if ($rand === null) {
            //We must not be NULL here, we could be 0, but if we are NULL then something went wrong with generation
            throw new TwLibException('Rand could not be generated');
        }

        return $rand;
    }

    /**
     * Generate a random string of length. SECURE
     * @param $length
     * @return null|string
     * @throws \twhiston\twLib\TwLibException if string is generated non securely or result is null
     */
    static public function String($length)
    {

        $string = null;
        $length /= 2;
        if (phpversion() >= 7) {
            $string = bin2hex(random_bytes($length));
        } else {
            $secure = false;
            $string = bin2hex(openssl_random_pseudo_bytes($length, $secure));
            if ($secure === false) {
                throw new TwLibException(
                    'Non secure string generated. This is a system issue'
                );
            }
        }

        if ($string === null) {
            throw new TwLibException('Random string is NULL, PANIC');
        }

        return $string;

    }

}