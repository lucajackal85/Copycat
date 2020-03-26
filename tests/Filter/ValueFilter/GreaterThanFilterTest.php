<?php

namespace Jackal\Copycat\Tests\Filter\ValueFilter;

use Jackal\Copycat\Filter\ValueFilter\GreaterThanFilter;
use PHPUnit\Framework\TestCase;

class GreaterThanFilterTest extends TestCase
{
    public function testGreaterThanFilter()
    {
        $filter = new GreaterThanFilter('the_field', 12);

        $this->assertTrue($filter([
            'the_field' => 13,
        ]));

        $this->assertFalse($filter([
            'the_field' => 12,
        ]));

        $this->assertFalse($filter([
            'the_field' => 11,
        ]));
    }

    public function testGreaterThanFilterDateTimeObject()
    {
        $filter = new GreaterThanFilter('the_field', new \DateTime('2018-01-01 23:50:01'));

        $this->assertTrue($filter([
            'the_field' => new \DateTime('2018-01-01 23:51:00'),
        ]));

        $this->assertFalse($filter([
            'the_field' => new \DateTime('2018-01-01 23:50:00'),
        ]));

        $this->assertFalse($filter([
            'the_field' => new \DateTime('2018-01-01 23:49:59'),
        ]));
    }

    public function testGreaterThanFilterDateTimeString()
    {
        $filter = new GreaterThanFilter('the_field', '2018-01-01 23:50:01');

        $this->assertTrue($filter([
            'the_field' => '2018-01-01 23:51:00',
        ]));

        $this->assertFalse($filter([
            'the_field' => '2018-01-01 23:50:00',
        ]));

        $this->assertFalse($filter([
            'the_field' => '2018-01-01 23:49:59',
        ]));
    }

    public function testGreaterThanFilterString()
    {
        $filter = new GreaterThanFilter('the_field', 'B');

        $this->assertFalse($filter([
            'the_field' => 'A',
        ]));

        $this->assertFalse($filter([
            'the_field' => 'B',
        ]));

        $this->assertTrue($filter([
            'the_field' => 'C',
        ]));
    }
}
