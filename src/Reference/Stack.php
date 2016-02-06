<?php
/**
 * Part of twLib
 * http://www.thomaswhiston.com
 * tom.whiston@gmail.com
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 03/02/2016
 * Time: 20:44
 */
namespace twhiston\twLib\Reference;

use twhiston\twLib\Exception\TwLibException;

/**
 * Class Stack
 * Basic reference stack
 * add items to the stack with the takeReference function
 * Though this class has array access it will throw an exception if you attempt to add anything by reference as its impossible
 * @package twhiston\twLib\Reference
 */
class Stack implements \ArrayAccess, \Iterator, \Countable
{

    /**
     * @var Reference[]
     */
    private $stack;

    /**
     * @var int
     */
    private $pos;

    /**
     * Stack constructor.
     */
    public function __construct()
    {
        $this->pos = 0;
    }

    /**
     * @param $data
     */
    public function takeReference(&$data)
    {
        if ($data instanceof Reference) {
            $this->stack[] = $data;
        } else {
            $this->stack[] = new Reference($data);
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->stack[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return isset($this->stack[$offset]) ? $this->stack[$offset] : null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        throw new TwLibException(
          'Do not set stack references with the array operator'
        );
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->stack[$offset]);
    }


    /**
     * @inheritDoc
     */
    public function current()
    {
        $this->stack[$this->pos];
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        ++$this->pos;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->pos;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return isset($this->stack[$this->pos]);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->pos = 0;
    }

    /**
     * @return \twhiston\twLib\Reference\Reference
     */
    public function &top()
    {
        return $this->stack[count($this->stack) - 1];
    }

    /**
     * Remove the Reference from the top of the stack
     */
    public function pop()
    {
        return array_pop($this->stack);
    }

    /**
     * Remove the Reference from the bottom of the stack
     */
    public function shift()
    {
        return array_shift($this->stack);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->stack);
    }


}