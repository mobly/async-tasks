<?php

namespace Mobly\Async\Fork;

/**
 * Class Result
 *
 * @package Mobly\Async\Fork
 * @author  Arthur GuimarÃ£es
 */
class Result
{
    /**
     * @var Process
     */
    protected $process;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var boolean
     */
    protected $successful = false;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     *
     * @return Process
     */
    public function getProcess()
    {
        return $this->process;
    }
    
    /**
     *
     * @param Process $process
     */
    public function setProcess($process)
    {
        $this->process = $process;
        return $this;
    }
    
    /**
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     *
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     *
     * @return boolean.
     */
    public function isSuccessful()
    {
        return $this->successful;
    }
    
    /**
     *
     * @param boolean $successful
     */
    public function setSuccessful($successful)
    {
        $this->successful = $successful;
        return $this;
    }
    
    /**
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
    
    /**
     *
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }
}
