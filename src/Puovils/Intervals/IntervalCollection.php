<?php

namespace Puovils\Intervals;

/**
 * IntervalCollection
 * @package Puovils\Intervals
 */
class IntervalCollection implements \IteratorAggregate
{
    /**
     * Intervals in collection
     *
     * @var Interval[]
     */
    private $intervals = [];

    /**
     * Function for comparing interval values
     *
     * @var callable
     */
    private $compareFunction;

    /**
     * Constructor
     *
     * @param callable $compareFunction Function used to compare interval values
     */
    public function __construct(callable $compareFunction = null)
    {
        if (null === $compareFunction) {
            $compareFunction = $this->defaultCompareFunction();
        }

        $this->compareFunction = $compareFunction;
    }

    /**
     * Add interval to collection
     *
     * @param Interval $interval
     * @return $this
     */
    public function add(Interval $interval)
    {
        if (0 == $this->cmpV($interval->low(), $interval->high()) &&
            (!$interval->low()->isIncluded() || !$interval->high()->isIncluded())
            ) {
            return $this;
        }

        $this->intervals[] = $interval;
        $this->mergeOverlaps();

        return $this;
    }

    /**
     * Remove interval from collection
     *
     * @param Interval $interval
     * @return $this
     */
    public function sub(Interval $interval)
    {
        foreach ($this->intervals as $index => $current) {
            if (0 <= $this->cmpV($current->low(), $interval->low()) &&
                0 >= $this->cmpI($current->low(), $interval->low()) &&
                0 >= $this->cmpV($current->high(), $interval->high()) &&
                0 >= $this->cmpI($current->high(), $interval->high())
                ) {
                unset($this->intervals[$index]);
                continue;
            }
            if ((0 > $this->cmpV($current->low(), $interval->low()) ||
                    (0 == $this->cmpV($current->low(), $interval->low()) &&
                     0 < $this->cmpI($current->low(), $interval->low()))
                ) &&
                (0 < $this->cmpV($current->high(), $interval->high()) ||
                    (0 == $this->cmpV($current->high(), $interval->high()) &&
                     0 < $this->cmpI($current->high(), $interval->high())))
                ) {
                $builder = new IntervalBuilder();
                $this->intervals[] = $builder
                    ->low($current->low()->value(), $current->low()->isIncluded())
                    ->high($interval->low()->value(), !$interval->low()->isIncluded())
                    ->getInterval();
                $this->intervals[] = $builder
                    ->low($interval->high()->value(), !$interval->high()->isIncluded())
                    ->high($current->high()->value(), $current->high()->isIncluded())
                    ->getInterval();
                unset($this->intervals[$index]);
                continue;
            }
            if (0 <= $this->cmpV($current->low(), $interval->low()) &&
                0 <= $this->cmpV($current->high(), $interval->high()) &&
                0 >=  $this->cmpV($current->low(), $interval->high())
                ) {
                $builder = new IntervalBuilder();
                $this->intervals[$index] = $builder
                    ->low($interval->high()->value(), !$interval->high()->isIncluded())
                    ->high($current->high()->value(), $current->high()->isIncluded())
                    ->getInterval();
            }
            if (0 >= $this->cmpV($current->low(), $interval->low()) &&
                0 >= $this->cmpV($current->high(), $interval->high()) &&
                0 <=  $this->cmpV($current->high(), $interval->low())
                ) {
                $builder = new IntervalBuilder();
                $this->intervals[$index] = $builder
                    ->low($current->low()->value(), $current->low()->isIncluded())
                    ->high($interval->low()->value(), !$interval->low()->isIncluded())
                    ->getInterval();
            }
        }

        $this->mergeOverlaps();

        return $this;
    }

    /**
     * Does given value exists in collection
     *
     * @param mixed $value
     * @return bool
     */
    public function contains($value)
    {
        $builder = new IntervalBuilder();
        $interval = $builder
            ->low($value, true)
            ->high($value, true)
            ->getInterval();

        return $this->containsInterval($interval);
    }

