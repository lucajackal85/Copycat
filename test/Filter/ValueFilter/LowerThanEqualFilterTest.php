<?php


namespace Jackal\Copycat\Tests\Filter\ValueFilter;

use Jackal\Copycat\Filter\ValueFilter\LowerThanEqualFilter;
use PHPUnit\Framework\TestCase;

class LowerThanEqualFilterTest extends TestCase
{
    public function testLowerThanFilter()
    {
        $filter = new LowerThanEqualFilter('the_field', 12);

        $this->assertFalse($filter([
            'the_field' => 13
        ]));

        $this->assertTrue($filter([
            'the_field' => 12
        ]));

        $this->assertTrue($filter([
            'the_field' => 11
        ]));
    }

    public function testLowerThanFilterDateTimeObject()
    {
        $filter = new LowerThanEqualFilter('the_field', new \DateTime('2018-01-01 23:50:01'));

        $this->assertFalse($filter([
            'the_field' => new \DateTime('2018-01-01 23:51:00')
        ]));

        $this->assertTrue($filter([
            'the_field' => new \DateTime('2018-01-01 23:50:00')
        ]));

        $this->assertTrue($filter([
            'the_field' => new \DateTime('2018-01-01 23:49:59')
        ]));
    }

    public function testLowerThanFilterDateTimeString()
    {
        $filter = new LowerThanEqualFilter('the_field', '2018-01-01 23:50:01');

        $this->assertFalse($filter([
            'the_field' => '2018-01-01 23:51:00'
        ]));

        $this->assertTrue($filter([
            'the_field' => '2018-01-01 23:50:00'
        ]));

        $this->assertTrue($filter([
            'the_field' => '2018-01-01 23:49:59'
        ]));
    }

    public function testLowerThanFilterString()
    {
        $filter = new LowerThanEqualFilter('the_field', 'B');

        $this->assertFalse($filter([
            'the_field' => 'C'
        ]));

        $this->assertTrue($filter([
            'the_field' => 'B'
        ]));

        $this->assertTrue($filter([
            'the_field' => 'A'
        ]));
    }
}
