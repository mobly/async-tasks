<?php

namespace Mobly\Async\Fork;

/**
 * Class Process
 *
 * @package Mobly\Async\Fork
 * @author  Arthur Guimarães
 */
class Process
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $data = array();

    /**
     *
     * @param string $class
     * @param array $data
     */
    public function __construct($class, $data)
    {
        $this->class = $class;
        $this->data = $data;
    }
    
    /**
     *
     * @return string $class
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     *
     * @param string $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }
    
    /**
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     *
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
