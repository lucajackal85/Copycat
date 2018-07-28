<?php


namespace Jackal\Copycat\Tests\Filter\ValueFilter;

use Jackal\Copycat\Filter\ValueFilter\ValueNotInFilter;
use PHPUnit\Framework\TestCase;

class ValueNotInFilterTest extends TestCase
{
    public function testValueNotInFilter()
    {
        $filter = new ValueNotInFilter('the_field', ['pippo', 'pluto']);

        $this->assertFalse($filter([
            'the_field' => 'pippo'
        ]));

        $this->assertTrue($filter([
            'the_field' => 'paperino'
        ]));
    }
}
