<?php

namespace Mobly\Async\Fork;

use Doctrine\Common\Collections\ArrayCollection;
use Mobly\Async\Fork\Process;

/**
 * Class ProcessCollection
 *
 * @package Mobly\Async\Fork
 * @author  Arthur Guimarães
 */
class ProcessCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    public function add($value)
    {
        if (!($value instanceof Process)) {
            throw new \InvalidArgumentException(
                'Value is not an instance of Process'
            );
        }

        return parent::add($value);
    }
}
