<?php

/**
 * Created by PhpStorm.
 * User: tom
 * Date: 18/06/2016
 * Time: 16:28
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Discovery\FindByNamespace;


class FindByNamespaceTest extends \PHPUnit_Framework_TestCase
{

    public function testFindByNamespace()
    {
        $finder = new FindByNamespace(__DIR__.'/../src');
        $found = $finder->find('twhiston\\twLib\\Discovery');
        $this->assertEquals('twhiston\\twLib\\Discovery\\FindByNamespace',$found[0]);
    }

    public function testNoNamespace()
    {
        $finder = new FindByNamespace('');
        $found = $finder->find();
        $this->assertEmpty($found);
    }
}
