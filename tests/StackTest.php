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

    }

}