    /**
     * Does given interval exists in collection
     *
     * @param Interval $interval
     * @return bool
     */
    public function containsInterval(Interval $interval)
    {
        foreach ($this->intervals as $current) {
            if (0 >= $this->cmpV($current->low(), $interval->low()) &&
                0 <= $this->cmpV($current->high(), $interval->high())
                ) {
                if (0 == $this->cmpV($current->low(), $interval->low()) &&
                    0 > $this->cmpI($current->low(), $interval->low())
                    ) {
                    return false;
                }
                if (0 == $this->cmpV($current->high(), $interval->high()) &&
                    0 > $this->cmpI($current->high(), $interval->high())
                    ) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Get list of intervals in collection
     *
     * @return Interval[]
     */
    public function getIntervals()
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
     * Merge intervals that have common values
     */
    private function mergeOverlaps()
    {
        $this->sort();

        for ($i = 0; $i < count($this->intervals) - 1; $i++) {
            $current = $this->intervals[$i];
            $next = $this->intervals[$i + 1];
            if (0 < $this->cmpV($current->high(), $next->low()) ||
                (0 == $this->cmpV($current->high(), $next->low()) &&
                ($current->high()->isIncluded() || $next->low()->isIncluded()))
                ) {
                $builder = new IntervalBuilder();
                $this->intervals[$i] = $builder
                    ->low(
                        $current->low()->value(),
                        $current->low()->isIncluded()
                    )
                    ->high(
                        (0 <= $this->cmpV($current->high(), $next->high())
                            ? $current->high()->value()
                            : $next->high()->value()),
                        (0 == $this->cmpV($current->high(), $next->high())
                            ? ($current->high()->isIncluded() || $next->high()->isIncluded())
                            : (0 < $this->cmpV($current->high(), $next->high())
                                ? $current->high()->isIncluded()
                                : $next->high()->isIncluded()))
                    )
                    ->getInterval();
                unset($this->intervals[$i + 1]);
                $i--;
                $this->sort();
            }

        }
    }

    /**
     * Sort $this->internals array
     *
     * sorting rules:
     * by low value
     *   if low values are equal, then included value is smaller then excluded
     * by high value
     *   if high values are equal, then included value is bigger then excluded
     *
     * correctly sorted example:
     * [1, 2]
     * [1, 2)
     * (1, 2)
     * (1, 2]
     */
    private function sort()
    {
        usort(
            $this->intervals,
            function (Interval $a, Interval $b) {
                if (0 == $this->cmpV($a->low(), $b->low())) {
                    if ($a->low()->isIncluded() != $b->low()->isIncluded()) {
                        return $a->low()->isIncluded() && !$b->low()->isIncluded() ? -1 : 1;
                    } else {
                        if (0 == $this->cmpV($a->high(), $b->high())) {
                            if ($a->high()->isIncluded() != $b->high()->isIncluded()) {
                                return $a->high()->isIncluded() && !$b->high()->isIncluded() ? 1 : -1;
                            } else {
                                return 0;
                            }
                        } else {
                            return $this->cmpV($a->high(), $b->high());
                        }
                    }
                } else {
                    return $this->cmpV($a->low(), $b->low());
                }
            }
        );
    }

    /**
     * Compare values of IntervalValue
     *
     * @param IntervalValue $a
     * @param IntervalValue $b
     * @return int
     */
    private function cmpV(IntervalValue $a, IntervalValue $b)
    {
        return (int)call_user_func($this->compareFunction, $a->value(), $b->value());
    }

    /**
     * Compare inclusion attributes of IntervalValue
     *
     * @param IntervalValue $a
     * @param IntervalValue $b
     * @return int
     */
    private function cmpI(IntervalValue $a, IntervalValue $b)
    {
        if ($a->isIncluded() == $b->isIncluded()) {
            return 0;
        }

        return $a->isIncluded() ? 1 : -1;
    }

    /**
     * Default function to compare IntervalValue values
     *
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
