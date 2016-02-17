<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 03/02/2016
 * Time: 21:01
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Reference\Stack;
use twhiston\twLib\Reference\Reference;

use twhiston\twLib\Exception\TwLibException;

/**
 * Class StackTest
 * @package twhiston\twLib\tests
 * @group failing
 */
class StackTest extends \PHPUnit_Framework_TestCase
{

    public function testStack(){

        $a = 23;
        $b = 'string it up';

        $s = new Stack();
        $pb = new Reference($b);

        $s->takeReference($a);
        $s->takeReference($pb);

        try{
            $s[] = $pb;
        } catch (TwLibException $e){
            $this->assertRegExp('/Do not set stack references with the array operator/',$e->getMessage());
        }


        $this->assertEquals(23,$s[0]->copy());
        $this->assertRegExp('/string it up/',$s[1]->copy());

        $a = 'gone';
        $b = 'girl';

        $this->assertRegExp('/gone/',$s[0]->copy());
        $this->assertRegExp('/girl/',$s[1]->copy());

        $ref = 'take me';

        $s->takeReference($ref);
        $this->assertRegExp('/take me/',$s[2]->copy());

        $ref = 'thus i was taken';
        $this->assertRegExp('/thus i was taken/',$s[2]->copy());

        $s[2]->set('rewind');
        $this->assertRegExp('/rewind/',$ref);

        $g = $s[2];
        $g->set('bo selecta');

        //Test that you cant alter the top if you forget to take it by reference
        /** @var Pointer $top */
        $top = $s->top();
        $tr = $top->getRef();
        $tr =  'beans';
        $this->assertRegExp('/bo selecta/',$ref);

        //Test that you do alter the location if you take it by reference
        /** @var Pointer $top */
        $top = &$s->top();
        $tr = &$top->getRef();
        $tr =  'beans';
        $this->assertRegExp('/beans/',$ref);

        //Pop the top item off the stack
        $cs = count($s);
        /** @var Pointer $p */
        $p = $s->pop();
        $cp = count($s);
        $this->assertEquals($cs-1,$cp);//assert our array got smaller
        $ra = &$p->getRef();
        $ra = 'show me the sunshine';
        $this->assertRegExp('/show me the sunshine/',$p->copy());
        $this->assertRegExp('/show me the sunshine/',$ref);

        $pl = $s->shift();
        $cl = count($s);
        $this->assertEquals($cp-1,$cl);//assert our array got smaller
        $pa = &$pl->getRef();
        $pa = 'it looks like everything is falling';
        $this->assertRegExp('/it looks like everything is falling/',$a);


        //goodbye stack
        foreach($s as $k => $point){
            unset($s[$k]);
        }

        $this->assertCount(0,$s);

    }

    public function testArrayCount(){

        $d1 = 23;
        $d2 = 'string it';
        $d3 = 'more';
        $d4 = 'd4';

        $s = new Stack();
        $s->takeReference($d1);
        $s->takeReference($d2);
        $this->assertCount(2,$s);
        $p = $s->pop();
        $this->assertCount(1,$s);

        $d3 = 'when it all falls down';
        $s->takeReference($d3);
        $this->assertCount(2,$s);
    }

}
