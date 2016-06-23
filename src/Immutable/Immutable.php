<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 08/05/2016
 * Time: 14:25
 */

namespace twhiston\twLib\Immutable;


/**
 * Class Immutable
 * @package twhiston\twLib\Immutable
 */
abstract class Immutable
{

    /**
     * Set in parent constructor to resist future attempts to clone or reconstruct
     * @var bool
     */
    private $constructed;

    /**
     * Immutable constructor.
     * This must be called from your child class to make the object immutable
     */
    public function __construct()
    {
        if ($this->constructed) {
            throw new ImmutableException('Immutable Object');
        }
        $this->constructed = true;
    }

    /**
     * Throw an exception on setting
     * @param $name
     * @param $value
     */
    final public function __set($name, $value)
    {
        throw new ImmutableException('Immutable Object');
    }

    /**
     * Throw an exception on cloning
     */
    final public function __clone()
    {
        throw new ImmutableException('Immutable Object');
    }


}