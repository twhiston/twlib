<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 05/01/2016
 * Time: 15:41
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Arr\Arr;
use twhiston\twLib\Rand\Rand;

class ArrTest extends \PHPUnit_Framework_TestCase {

  public $testArr;

  public $testArr2;

  public $testArr3;

  public function __construct() {
     parent::__construct();
    $this->testArr = [
      'this_is_a_drupal_naming_convention' => 'whatever',
      'node_form_type_edit' => 0,
      'entity_something' => new \stdClass(),
      'ends_with_entity' => 1,
      'in_the_entity_middle' => 2,
      'another_ends_in_entity' => 2,
    ];

    $this->testArr2 = [
      'this&is&a&drupal&naming&convention' => 'whatever',
      'node&form&type&edit' => 0,
      'entity&something' => new \stdClass(),
      'nokeyhere' => NULL,
    ];

    $this->testArr3 = [
      'class' => new Arr(),
      'another' => new Rand(),
      'more' => new Arr(),
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
    $this->assertCount(3,$result);//only 3 as last key does not have the key in
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
    $this->assertCount(3,$result);
  }

  public function testGetDataByFirstKeyDivision(){

    $result = Arr::reKeyByFirstKeyDivision($this->testArr,'_');
    $this->assertArrayHasKey('this',$result);
    $this->assertInternalType('integer',$result['node']);
    $this->assertCount(6,$result);

  }

  public function testGetDataByLastKeyDivision(){

    $result = Arr::reKeyByLastKeyDivision($this->testArr,'_');
    $this->assertArrayHasKey('edit',$result);
    $this->assertInstanceOf('stdClass',$result['something']);
    $this->assertCount(5,$result);

  }

  public function testFilterKeyContains(){

    $result = Arr::filterKeyContains($this->testArr, '_');
    $this->assertCount(6,$result);
    $this->assertArraySubset($result, $this->testArr);

    $result1 = Arr::filterKeyContains($this->testArr, 'node');
    $this->assertCount(1,$result1);
    $this->assertEquals(0,array_values($result1)[0]);
    $this->assertArraySubset($result, $this->testArr);


  }

  public function testFilterKeyNotContains(){

    $result = Arr::filterKeyNotContains($this->testArr, '_');
    $this->assertCount(0,$result);

    $result1 = Arr::filterKeyNotContains($this->testArr, 'key');
    $this->assertCount(6,$result1);
    $this->assertEquals('whatever',array_values($result1)[0]);
    $this->assertArraySubset($result, $this->testArr);

  }

  public function testFilterKeyStartsWith(){
    $result = Arr::filterKeyStartsWith($this->testArr,'entity');
    $this->assertCount(1,$result);

  }

  public function testFilterKeyEndsWith(){
    $result = Arr::filterKeyEndsWith($this->testArr,'entity');
    $this->assertCount(2,$result);
  }

  public function testFilterHasValue(){
    $result = Arr::filterHasValue($this->testArr,0);
    $this->assertCount(1,$result);
    $this->assertArrayHasKey('node_form_type_edit',$result);
    $this->assertArraySubset($result, $this->testArr);
    foreach ($result as $key => $item) {
      $this->assertEquals(0,$item);
    }

    $result = Arr::filterHasValue($this->testArr,2);
    $this->assertCount(2,$result);
    $this->assertArrayHasKey('another_ends_in_entity',$result);
    $this->assertArraySubset($result, $this->testArr);
    foreach ($result as $key => $item) {
      $this->assertEquals(2,$item);
    }
  }

  public function testFilterHasNotValue(){
    $result = Arr::filterHasNotValue($this->testArr,0);
    $this->assertCount(3,$result);
    $this->assertArrayHasKey('in_the_entity_middle',$result);
    $this->assertArraySubset($result, $this->testArr);
    foreach ($result as $key => $item) {
      $this->assertNotEquals(0,$item);
    }

    $result = Arr::filterHasNotValue($this->testArr,2);
    $this->assertCount(2,$result);
    $this->assertArrayHasKey('ends_with_entity',$result);
    $this->assertArraySubset($result, $this->testArr);
    foreach ($result as $key => $item) {
      $this->assertNotEquals(2,$item);
    }
  }

  public function testFilterType(){
    $result = Arr::filterByType($this->testArr,'string');
    $this->assertCount(1,$result);
    $this->assertArrayHasKey('this_is_a_drupal_naming_convention',$result);

    $result = Arr::filterByType($this->testArr,'integer');
    $this->assertCount(4,$result);
    $this->assertArrayHasKey('node_form_type_edit',$result);


    $result = Arr::filterByType($this->testArr,'stdClass');
    $this->assertCount(1,$result);
    $this->assertArrayHasKey('entity_something',$result);

    $result = Arr::filterByType($this->testArr3,'twhiston\twLib\Arr\Arr');
    $this->assertCount(2,$result);
    $this->assertArrayHasKey('class',$result);

    $result = Arr::filterByType($this->testArr3,'twhiston\twLib\Rand\Rand');
    $this->assertCount(1,$result);
    $this->assertArrayHasKey('another',$result);

  }

}
