<?php

namespace Puovils\Intervals;

class IntervalTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $low = new IntervalValue(1, true);
        $high = new IntervalValue(2, true);
        $interval = new Interval($low, $high);

        $this->assertEquals($low, $interval->low());
        $this->assertEquals($high, $interval->high());
    }
}
