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
class Stack implements \ArrayAccess
{

    /**
     * @var Pointer[]
     */
    private $stack;

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

}