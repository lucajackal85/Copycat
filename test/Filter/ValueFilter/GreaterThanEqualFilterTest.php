<?php


namespace Jackal\Copycat\Tests\Filter\ValueFilter;

use Jackal\Copycat\Filter\ValueFilter\GreaterThanEqualFilter;
use PHPUnit\Framework\TestCase;

class GreaterThanEqualFilterTest extends TestCase
{
    public function testGreaterThanEqualFilter()
    {
        $filter = new GreaterThanEqualFilter('the_field', 12);

        $this->assertTrue($filter([
            'the_field' => 13
        ]));

        $this->assertTrue($filter([
            'the_field' => 12
        ]));

        $this->assertFalse($filter([
            'the_field' => 11
        ]));
    }
}
