<?php

namespace Puovils\Intervals;

class Utils
{
    public function collectionFromString($string)
    {
        $intervals = explode(';', $string);
        $collection = new IntervalCollection();

        foreach ($intervals as $interval) {
            $collection->add($this->intervalFromString(trim($interval)));
        }

        return $collection;
    }

    public function collectionToString(IntervalCollection $intervals)
    {
        $strings = [];
        foreach ($intervals as $interval) {
            $strings[] = $this->intervalTotoString($interval);
        }

        return implode('; ', $strings);
    }

    public function add($string)
    {
        return $this->collectionToString($this->collectionFromString($string));
    }

    public function sub($add, $sub)
    {
        $collection = $this->collectionFromString($add);
        $collection->sub($this->intervalFromString($sub));

        return $this->collectionToString($collection);
    }


    public function intervalFromString($string)
    {
        $builder = new IntervalBuilder();
        if (preg_match_all('/([\(\[])[\ ]*(\d+)[\ ]*,[\ ]*(\d+)[\ ]*([\)\]])/', $string, $matches)) {
            return $builder
                ->low((int)$matches[2][0], $matches[1][0] == '[')
                ->high((int)$matches[3][0], $matches[4][0] == ']')
                ->getInterval();
        }

        throw new \InvalidArgumentException("Cannot parse '{$string}'");
    }

    public function intervalTotoString(Interval $interval)
    {
        return ($interval->low()->isIncluded() ? '[' : '(') .
        $interval->low()->value() . ', ' . $interval->high()->value() .
        ($interval->high()->isIncluded() ? ']' : ')');
    }
}
