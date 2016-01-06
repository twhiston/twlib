<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 05/01/2016
 * Time: 18:07
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Enum;

  abstract class DaysOfWeek extends Enum {
     const Sunday = 0;
     const Monday = 1;
     const Tuesday = 2;
     const Wednesday = 3;
     const Thursday = 4;
     const Friday = 5;
     const Saturday = 6;
  }


class EnumTest extends \PHPUnit_Framework_TestCase {

  public function testIsValidName(){

    $this->assertTrue(DaysOfWeek::isValidName('Sunday'));
    $this->assertTrue(DaysOfWeek::isValidName('Thursday'));
    $this->assertFalse(DaysOfWeek::isValidName('Blorpday'));
    $this->assertFalse(DaysOfWeek::isValidName('ssh8s8a9a9hs8m8saaaml,el'));

  }

  public function testIsValidValue(){

    $this->assertTrue(DaysOfWeek::isValidValue(0));
    $this->assertTrue(DaysOfWeek::isValidValue(6));
    $this->assertTrue(DaysOfWeek::isValidValue(DaysOfWeek::Wednesday));

    $this->assertFalse(DaysOfWeek::isValidValue('Wednesday'));
    $this->assertFalse(DaysOfWeek::isValidValue(7));
    $this->assertFalse(DaysOfWeek::isValidValue('Blorp'));
    $this->assertFalse(DaysOfWeek::isValidValue('ssh8s8a9a9hs8m8saaaml,el'));

  }

  public function testGetName(){

    $this->assertEquals('Monday',DaysOfWeek::getName(1));
    $this->assertEquals('Thursday',DaysOfWeek::getName(4));
    $this->assertEquals('Friday',DaysOfWeek::getName(DaysOfWeek::Friday));

  }

}
