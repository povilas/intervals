<?php

namespace Puovils\Intervals;

class IntervalCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $utils = new Utils();

        $this->assertEquals('[1, 2]', $utils->add('[1, 2]'));

        $this->assertEquals('[1, 1]', $utils->add('[1, 1]'));
        $this->assertEquals('[1, 1]', $utils->add('[1, 1]; [1, 1]'));

        $this->assertEmpty($utils->add('(1, 1]'));
        $this->assertEmpty($utils->add('[1, 1)'));
        $this->assertEmpty($utils->add('(1, 1)'));
        $this->assertEmpty($utils->add('(1, 1]; [1, 1); (1, 1)'));

        $this->assertEquals('[1, 2]', $utils->add('[1, 2]; [1, 2]'));
        $this->assertEquals('[1, 2]', $utils->add('[1, 2]; [1, 2)'));
        $this->assertEquals('[1, 2]', $utils->add('[1, 2); [1, 2]'));

        $this->assertEquals('[1, 2]; [3, 4]', $utils->add('[1, 2]; [3, 4]'));
        $this->assertEquals('[1, 2]; [3, 4]', $utils->add('[3, 4]; [1, 2]'));

        $this->assertEquals('[1, 4]', $utils->add('[1, 3]; [2, 4]'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 3]; [2, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 3); [2, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 3]; (2, 4]'));
        $this->assertEquals('[1, 4)', $utils->add('[1, 3]; [2, 4)'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 3); [2, 4]'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 3]; (2, 4]'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 3); [2, 4)'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 3); (2, 4]'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 3); [2, 4)'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 3); (2, 4)'));

        $this->assertEquals('[1, 4]', $utils->add('[1, 3]; [1, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('(1, 3]; [1, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 3); [1, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 3]; (1, 4]'));
        $this->assertEquals('[1, 4)', $utils->add('[1, 3]; [1, 4)'));
        $this->assertEquals('[1, 4]', $utils->add('(1, 3); [1, 4]'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 3]; (1, 4]'));
        $this->assertEquals('[1, 4)', $utils->add('(1, 3); [1, 4)'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 3); (1, 4]'));
        $this->assertEquals('[1, 4)', $utils->add('(1, 3); [1, 4)'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 3); (1, 4)'));

        $this->assertEquals('[1, 4]', $utils->add('[1, 4]; [2, 4]'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 4]; [2, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 4); [2, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 4]; (2, 4]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 4]; [2, 4)'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 4); [2, 4]'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 4]; (2, 4]'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); [2, 4)'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 4); (2, 4]'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); [2, 4)'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); (2, 4)'));

        $this->assertEquals('[1, 4]', $utils->add('[1, 4]; [2, 3]'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 4]; [2, 3]'));
        $this->assertEquals('[1, 4)', $utils->add('[1, 4); [2, 3]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 4]; (2, 3]'));
        $this->assertEquals('[1, 4]', $utils->add('[1, 4]; [2, 3)'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); [2, 3]'));
        $this->assertEquals('(1, 4]', $utils->add('(1, 4]; (2, 3]'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); [2, 3)'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); (2, 3]'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); [2, 3)'));
        $this->assertEquals('(1, 4)', $utils->add('(1, 4); (2, 3)'));

        $this->assertEquals('[1, 2); (2, 3]', $utils->add('[1, 2); (2, 3]'));

        $this->assertEquals('[1, 3]', $utils->add('[1, 2); [2, 3]'));
        $this->assertEquals('[1, 3]', $utils->add('[1, 2]; (2, 3]'));
    }

    public function testSub()
    {
        $utils = new Utils();

        $this->assertEmpty($utils->sub('[1, 1]', '[1, 1]'));
        $this->assertEmpty($utils->sub('(1, 1]', '[1, 1]'));
        $this->assertEmpty($utils->sub('[1, 1)', '[1, 1]'));
        $this->assertEmpty($utils->sub('(1, 1)', '[1, 1]'));

        $this->assertEmpty($utils->sub('[1, 2]', '[1, 2]'));
        $this->assertEmpty($utils->sub('(1, 2]', '[1, 2]'));
        $this->assertEmpty($utils->sub('[1, 2)', '[1, 2]'));
        $this->assertEmpty($utils->sub('(1, 2)', '[1, 2]'));

        $this->assertEmpty($utils->sub('(1, 2]', '(1, 2]'));
        $this->assertEmpty($utils->sub('[1, 2)', '[1, 2)'));
        $this->assertEmpty($utils->sub('(1, 2)', '(1, 2)'));

        $this->assertEmpty($utils->sub('[2, 4]', '[1, 5]'));
        $this->assertEmpty($utils->sub('(2, 4]', '(1, 5]'));
        $this->assertEmpty($utils->sub('[2, 4)', '[1, 5)'));
        $this->assertEmpty($utils->sub('(2, 4)', '(1, 5)'));

        $this->assertEquals('[1, 2); (3, 4]', $utils->sub('[1, 4]', '[2, 3]'));
        $this->assertEquals('[1, 2); [3, 4]', $utils->sub('[1, 4]', '[2, 3)'));
        $this->assertEquals('[1, 2]; (3, 4]', $utils->sub('[1, 4]', '(2, 3]'));
        $this->assertEquals('[1, 2]; [3, 4]', $utils->sub('[1, 4]', '(2, 3)'));
        $this->assertEquals('[1, 2); (3, 4)', $utils->sub('[1, 4)', '[2, 3]'));
        $this->assertEquals('[1, 2); [3, 4)', $utils->sub('[1, 4)', '[2, 3)'));
        $this->assertEquals('[1, 2]; (3, 4)', $utils->sub('[1, 4)', '(2, 3]'));
        $this->assertEquals('[1, 2]; [3, 4)', $utils->sub('[1, 4)', '(2, 3)'));
        $this->assertEquals('(1, 2); (3, 4]', $utils->sub('(1, 4]', '[2, 3]'));
        $this->assertEquals('(1, 2); [3, 4]', $utils->sub('(1, 4]', '[2, 3)'));
        $this->assertEquals('(1, 2]; (3, 4]', $utils->sub('(1, 4]', '(2, 3]'));
        $this->assertEquals('(1, 2]; [3, 4]', $utils->sub('(1, 4]', '(2, 3)'));
        $this->assertEquals('(1, 2); (3, 4)', $utils->sub('(1, 4)', '[2, 3]'));
        $this->assertEquals('(1, 2); [3, 4)', $utils->sub('(1, 4)', '[2, 3)'));
        $this->assertEquals('(1, 2]; (3, 4)', $utils->sub('(1, 4)', '(2, 3]'));
        $this->assertEquals('(1, 2]; [3, 4)', $utils->sub('(1, 4)', '(2, 3)'));

        $this->assertEquals('[1, 2)', $utils->sub('[1, 4]', '[2, 4]'));
        $this->assertEquals('[1, 2); [4, 4]', $utils->sub('[1, 4]', '[2, 4)'));
        $this->assertEquals('[1, 2]', $utils->sub('[1, 4]', '(2, 4]'));
        $this->assertEquals('[1, 2]; [4, 4]', $utils->sub('[1, 4]', '(2, 4)'));
        $this->assertEquals('[1, 2)', $utils->sub('[1, 4)', '[2, 4]'));
        $this->assertEquals('[1, 2)', $utils->sub('[1, 4)', '[2, 4)'));
        $this->assertEquals('[1, 2]', $utils->sub('[1, 4)', '(2, 4]'));
        $this->assertEquals('[1, 2]', $utils->sub('[1, 4)', '(2, 4)'));
        $this->assertEquals('(1, 2)', $utils->sub('(1, 4]', '[2, 4]'));
        $this->assertEquals('(1, 2); [4, 4]', $utils->sub('(1, 4]', '[2, 4)'));
        $this->assertEquals('(1, 2]', $utils->sub('(1, 4]', '(2, 4]'));
        $this->assertEquals('(1, 2]; [4, 4]', $utils->sub('(1, 4]', '(2, 4)'));
        $this->assertEquals('(1, 2)', $utils->sub('(1, 4)', '[2, 4]'));
        $this->assertEquals('(1, 2)', $utils->sub('(1, 4)', '[2, 4)'));
        $this->assertEquals('(1, 2]', $utils->sub('(1, 4)', '(2, 4]'));
        $this->assertEquals('(1, 2]', $utils->sub('(1, 4)', '(2, 4)'));

        $this->assertEquals('(3, 4]', $utils->sub('[2, 4]', '[2, 3]'));
        $this->assertEquals('[3, 4]', $utils->sub('[2, 4]', '[2, 3)'));
        $this->assertEquals('[2, 2]; (3, 4]', $utils->sub('[2, 4]', '(2, 3]'));
        $this->assertEquals('[2, 2]; [3, 4]', $utils->sub('[2, 4]', '(2, 3)'));
        $this->assertEquals('(3, 4)', $utils->sub('[2, 4)', '[2, 3]'));
        $this->assertEquals('[3, 4)', $utils->sub('[2, 4)', '[2, 3)'));
        $this->assertEquals('[2, 2]; (3, 4)', $utils->sub('[2, 4)', '(2, 3]'));
        $this->assertEquals('[2, 2]; [3, 4)', $utils->sub('[2, 4)', '(2, 3)'));
        $this->assertEquals('(3, 4]', $utils->sub('(2, 4]', '[2, 3]'));
        $this->assertEquals('[3, 4]', $utils->sub('(2, 4]', '[2, 3)'));
        $this->assertEquals('(3, 4]', $utils->sub('(2, 4]', '(2, 3]'));
        $this->assertEquals('[3, 4]', $utils->sub('(2, 4]', '(2, 3)'));
        $this->assertEquals('(3, 4)', $utils->sub('(2, 4)', '[2, 3]'));
        $this->assertEquals('[3, 4)', $utils->sub('(2, 4)', '[2, 3)'));
        $this->assertEquals('(3, 4)', $utils->sub('(2, 4)', '(2, 3]'));
        $this->assertEquals('[3, 4)', $utils->sub('(2, 4)', '(2, 3)'));


        $this->assertEquals('[1, 2)', $utils->sub('[1, 4]', '[2, 5]'));
        $this->assertEquals('[1, 2)', $utils->sub('[1, 4]', '[2, 5)'));
        $this->assertEquals('[1, 2]', $utils->sub('[1, 4]', '(2, 5]'));
        $this->assertEquals('[1, 2]', $utils->sub('[1, 4]', '(2, 5)'));
        $this->assertEquals('[1, 2)', $utils->sub('[1, 4)', '[2, 5]'));
        $this->assertEquals('[1, 2)', $utils->sub('[1, 4)', '[2, 5)'));
        $this->assertEquals('[1, 2]', $utils->sub('[1, 4)', '(2, 5]'));
        $this->assertEquals('[1, 2]', $utils->sub('[1, 4)', '(2, 5)'));
        $this->assertEquals('(1, 2)', $utils->sub('(1, 4]', '[2, 5]'));
        $this->assertEquals('(1, 2)', $utils->sub('(1, 4]', '[2, 5)'));
        $this->assertEquals('(1, 2]', $utils->sub('(1, 4]', '(2, 5]'));
        $this->assertEquals('(1, 2]', $utils->sub('(1, 4]', '(2, 5)'));
        $this->assertEquals('(1, 2)', $utils->sub('(1, 4)', '[2, 5]'));
        $this->assertEquals('(1, 2)', $utils->sub('(1, 4)', '[2, 5)'));
        $this->assertEquals('(1, 2]', $utils->sub('(1, 4)', '(2, 5]'));
        $this->assertEquals('(1, 2]', $utils->sub('(1, 4)', '(2, 5)'));

        $this->assertEquals('(4, 5]', $utils->sub('[3, 5]', '[1, 4]'));
        $this->assertEquals('[4, 5]', $utils->sub('[3, 5]', '[1, 4)'));
        $this->assertEquals('(4, 5]', $utils->sub('[3, 5]', '(1, 4]'));
        $this->assertEquals('[4, 5]', $utils->sub('[3, 5]', '(1, 4)'));
        $this->assertEquals('(4, 5)', $utils->sub('[3, 5)', '[1, 4]'));
        $this->assertEquals('[4, 5)', $utils->sub('[3, 5)', '[1, 4)'));
        $this->assertEquals('(4, 5)', $utils->sub('[3, 5)', '(1, 4]'));
        $this->assertEquals('[4, 5)', $utils->sub('[3, 5)', '(1, 4)'));
        $this->assertEquals('(4, 5]', $utils->sub('(3, 5]', '[1, 4]'));
        $this->assertEquals('[4, 5]', $utils->sub('(3, 5]', '[1, 4)'));
        $this->assertEquals('(4, 5]', $utils->sub('(3, 5]', '(1, 4]'));
        $this->assertEquals('[4, 5]', $utils->sub('(3, 5]', '(1, 4)'));
        $this->assertEquals('(4, 5)', $utils->sub('(3, 5)', '[1, 4]'));
        $this->assertEquals('[4, 5)', $utils->sub('(3, 5)', '[1, 4)'));
        $this->assertEquals('(4, 5)', $utils->sub('(3, 5)', '(1, 4]'));
        $this->assertEquals('[4, 5)', $utils->sub('(3, 5)', '(1, 4)'));

        $this->assertEquals('(1, 4]', $utils->sub('[1, 4]', '[1, 1]'));
        $this->assertEquals('[1, 4)', $utils->sub('[1, 4]', '[4, 4]'));
        $this->assertEquals('(1, 4)', $utils->sub('[1, 4)', '[1, 1]'));
        $this->assertEquals('(1, 4)', $utils->sub('(1, 4]', '[4, 4]'));
    }

    public function testContains()
    {
        $utils = new Utils();

        $intervals = $utils->collectionFromString('[1, 4]');
        $this->assertTrue($intervals->contains(1));
        $this->assertTrue($intervals->contains(3));
        $this->assertTrue($intervals->contains(4));
        $this->assertFalse($intervals->contains(5));

        $intervals = $utils->collectionFromString('(1, 4]');
        $this->assertFalse($intervals->contains(1));
        $this->assertTrue($intervals->contains(3));
        $this->assertTrue($intervals->contains(4));
        $this->assertFalse($intervals->contains(5));

        $intervals = $utils->collectionFromString('[1, 4)');
        $this->assertTrue($intervals->contains(1));
        $this->assertTrue($intervals->contains(3));
        $this->assertFalse($intervals->contains(4));
        $this->assertFalse($intervals->contains(5));

        $intervals = $utils->collectionFromString('(1, 4)');
        $this->assertFalse($intervals->contains(1));
        $this->assertTrue($intervals->contains(3));
        $this->assertFalse($intervals->contains(4));
        $this->assertFalse($intervals->contains(5));
    }

    public function testContainsInterval()
    {
        $utils = new Utils();

        $intervals = $utils->collectionFromString('[1, 4]');
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 1]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[1, 1]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[4, 4]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[2, 3]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[1, 4]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[2, 5]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 5]')));

        $intervals = $utils->collectionFromString('(1, 4]');
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 1]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[1, 1]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[4, 4]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[2, 3]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[1, 4]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[2, 5]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 5]')));

        $intervals = $utils->collectionFromString('[1, 4)');
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 1]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[1, 1]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[4, 4]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[2, 3]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[1, 4]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[2, 5]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 5]')));

        $intervals = $utils->collectionFromString('(1, 4)');
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 1]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[1, 1]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[4, 4]')));
        $this->assertTrue($intervals->containsInterval($utils->intervalFromString('[2, 3]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[1, 4]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[2, 5]')));
        $this->assertFalse($intervals->containsInterval($utils->intervalFromString('[0, 5]')));
    }

    public function testGetIntervals()
    {
        $utils = new Utils();

        $intervals = new IntervalCollection();

        $interval1 = $utils->intervalFromString('[1, 2]');
        $interval2 = $utils->intervalFromString('(3, 4)');
        $intervals->add($interval1);
        $intervals->add($interval2);

        $this->assertEquals([$interval1, $interval2], $intervals->getIntervals());
    }
}
