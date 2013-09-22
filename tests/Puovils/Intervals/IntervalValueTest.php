<?php

namespace Puovils\Intervals;

class IntervalValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $value = new IntervalValue(1, true);

        $this->assertEquals(1, $value->value());
        $this->assertEquals(true, $value->isIncluded());

        $value = new IntervalValue(2, false);

        $this->assertEquals(2, $value->value());
        $this->assertEquals(false, $value->isIncluded());
    }
}
