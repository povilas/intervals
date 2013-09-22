<?php

namespace Puovils\Intervals;

/**
 * Value object for interval
 * @package Puovils\Intervals
 */
class Interval
{
    /**
     * @var IntervalValue
     */
    private $low;

    /**
     * @var IntervalValue
     */
    private $high;

    /**
     * @param IntervalValue $low
     * @param IntervalValue $high
     */
    public function __construct(IntervalValue $low, IntervalValue $high)
    {
        $this->low = $low;
        $this->high = $high;
    }

    /**
     * @return IntervalValue
     */
    public function low()
    {
        return $this->low;
    }

    /**
     * @return IntervalValue
     */
    public function high()
    {
        return $this->high;
    }
}
