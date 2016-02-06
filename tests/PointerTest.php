<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 03/02/2016
 * Time: 18:23
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Pointer\Pointer;
use twhiston\twLib\Pointer\Stack;

/**
 * Class PointerTest
 * @package twhiston\twLib\tests
 */
class PointerTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicVariable()
    {
        $item = 23;//Some single object
        $str = 'i be a string';

        $this->doTests($item);
        $this->doTests($str);


    }

    private function doTests($item){

        $stash = $item;

        $p = new Pointer($item);//Reference Item

        $this->assertEquals($item,$p->copy());

        //check that set actually sets the data in $item and doesnt reset the pointer
        $p->set('die');
        $this->assertRegExp('/die/', $item);
        $this->assertRegExp('/die/', $p->copy());

        //and if we set the original our pointers data changes
        $item = 23;
        $this->assertEquals(23, $p->copy());

        //Test Copy does not alter the existing data
        $v = $p->copy();
        $this->assertEquals(23, $v);
        $v = 55;
        $this->assertEquals(55, $v);
        $this->assertEquals(23, $p->copy());

        //Test that copy cannot be fetched by reference
        try {
            $r = &$p->copy();
        } catch (\Exception $e) {
            $this->assertEquals(2048, $e->getCode());
        }


        //test that get gives you a reference.
        //Annoyingly we cant really stop it returning a copy if you dont use & in the function call :(
        $g = &$p->getRef();
        $g = 'banana';

        $this->assertRegExp('/banana/',$item);
        $this->assertRegExp('/banana/',$p->copy());


        //test resetting
        $to = 'reset';
        $p->reset($to);
        $this->assertRegExp('/reset/',$p->copy());
        $g = &$p->getRef();
        $g = 45;
        $this->assertEquals(45,$p->copy());


        //Test releasing
        $p->release();
        $this->assertNull($p->copy());

        $item = $stash; //reset

        $swap = [
            'data' => 'we swapped this all in',
            'pretty' => 'cool'
        ];

        $p->reset($item);

        $ps = new Pointer($swap);

        //it got copied in right?
        $this->assertArrayHasKey('data',$ps->copy());
        $this->assertArrayHasKey('pretty',$ps->copy());

        $p->swap($ps);

        $item = 007;
        $swap['new'] = 'extra data';

        $this->assertArrayHasKey('data',$p->copy());
        $this->assertArrayHasKey('pretty',$p->copy());
        $this->assertArrayHasKey('new',$p->copy());

        $this->assertEquals(7,$ps->copy());

    }


    public function testPointer()
    {

        $data = $this->getData();
        $data['bees']['hives']->newprop = 'value';
        $this->doTests($data[0]);

        $data = $this->getData();
        $data['bees']['hives']->newprop = 'value';
        $this->doTests($data['bees']);

        $data = $this->getData();
        $data['bees']['hives']->newprop = 'value';
        $this->doTests($data['bees'][0]);

        $data = $this->getData();
        $data['bees']['hives']->newprop = 'value';
        $this->doTests($data['bees']['hives']->newprop);


    }

    private function getData(){
        return [
          0 => 23,
          'one' => 'text',
          'bees' => [
            0 => 666,
            'depth' => 'stuff',
            'hives' => new \StdClass()
          ]
        ];
    }

    public function testArrayAccess(){

        $data = $this->getData();

        $s = new Stack();
        $s->takeReference($data[0]);
        $s->takeReference($data['bees']);

        $r = &$s->top();
        $rf = &$r->getRef();

        $rf[0] = 'changed';

        $pt = &$rf['depth'];
        $pt = 'you\'re superhuman';

        $ind = 'depth';
        $pn = &$rf[$ind];
        $pn = 'if you dont want to loose me forever';
    }

    public function testTakeReferenceFromReference(){

        $data = $this->getData();

        $s = new Stack();

        $s->takeReference($data[0]);

        $ref = &$data['bees'];
        $s->takeReference($ref);

        $ref = 'i hear your voice just calling me';

    }

}
