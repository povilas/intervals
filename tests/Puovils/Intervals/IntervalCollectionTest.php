<?php

namespace Puovils\Intervals;

class IntervalCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 10));

        $this->assertEmpty($intervals->intervals());

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->add(new Interval(10, 20));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 20),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->add(new Interval(9, 21));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(9, 21),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->add(new Interval(11, 19));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 20),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->add(new Interval(9, 11));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(9, 20),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->add(new Interval(19, 21));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 21),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->add(new Interval(21, 22));

        $this->assertEquals(2, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 20),
            $intervals->intervals()[0]
        );
        $this->assertEquals(
            new Interval(21, 22),
            $intervals->intervals()[1]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->add(new Interval(10, 21));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 21),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(11, 21));
        $intervals->add(new Interval(10, 21));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 21),
            $intervals->intervals()[0]
        );

    }

    public function testSub()
    {
        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->sub(new Interval(10, 11));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(11, 20),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->sub(new Interval(11, 20));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 11),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->sub(new Interval(9, 11));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(11, 20),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->sub(new Interval(19, 21));

        $this->assertEquals(1, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 19),
            $intervals->intervals()[0]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->sub(new Interval(9, 21));

        $this->assertEmpty($intervals->intervals());

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));
        $intervals->sub(new Interval(11, 19));

        $this->assertEquals(2, count($intervals->intervals()));
        $this->assertEquals(
            new Interval(10, 11),
            $intervals->intervals()[0]
        );
        $this->assertEquals(
            new Interval(19, 20),
            $intervals->intervals()[1]
        );

        $intervals = new IntervalCollection();
        $intervals->add(new Interval(11, 20));
        $intervals->sub(new Interval(11, 20));

        $this->assertEmpty($intervals->intervals());
    }

    public function testContains()
    {
        $intervals = new IntervalCollection();
        $intervals->add(new Interval(10, 20));

        $this->assertTrue($intervals->contains(10));
        $this->assertTrue($intervals->contains(19));
        $this->assertFalse($intervals->contains(9));
        $this->assertFalse($intervals->contains(20));
        $this->assertFalse($intervals->contains(21));
    }

    public function testContainsInerval()
    {
        $intervals = new IntervalCollection();
        $intervals->add(new Interval(1, 10));
        $intervals->add(new Interval(20, 30));

        $this->assertTrue($intervals->containsInterval(new Interval(1, 10)));
        $this->assertTrue($intervals->containsInterval(new Interval(2, 3)));
        $this->assertFalse($intervals->containsInterval(new Interval(9, 11)));
        $this->assertFalse($intervals->containsInterval(new Interval(19, 21)));
        $this->assertFalse($intervals->containsInterval(new Interval(11, 12)));
    }
}
