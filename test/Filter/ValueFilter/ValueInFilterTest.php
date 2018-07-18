<?php


namespace Jackal\Copycat\Tests\Filter\ValueFilter;

use Jackal\Copycat\Filter\ValueFilter\ValueInFilter;
use PHPUnit\Framework\TestCase;

class ValueInFilterTest extends TestCase
{
    public function testValueInFilter()
    {
        $filter = new ValueInFilter('the_field', ['pippo','pluto']);

        $this->assertTrue($filter([
            'the_field' => 'pippo'
        ]));

        $this->assertFalse($filter([
            'the_field' => 'paperino'
        ]));
    }
}
