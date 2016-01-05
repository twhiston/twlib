<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 05/01/2016
 * Time: 18:14
 */

namespace twhiston\twLib\tests;


use twhiston\twLib\Rand;

class RandTest extends \PHPUnit_Framework_TestCase {

  function get_int_max()
  {
    $max=0x7fff;
    $probe = 0x7fffffff;
    while ($max == ($probe>>16))
    {
      $max = $probe;
      $probe = ($probe << 16) + 0xffff;
    }
    return $max;
  }

  public function testRandInt(){

    $rando = Rand::Int(0, 100);
    $this->assertNotNull($rando);
    $this->assertLessThanOrEqual(100,$rando);
    $this->assertGreaterThanOrEqual(0,$rando);

    $rando = Rand::Int(-1000,-12);
    $this->assertNotNull($rando);
    $this->assertLessThanOrEqual(-12,$rando);
    $this->assertGreaterThanOrEqual(-1000,$rando);


    $rando = Rand::Int(-12,-1000);
    $this->assertNotNull($rando);
    $this->assertLessThanOrEqual(-12,$rando);
    $this->assertGreaterThanOrEqual(-1000,$rando);

    $max = $this->get_int_max();
    $min = (-1 * $max ) - 1;

    $rando = Rand::Int($min,$max);
    $this->assertNotNull($rando);
    $this->assertLessThanOrEqual($max,$rando);
    $this->assertGreaterThanOrEqual($min,$rando);

  }

}
