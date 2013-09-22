<?php

namespace Puovils\Intervals;

/**
 * IntervalCollection
 * @package Puovils\Intervals
 */
class IntervalCollection implements \IteratorAggregate
{
    /**
     * @var Interval[]
     */
    private $intervals = [];

    /**
     * @var callable
     */
    private $compareFunction;

    /**
     * @param callable $compareFunction
     */
    public function __construct(\Closure $compareFunction = null)
    {
        if (null === $compareFunction) {
            $compareFunction = $this->defaultCompareFunction();
        }

        $this->compareFunction = $compareFunction;
    }

    /**
     * @param Interval $interval
     * @return $this
     */
    public function add(Interval $interval)
    {
        if (0 == $this->cmp($interval->since(), $interval->until())) {
            return $this;
        }

        $this->intervals[] = $interval;
        $this->mergeOverlaps();

        return $this;
    }

    /**
     * @param Interval $interval
     * @return $this
     */
    public function sub(Interval $interval)
    {
        foreach ($this->intervals as $index => $current) {
            if (0 <= $this->cmp($current->since(), $interval->since()) &&
                0 >= $this->cmp($current->until(), $interval->until())) {
                unset($this->intervals[$index]);
                continue;
            }
            if (0 > $this->cmp($current->since(), $interval->since()) &&
                0 < $this->cmp($current->until(), $interval->until())) {
                $this->intervals[] = new Interval($current->since(), $interval->since());
                $this->intervals[] = new Interval($interval->until(), $current->until());
                unset($this->intervals[$index]);
                continue;
            }
            if (0 <= $this->cmp($current->since(), $interval->since()) &&
                0 <= $this->cmp($current->until(), $interval->until()) &&
                0 >  $this->cmp($current->since(), $interval->until())) {
                $this->intervals[$index] = new Interval($interval->until(), $current->until());
            }
            if (0 >= $this->cmp($current->since(), $interval->since()) &&
                0 >= $this->cmp($current->until(), $interval->until()) &&
                0 <  $this->cmp($current->until(), $interval->since())) {
                $this->intervals[$index] = new Interval($current->since(), $interval->since());
            }
        }

        $this->mergeOverlaps();

        return $this;
    }

    /**
     * @param mixed $point
     * @return bool
     */
    public function contains($point)
    {
        foreach ($this->intervals as $interval) {
            if (0 <= $this->cmp($point, $interval->since())&&
                0 >  $this->cmp($point, $interval->until())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Interval $interval
     * @return bool
     */
    public function containsInterval(Interval $interval)
    {
        foreach ($this->intervals as $current) {
            if (0 >= $this->cmp($current->since(), $interval->since()) &&
                0 <= $this->cmp($current->until(), $interval->until())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Interval[]
     */
    public function intervals()
    {
        return $this->intervals;
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->intervals);
    }

    /**
     * Merge intervals with overlaps
     */
    private function mergeOverlaps()
    {
        $this->sort();

        for ($i = 0; $i < count($this->intervals) - 1; $i++) {
            $current = $this->intervals[$i];
            $next = $this->intervals[$i + 1];
            if (0 <= $this->cmp($current->until(), $next->since())) {
                $this->intervals[$i] = new Interval(
                    $current->since(),
                    0 <= $this->cmp($current->until(), $next->until()) ? $current->until() : $next->until()
                );
                unset($this->intervals[$i + 1]);
                $i--;
                $this->sort();
            }
        }
    }

    /**
     * Sort $this->internals array
     */
    private function sort()
    {
        usort(
            $this->intervals,
            function (Interval $a, Interval $b) {
                if (0 == $this->cmp($a->since(), $b->since())) {
                    if (0 == $this->cmp($a->until(), $b->until())) {
                        return 0;
                    }
                    return $this->cmp($a->until(), $b->until());
                }
                return $this->cmp($a->since(), $b->since());
            }
        );
    }

    /**
     * @param mixed $a
     * @param mixed $b
     * @return int
     */
    private function cmp($a, $b)
    {
        return (int)call_user_func($this->compareFunction, $a, $b);
    }

    /**
     * @return callable
     */
    private function defaultCompareFunction()
    {
        return function ($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return $a > $b ? 1 : -1;
        };
    }
}
