<?php


namespace Jackal\Copycat\Tests\Filter;


use Jackal\Copycat\Filter\ValueFilter\GreaterThanFilter;
use PHPUnit\Framework\TestCase;

class GreaterThanFilterTest extends TestCase
{
    public function testGreaterThanFilter(){

        $filter = new GreaterThanFilter('the_field',12);

        $this->assertTrue($filter([
            'the_field' => 13
        ]));

        $this->assertFalse($filter([
            'the_field' => 12
        ]));

        $this->assertFalse($filter([
            'the_field' => 11
        ]));
    }
}