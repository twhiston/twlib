<?php

/**
 * Created by PhpStorm.
 * User: tom
 * Date: 08/05/2016
 * Time: 14:29
 */
namespace twhiston\twLib\tests;

use twhiston\twLib\Immutable\Immutable;

class Config extends Immutable {

    private $data1;

    private $data2;

    public function __construct($data1,$data2)
    {
        parent::__construct();
        $this->data1 = $data1;
        $this->data2 = $data2;
    }

    public function getData1(){
        return $this->data1;
    }

    public function getData2(){
        return $this->data2;
    }

}

class container {

    public $config;

    public function __construct()
    {
        $this->config = new Config("value", "a value too");
        $this->config->__set("key","changed");
    }

}

class containerTwo {

    public $config;

    public function __construct()
    {
        $this->config = new Config("value", "a value too");
        $this->config->key = "changed";
    }

}

class ImmutableTest extends \PHPUnit_Framework_TestCase
{

    public function testGetValues(){
        $i = new Config( "hello","dolly" );
        $this->assertEquals("hello", $i->getData1());
        $this->assertEquals("dolly", $i->getData2());
    }

    /**
     * @expectedException \twhiston\twLib\Immutable\ImmutableException
     * @expectedExceptionMessage Immutable Object
     */
    public function testSetFakeout(){
        $c = new Container();
    }

    /**
     * @expectedException \twhiston\twLib\Immutable\ImmutableException
     * @expectedExceptionMessage Immutable Object
     */
    public function testNoExplicitSetFakeout(){
        $c = new ContainerTwo();
    }

    /**
     * @expectedException \twhiston\twLib\Immutable\ImmutableException
     * @expectedExceptionMessage Immutable Object
     */
    public function testExplicitlySetImmutable(){
        $i = new Config( "hello", "dolly" );
        $i->__set("data1","goodbye");
    }

    /**
     * @expectedException \twhiston\twLib\Immutable\ImmutableException
     * @expectedExceptionMessage Immutable Object
     */
    public function testSetImmutable(){
        $i = new Config("hello", "dolly" );
        $i->data1 = "goodbye";
    }



    /**
     * @expectedException \twhiston\twLib\Immutable\ImmutableException
     * @expectedExceptionMessage Immutable Object
     */
    public function testCloneImmutable(){
        $i = new Config( "hello",  "dolly" );
        $ia = clone $i;
    }

    /**
     * @expectedException \twhiston\twLib\Immutable\ImmutableException
     * @expectedExceptionMessage Immutable Object
     */
    public function testReconstruct(){
        $i = new Config( "hello", "dolly");
        $i->__construct("goodbye", "dingus");
    }


}
