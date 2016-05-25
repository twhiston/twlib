<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 05/01/2016
 * Time: 17:46
 */

namespace twhiston\twLib\tests;

use twhiston\twLib\Str\Str;


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

  public function testStartsWithNull(){
    $this->assertFalse(Str::startsWith('test',null));
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

  public function testEndsWithNull(){
    $this->assertFalse(Str::endsWith('test',null));
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


  public function testGetAfter(){

    /**
     * test when the token is at the end
     * should return an array with a blank last member and should NOT start with 12345
     */
    $string = '12345an5678 an91234an56an78na123an';
    $aft = Str::getAfter($string,'an');
    $this->assertArrayHasKey('an',$aft);
    $this->assertNotEquals("12345",$aft['an'][0]);
    $this->assertEquals("",$aft['an'][4]);

    /**
     * test when the token is at the start
     */
    $string = 'an12345an5678 an91234an56an78na123';
    $aft = Str::getAfter($string,'an');
    $this->assertArrayHasKey('an',$aft);

    /**
     * test when the token is in the string
     * should not return 12345 as the first member
     */
    $string = '12345an5678 an91234an56an78na123an1';
    $aft = Str::getAfter($string,'an');
    $this->assertArrayHasKey('an',$aft);
    $this->assertNotEquals('12345',$aft['an'][0]);

    /**
     * test when the token is at the start and end
     * should have 12345 at the start and a blank at the end
     */
    $string = 'an12345an5678 an91234an56an78na123an';
    $aft = Str::getAfter($string,'an');
    $this->assertArrayHasKey('an',$aft);
    $this->assertEquals("12345",$aft['an'][0]);
    $this->assertEquals("",$aft['an'][5]);

    /**
     * test when the phrase is not in the string
     */
    $string = 'an12345an5678 an91234an56an78na123an';
    $aft = Str::getAfter($string,'fail');
    $this->assertArrayHasKey('fail',$aft);
    $this->assertCount(0,$aft['fail']);


  }

  public function testGetBefore(){

    /**
     * test when the token is at the end
     * should return an array with a 12345 at the start and 78na123 at the end
     */
    $string = '12345an5678 an91234an56an78na123an';
    $aft = Str::getBefore($string,'an');
    $this->assertArrayHasKey('an',$aft);
    $this->assertEquals("12345",$aft['an'][0]);
    $this->assertEquals("78na123",$aft['an'][4]);

    /**
     * test when the token is at the start
     * should return a blank entry at the start and not 78na123 at the end
     */
    $string = 'an12345an5678 an91234an56an78na123';
    $aft = Str::getBefore($string,'an');
    $this->assertArrayHasKey('an',$aft);
    $this->assertEquals("",$aft['an'][0]);
    $this->assertCount(5,$aft['an']);

    /**
     * test when the token is in the string
     * should not return 1 as the last member
     */
    $string = '12345an5678 an91234an56an78na123an1';
    $aft = Str::getBefore($string,'an');
    $this->assertArrayHasKey('an',$aft);
    $this->assertCount(5,$aft['an']);


    /**
     * test when the token is at the start and end
     * should have nothing at the start and 78na123 at the end
     */
    $string = 'an12345an5678 an91234an56an78na123an';
    $aft = Str::getBefore($string,'an');
    $this->assertArrayHasKey('an',$aft);
    $this->assertCount(6,$aft['an']);
    $this->assertEquals("",$aft['an'][0]);
    $this->assertEquals("78na123",$aft['an'][5]);

    /**
     * test when the phrase is not in the string
     */
    $string = 'an12345an5678 an91234an56an78na123an';
    $aft = Str::getBefore($string,'fail');
    $this->assertArrayHasKey('fail',$aft);
    $this->assertCount(0,$aft['fail']);


    //Simple string
    $string = 'this is some text that we can search through';
    $b4 = Str::getBefore($string,'some');
    $this->assertCount(1,$b4);
    $this->assertRegExp('/^this is /',$b4['some'][0]);

    //array of needles
    $b4 = Str::getBefore($string,['some','that', 'rch', 'at', 'heynongman']);
    $this->assertCount(5,$b4);
    $this->assertArrayHasKey('some',$b4);
    $this->assertArrayHasKey('that',$b4);
    $this->assertArrayHasKey('rch',$b4);
    $this->assertArrayHasKey('at',$b4);
    $this->assertArrayHasKey('heynongman',$b4);
    $this->assertCount(0,$b4['heynongman']);
    $this->assertRegExp('/^this is /',$b4['some'][0]);
    $this->assertRegExp('/^this is some text /',$b4['that'][0]);
    $this->assertRegExp('/^this is some text that we can sea/',$b4['rch'][0]);
    $this->assertRegExp('/^this is some text th/',$b4['at'][0]);



    //Test the classics
    $string = <<<EOH
consectetur adipiscing elit. Morbi id gravida quam. Lorem ipsum dolor sit amet
Vestibulum vel nisl id dolor tincidunt finibus id et erat. Nullam pharetra est sed pellentesque suscipit.
Integer sit amet justo condimentum elit aliquam blandit. Cras dapibus est ac risus bibendum porta.
Nullam gravida nisl sem, nec fermentum ipsum vestibulum eu. Nam posuere velit sit amet nunc consequat varius.
Aenean ante felis, suscipit ut dui a, posuere eleifend est. Vestibulum sit amet orci et libero dapibus malesuada.
Phasellus sagittis erat ac suscipit bibendum. Donec at tortor rutrum, ultrices mi vel, consequat risus. Maecenas feugiat tempus sem eu interdum.
EOH;

    $b4 = Str::getBefore($string,['id','ip', ' ip', 'Cras','posuere']);
    $this->assertCount(5,$b4);
    $this->assertArrayHasKey('id',$b4);
    $this->assertArrayHasKey('ip',$b4);
    $this->assertArrayHasKey(' ip',$b4);
    $this->assertArrayHasKey('Cras',$b4);
    $this->assertArrayHasKey('posuere',$b4);

    $this->assertRegExp('/^consectetur adipiscing elit. Morbi /',$b4['id'][0]);
    $this->assertRegExp('/^consectetur ad/',$b4['ip'][0]);
    $this->assertRegExp('/^consectetur adipiscing elit. Morbi id gravida quam. Lorem/',$b4[' ip'][0]);
    $this->assertRegExp('/^consectetur adipiscing elit. Morbi id gravida quam. Lorem ipsum dolor sit amet
Vestibulum vel nisl id dolor tincidunt finibus id et erat. Nullam pharetra est sed pellentesque suscipit.
Integer sit amet justo condimentum elit aliquam blandit. /',$b4['Cras'][0]);
    $this->assertRegExp('/^consectetur adipiscing elit. Morbi id gravida quam. Lorem ipsum dolor sit amet
Vestibulum vel nisl id dolor tincidunt finibus id et erat. Nullam pharetra est sed pellentesque suscipit.
Integer sit amet justo condimentum elit aliquam blandit. Cras dapibus est ac risus bibendum porta.
Nullam gravida nisl sem, nec fermentum ipsum vestibulum eu. Nam /',$b4['posuere'][0]);


  }



}
