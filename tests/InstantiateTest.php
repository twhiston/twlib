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


    $class = Instantiate::make('testo',null,null,'twhiston\twLib\tests\testFace');
    $this->assertNull($class);

    $class = Instantiate::make('testo',null,'twhiston\\twLib\\dringle\\','twhiston\twLib\tests\testFace');
    $this->assertNull($class);

    $class = Instantiate::make('testo',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\failFace');
    $this->assertNull($class);

    $class = Instantiate::make('failure',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
    $this->assertNull($class);

    //Now do the same with some variables
    $class = Instantiate::make('inTest','I am data','twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
    $this->assertNotNull($class);
    $this->assertInstanceOf('twhiston\\twLib\\tests\\inTest',$class);
    $this->assertRegExp('/I am data/',$class->getData());

    $class = Instantiate::make('inTest','I am data','twhiston\\twLib\\tests\\');
    $this->assertNotNull($class);
    $this->assertInstanceOf('twhiston\\twLib\\tests\\inTest',$class);
    $this->assertRegExp('/I am data/',$class->getData());

    $class = Instantiate::make('inTest',null,'twhiston\\twLib\\tests\\','twhiston\twLib\tests\testFace');
    $this->assertNull($class);

    $class = Instantiate::make('inTest','I am data','twhiston\\twLib\\tests\\','twhiston\twLib\tests\failFace');
    $this->assertNull($class);

    $class = Instantiate::make('inTest','I am data',null,'twhiston\twLib\tests\testFace');
    $this->assertNull($class);

    $class = Instantiate::make('inTest','I am data','wrong\\','twhiston\twLib\tests\testFace');
    $this->assertNull($class);


  }

}
