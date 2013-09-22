<?php

namespace Puovils\Intervals;

class IntervalValue
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var bool
     */
    private $isIncluded;

    public function __construct($value, $isIncluded)
    {
        $this->value = $value;
        $this->isIncluded = $isIncluded;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isIncluded()
    {
        return $this->isIncluded;
    }
}
