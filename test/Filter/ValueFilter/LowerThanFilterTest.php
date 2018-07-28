<?php


namespace Jackal\Copycat\Tests\Filter\ValueFilter;

use Jackal\Copycat\Filter\ValueFilter\LowerThanFilter;
use PHPUnit\Framework\TestCase;

class LowerThanFilterTest extends TestCase
{
    public function testLowerThanFilter()
    {
        $filter = new LowerThanFilter('the_field', 12);

        $this->assertFalse($filter([
            'the_field' => 13
        ]));

        $this->assertFalse($filter([
            'the_field' => 12
        ]));

        $this->assertTrue($filter([
            'the_field' => 11
        ]));
    }
}
