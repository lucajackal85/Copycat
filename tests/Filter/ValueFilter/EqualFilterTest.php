<?php


namespace Jackal\Copycat\Tests\Filter\ValueFilter;


use Jackal\Copycat\Filter\ValueFilter\EqualFilter;
use PHPUnit\Framework\TestCase;

class EqualFilterTest extends TestCase
{
    public function testEqualFilter()
    {
        $filter = new EqualFilter('the_field', 0);

        $this->assertTrue($filter([
            'the_field' => 0,
        ]));

        $this->assertFalse($filter([
            'the_field' => '',
        ]));

        $this->assertFalse($filter([
            'the_field' => '0',
        ]));

        $this->assertFalse($filter([
            'the_field' => null,
        ]));
    }
}