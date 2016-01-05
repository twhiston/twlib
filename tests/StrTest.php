<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 05/01/2016
 * Time: 17:46
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Str;


class StrTest extends \PHPUnit_Framework_TestCase {

  public function testStartsWith(){
    $string = "yo, i am here";
    $this->assertTrue(Str::startsWith($string,'yo'));

    $this->assertEquals('yo',Str::startsWith(
      $string,
      ['low', 'blow', 'yo']
    )
    );

    $this->assertFalse(Str::startsWith($string,'that'));
    $this->assertFalse(Str::startsWith(
      $string,
      ['low', 'blow', 'nothing'])
    );

  }

  public function testEndsWith(){

    $string = "yo, i am here";
    $this->assertTrue(Str::endsWith($string,'here'));

    $this->assertEquals('here',Str::endsWith(
      $string,
      ['low', 'blow', 'yo','here']
    )
    );

    $this->assertFalse(Str::endsWith($string,'yo'));
    $this->assertFalse(Str::endsWith(
      $string,
      ['low', 'blow', 'nothing'])
    );
  }

  public function testContains(){
    $string = "yo, i am here";
    $this->assertTrue(Str::contains($string,'here'));
    $this->assertFalse(Str::contains($string,'beer'));

    $this->assertContains('am',Str::contains(
      $string,
      ['low', 'blow', 'yo','am']
    )
    );

    $res = Str::contains(
        $string,
        ['low', 'blow', 'yo','am']
    );
    $this->assertContains('am',$res);
    $this->assertContains('yo',$res);

    $this->assertFalse(Str::contains(
      $string,
      ['low', 'blow']
    ));


  }

}
