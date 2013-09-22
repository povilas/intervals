<?php

namespace Puovils\Intervals;

class IntervalBuilder
{
    /**
     * @var mixed
     */
    private $low;

    /**
     * @var bool
     */
    private $lowIncluded;

    /**
     * @var mixed
     */
    private $high;

    /**
     * @var bool
     */
    private $highIncluded;

    /**
     * @param mixed $value
     * @param bool $isIncluded
     * @return $this
     */
    public function low($value, $isIncluded = false)
    {
        $this->low = $value;
        $this->lowIncluded = $isIncluded;

        return $this;
    }

    /**
     * @param mixed $value
     * @param bool $isIncluded
     * @return $this
     */
    public function high($value, $isIncluded = false)
    {
        $this->high = $value;
        $this->highIncluded = $isIncluded;

        return $this;
    }

    /**
     * @return Interval
     */
    public function getInterval()
    {
        return new Interval(
            new IntervalValue($this->low, $this->lowIncluded),
            new IntervalValue($this->high, $this->highIncluded)
        );
    }
}
