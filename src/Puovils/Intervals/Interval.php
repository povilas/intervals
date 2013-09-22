<?php

namespace Puovils\Intervals;

/**
 * Value object for interval
 * @package Puovils\Intervals
 */
class Interval
{
    /**
     * @var mixed
     */
    private $since;

    /**
     * @var mixed
     */
    private $until;

    /**
     * @param mixed $since
     * @param mixed $until
     */
    public function __construct($since, $until)
    {
        $this->since = $since;
        $this->until = $until;
    }

    /**
     * @return mixed
     */
    public function since()
    {
        return $this->since;
    }

    /**
     * @return mixed
     */
    public function until()
    {
        return $this->until;
    }
}
