# Usage

```php
<?php

$intervals = new IntervalCollection();
$intervals
    ->add(new Interval('2000-01-10', '2000-01-12'))
    ->add(new Interval('2000-01-14', '2000-01-16'))
    ->add(new Interval('2000-01-11', '2000-01-15'));

$intervals->intervals() == [
    new Interval('2000-01-10', '2000-01-16'),
];



$intervals = new IntervalCollection();
$intervals
    ->add(new Interval(10, 20))
    ->sub(new Interval(11, 19));

$intervals->intervals() == [
    new Interval(10, 11),
    new Interval(19, 20),
];



class MyType
{
    public  $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
$intervals = new IntervalCollection(
    function (MyType $a, MyType $b) {
        if ($a->value == $b->value) {
            return 0;
        }
        return $a->value > $b->value ? 1 : -1;
    }
);
$intervals
    ->add(new Interval(new MyType(10), new MyType(20)))
    ->sub(new Interval(new MyType(11), new MyType(19)));

$intervals->intervals() == [
    new Interval(new MyType(10), new MyType(11)),
    new Interval(new MyType(19), new MyType(20)),
],
```
