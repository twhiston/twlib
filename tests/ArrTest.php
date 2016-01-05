<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 05/01/2016
 * Time: 15:41
 */

//namespace twhiston\twLib\tests;

use twhiston\twLib\Arr;

class ArrTest extends \PHPUnit_Framework_TestCase {

  public $testArr;

  public $testArr2;

  public function __construct() {
     parent::__construct();
    $this->testArr = [
      'this_is_a_drupal_naming_convention' => 'whatever',
      'node_form_type_edit' => 0,
      'entity_something' => new \stdClass(),
    ];

    $this->testArr2 = [
      'this&is&a&drupal&naming&convention' => 'whatever',
      'node&form&type&edit' => 0,
      'entity&something' => new \stdClass(),
    ];
  }

  public function testHasKey(){

    $this->assertTrue(Arr::hasKey($this->testArr,'this_is_a_drupal_naming_convention'));
    $this->assertFalse(Arr::hasKey($this->testArr,'you_talkin_to_me'));

    $this->assertTrue(Arr::hasKey($this->testArr2,'node&form&type&edit'));
    $this->assertFalse(Arr::hasKey($this->testArr2,'you_talkin_u2_to_me?'));
  }

  public function testGetKeysByLastDivision(){

    $result = Arr::getKeysByLastDivision($this->testArr,'_');

    $this->assertEquals('convention',$result[0]);
    $this->assertEquals('edit',$result[1]);
    $this->assertEquals('something',$result[2]);

    $result = Arr::getKeysByLastDivision($this->testArr2,'&');

    $this->assertEquals('convention',$result[0]);
    $this->assertEquals('edit',$result[1]);
    $this->assertEquals('something',$result[2]);
  }

  public function testGetKeysByFirstDivision(){

    $result = Arr::getKeysByFirstDivision($this->testArr,'_');

    $this->assertEquals('this',$result[0]);
    $this->assertEquals('node',$result[1]);
    $this->assertEquals('entity',$result[2]);

    $result = Arr::getKeysByLastDivision($this->testArr2,'&');

    $this->assertEquals('convention',$result[0]);
    $this->assertEquals('edit',$result[1]);
    $this->assertEquals('something',$result[2]);
  }

}
