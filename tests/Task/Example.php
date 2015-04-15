<?php

namespace Mobly\Async\Test\Task;

use Mobly\Async\Fork\Task\TaskInterface;

class Example implements TaskInterface
{
    public function process(array $data)
    {
        if (!isset($data['qty'])) {
            throw new \InvalidArgumentException(
                'Provide a quantity'
            );
        }
        return $data['qty'] * 2;
    }
}
