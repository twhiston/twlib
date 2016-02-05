<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 03/02/2016
 * Time: 21:01
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Pointer\Stack;
use twhiston\twLib\Pointer\Pointer;

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

        $pa = new Pointer($a);
        $pb = new Pointer($b);


        $s[] = $pa;
        $s[] = $pb;

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

        $pl = $s->pull();
        $cl = count($s);
        $this->assertEquals($cp-1,$cl);//assert our array got smaller
        $pa = &$pl->getRef();
        $pa = 'it looks like everything is falling';
        $this->assertRegExp('/it looks like everything is falling/',$a);


        //goodbye stack
        foreach($s as $k => $point){
            unset($s[$k]);
        }

    }

}
