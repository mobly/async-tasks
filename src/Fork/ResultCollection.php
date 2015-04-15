<?php

namespace Mobly\Async\Fork;

use Doctrine\Common\Collections\ArrayCollection;
use Mobly\Async\Fork\Result;

/**
 * Class ResultCollection
 *
 * @package Mobly\Async\Fork
 * @author  Arthur Guimarães
 */
class ResultCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    public function add($value)
    {
        if (!($value instanceof Result)) {
            throw new \InvalidArgumentException(
                'Value is not an instance of Result'
            );
        }

        return parent::add($value);
    }
}
