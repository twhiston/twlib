<?php
/**
 * Created by PhpStorm.
 * User: Thomas Whiston
 * Date: 03/02/2016
 * Time: 18:19
 */

namespace twhiston\twLib\Reference;


/**
 * Class Reference
 * A way of wrapping references so that they can be more easily worked with,
 * behaviour should be consistent as long as you call the functions to get and set.
 * Works with the Stack class to allow you to store a reference history, which is useful for traversing nested arrays
 * @package twhiston\twLib\Reference
 */
class Reference
{
    /**
     * The reference
     * @var null
     */
    private $point;

    /**
     * Reference constructor.
     * Pass in the thing you want to get the reference of
     * @param null|mixed $ref
     */
    public function __construct(&$ref = null)
    {
        $this->point = &$ref;
    }

    /**
     * Set data at the location the reference points to
     * @param $data
     */
    public function set($data)
    {
        $this->point = $data;
    }

    /**
     * Return a copy of the data references to by this reference instance
     * @return null
     */
    public function copy()
    {
        return $this->point;
    }

    /**
     * Swap this reference with another
     * @param \twhiston\twLib\Reference\Reference $point
     * @return mixed|null
     */
    public function &swap(Reference &$point)
    {

        $tmp =  &$this->point;
        $pr = &$point->getRef();
        $this->reset($pr);
        $point->reset($tmp);

        return $tmp;

    }

    /**
     * Remember that you MUST put & infront of the function call as well to actually get a reference
     * This will return the memory location of the object pointed to by $this->point
     * @return null|mixed
     */
    public function &getRef()
    {
        return $this->point;
    }

    /**
     * Release the current reference and either set this reference to NULL or to &$ref
     * @param null $ref
     */
    public function reset(&$ref = null)
    {
        $this->release();
        $this->point = &$ref;
    }

    /**
     * Release the reference
     */
    public function release()
    {
        unset($this->point);
        $this->point = null;
    }
}