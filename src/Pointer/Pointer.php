<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 03/02/2016
 * Time: 18:19
 */

namespace twhiston\twLib\Pointer;

/**
 * Class Pointer
 * An attempt to see if its possible to mimic pointer like data structures for storing references
 * @package twhiston\twLib\Pointer
 */
/**
 * Class Pointer
 * @package twhiston\twLib\Pointer
 */
class Pointer
{
    /**
     * @var null
     */
    private $point;

    /**
     * Pointer constructor.
     * @param null $ref
     */
    public function __construct(&$ref = NULL)
    {
        $this->point = &$ref;
    }

    /**
     * Set data at the location the pointer points to
     * @param $data
     */
    public function set($data){
        $this->point = $data;
    }

    /**
     * Return a copy of the data pointed to by this pointer instance
     * @return null
     */
    public function copy(){
        return $this->point;
    }

    /**
     * Remember that you MUST put & infront of the function call as well to actually get a reference
     * This will return the memory location of the object pointed to by $this->point
     * @return null|mixed
     */
    public function &getRef(){
        return $this->point;
    }

    /**
     * Release the current pointer and either set this pointer to NULL or to &$ref
     * @param null $ref
     */
    public function reset(&$ref = NULL){
        $this->release();
        $this->point = &$ref;
    }

    /**
     * Release the pointer
     */
    public function release(){
        unset($this->point);
        $this->point = NULL;
    }


    public function &swap(Pointer &$point){

        $tmp =  &$this->point;
        $pr = &$point->getRef();
        $this->reset($pr);
        $point->reset($tmp);
        return $tmp;

    }
}