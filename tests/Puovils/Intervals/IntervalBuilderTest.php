<?php

namespace Puovils\Intervals;

class IntervalBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuilder()
    {
        $builder = new IntervalBuilder();
        $buildedInterval = $builder
            ->low(1, true)
            ->high(2, false)
            ->getInterval();

        $low = new IntervalValue(1, true);
        $high = new IntervalValue(2, false);
        $manualInterval = new Interval($low, $high);

        $this->assertEquals($manualInterval, $buildedInterval);
    }
}
