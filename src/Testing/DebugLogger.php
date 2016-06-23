<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 16/02/2016
 * Time: 00:45
 */

namespace twhiston\twLib\Testing;

use Psr\Log\AbstractLogger;

class DebugLogger extends AbstractLogger
{

    /** @var  \PHPUnit_Framework_TestCase */
    private $owner;

    private $expected;

    private $index;

    public function __construct(\PHPUnit_Framework_TestCase $test)
    {
        $this->owner = $test;
        $this->index = 0;
    }

    public function reset()
    {
        $index = 0;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {

        $this->owner->assertArrayHasKey($this->index, $this->expected);
        $this->owner->assertStringStartsWith($this->expected[$this->index++], $message);
    }

    public function setExpectedMessages(array $messages)
    {
        $this->expected = $messages;
    }
}