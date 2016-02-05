<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 03/02/2016
 * Time: 20:44
 */

namespace twhiston\twLib\Pointer;


/**
 * Class Stack
 * Basic reference stack
 * add items to the stack with the [] operator if they are already a pointer
 * @package twhiston\twLib\Pointer
 */
class Stack implements \ArrayAccess, \Iterator, \Countable
{

    /**
     * @var Pointer[]
     */
    private $stack;

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
    public function takeReference(&$data){
        $this->stack[] = new Pointer($data);
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
        if (is_null($offset)) {
            $this->stack[] = $value;
        } else {
            $this->stack[$offset] = $value;
        }
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
     * @return \twhiston\twLib\Pointer\Pointer
     */
    public function &top(){
        return $this->stack[count($this->stack)-1];
    }

    /**
     * Remove the Pointer from the top of the stack
     */
    public function pop(){
        $tmp = end($this->stack);
        unset($this->stack[key($this->stack)]);
        return $tmp;
    }

    /**
     * Remove the Pointer from the bottom of the stack
     */
    public function pull(){
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