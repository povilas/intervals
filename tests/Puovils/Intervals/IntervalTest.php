<?php

namespace Puovils\Intervals;

class IntervalTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $since = new \DateTime('2000-01-01');
        $until = new \DateTime('2000-01-02');
        $interval = new Interval($since, $until);

        $this->assertEquals($since, $interval->since());
        $this->assertEquals($until, $interval->until());
    }
}
