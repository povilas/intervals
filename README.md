# README

## What is this?

This libary helps you to work with intervals. Currently supported operations:

    Addition example:
    [1, 2] + [2, 3]          = [1, 3]
    [1, 3) + (3, 5]          = [1, 3); (3, 5]
    (1, 3) + (3, 5] + [1, 4) = [1, 5]
    
    Subtraction example:
    [1, 4] - [2, 3] = [1, 2); (3, 4]
    [1, 4] - (2, 5] = [1, 2]
    
Intervals can contain any type of data. Integers, string, arrays, \DateTime, etc. You just need to provide function witch can perform comaprision of your data type.


## Installation
```shell
composer.phar require "puovils/intervals=1.0.*@dev"
```

## Usage

Simple example with integers
```php
$builder = new IntervalBuilder();

$interval1 = $builder
    ->low(1, true)   // [1
    ->high(5, false) // 5)
    ->getInterval(); // [1, 5)

$interval2 = $builder
    ->low(2, false)  // (2
    ->high(3, true)  // 3]
    ->getInterval(); // (2, 3]

$intervalCollection= new IntervalCollection();
$intervals = $intervalCollection
    ->add($interval1) // [1, 5)
    ->sub($interval2) // (2, 3]
    ->getIntervals(); // [1, 2]; (3, 5)

echo $intervals[0]->low()->value();       // 1
echo $intervals[0]->low()->isIncluded();  // true
echo $intervals[0]->high()->value();      // 2
echo $intervals[0]->high()->isIncluded(); // true

echo $intervals[1]->low()->value();       // 3
echo $intervals[1]->low()->isIncluded();  // false
echo $intervals[1]->high()->value();      // 5
echo $intervals[1]->high()->isIncluded(); // false

```

With `\DateTime`
```php
$builder = new IntervalBuilder();

$interval1 = $builder
    ->low(new \DateTime('2000-01-15'), true)
    ->high(new \DateTime('2000-02-15'), true)
    ->getInterval();

$interval2 = $builder
    ->low(new \DateTime('2000-01-17'), true)
    ->high(new \DateTime('2000-03-01'), false)
    ->getInterval();

$intervalCollection= new IntervalCollection(
    function (\DateTime $a, \DateTime $b) {
        if ($a->getTimestamp() == $b->getTimestamp()) {
            return 0;
        }
        return $a->getTimestamp() > $b->getTimestamp() ? 1 : -1;
    }
);
$intervals = $intervalCollection
    ->add($interval1)
    ->add($interval2)
    ->getIntervals();

echo $intervals[0]->low()->value()->format('Y-m-d'); // 2000-01-15
echo $intervals[0]->low()->isIncluded(); // true
echo $intervals[0]->high()->value()->format('Y-m-d'); // 2000-03-01
echo $intervals[0]->high()->isIncluded(); // false
```        
