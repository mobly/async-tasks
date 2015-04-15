<?php

namespace Mobly\Async\Fork\Task;

/**
 * Interface TaskInterface
 *
 * @package Mobly\Async\Fork\Task
 * @author  Arthur Guimarães
 */
interface TaskInterface
{
    public function process(array $data);
}
