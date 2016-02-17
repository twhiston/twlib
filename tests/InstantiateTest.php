<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 27/01/2016
 * Time: 23:42
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Object\Instantiate;

interface testFace {

  public function testMyFace();
}

class testo implements testFace{

  public function testMyFace() {
    return 'kiss my face';
  }

}

class inTest implements testFace {

  private $data;

  public function __construct($data) {
    $this->data = $data;
  }

  public function getData(){
    return $this->data;
  }

  public function testMyFace() {
    return 'in to face';
  }

}


class InstantiateTest extends \PHPUnit_Framework_TestCase {

  public function testInstantiate(){

    $class = Instantiate::make('testo',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
    $this->assertNotNull($class);
    $this->assertInstanceOf('twhiston\\twLib\\tests\\testo',$class);

    $class = Instantiate::make('testo',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
    $this->assertNotNull($class);
    $this->assertInstanceOf('twhiston\\twLib\\tests\\testo',$class);

    //Now do the same with some variables
    $class = Instantiate::make('inTest','I am data','twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
    $this->assertNotNull($class);
    $this->assertInstanceOf('twhiston\\twLib\\tests\\inTest',$class);
    $this->assertRegExp('/I am data/',$class->getData());

    $class = Instantiate::make('inTest','I am data','twhiston\\twLib\\tests\\');
    $this->assertNotNull($class);
    $this->assertInstanceOf('twhiston\\twLib\\tests\\inTest',$class);
    $this->assertRegExp('/I am data/',$class->getData());

  }

  /**
   * @throws \Exception
   * @expectedException \Exception
   * @expectedExceptionMessage Class does not exist
   */
  public function testFailing1(){
    $class = Instantiate::make('testo',null,null,'twhiston\twLib\tests\testFace');
  }

  /**
   * @throws \Exception
   * @expectedException \Exception
   * @expectedExceptionMessage Class does not exist
   */
  public function testFailing2(){
    $class = Instantiate::make('testo',null,'twhiston\\twLib\\dringle\\','twhiston\twLib\tests\testFace');
  }

  /**
   * @throws \Exception
   * @expectedException \Exception
   * @expectedExceptionMessage Does not implement requested interface
   */
  public function testFailing3(){
    $class = Instantiate::make('testo',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\failFace');
  }

  /**
   * @throws \Exception
   * @expectedException \Exception
   * @expectedExceptionMessage Class does not exist
   */
  public function testFailing4(){
    $class = Instantiate::make('failure',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
  }


  public function testWorking(){
    $class = Instantiate::make('inTest',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
    $this->assertInstanceOf('twhiston\\twLib\\tests\\inTest',$class);
  }
  /**
   * @throws \Exception
   * @expectedException \Exception
   */
  public function testFailing6(){
    $class = Instantiate::make('inTest','I am data','twhiston\\twLib\\tests\\','twhiston\twLib\tests\failFace');
    $this->assertNull($class);
  }
  /**
   * @throws \Exception
   * @expectedException \Exception
   */
  public function testFailing7(){
    $class = Instantiate::make('inTest','I am data',null,'twhiston\twLib\tests\testFace');
    $this->assertNull($class);
  }
  /**
   * @throws \Exception
   * @expectedException \Exception
   */
  public function testFailing8(){
    $class = Instantiate::make('inTest','I am data','wrong\\','twhiston\twLib\tests\testFace');
    $this->assertNull($class);
  }

}
