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
            'the_field' => 13,
        ]));

        $this->assertFalse($filter([
            'the_field' => 12,
        ]));

        $this->assertTrue($filter([
            'the_field' => 11,
        ]));
    }

    public function testLowerThanFilterDateTimeObject()
    {
        $filter = new LowerThanFilter('the_field', new \DateTime('2018-01-01 23:51:01'));

        $this->assertTrue($filter([
            'the_field' => new \DateTime('2018-01-01 23:51:00'),
        ]));
        $this->assertTrue($filter([
            'the_field' => '2018-01-01 23:51:00',
        ]));

        $this->assertFalse($filter([
            'the_field' => new \DateTime('2018-01-01 23:51:01'),
        ]));
        $this->assertFalse($filter([
            'the_field' => '2018-01-01 23:51:01',
        ]));

        $this->assertFalse($filter([
            'the_field' => new \DateTime('2018-01-01 23:51:59'),
        ]));
        $this->assertFalse($filter([
            'the_field' => '2018-01-01 23:51:59',
        ]));
    }

    public function testLowerThanFilterNull(){

        $filter = new LowerThanFilter('the_field', 'C');

        $this->assertTrue($filter([
            'the_field' => null,
        ]));
    }

    public function getInvalidValues(){
        return [
            [(object) 'an object'],
            [[]]
        ];
    }
    /**
     * @dataProvider getInvalidValues
     */
    public function testRaiseExceptionOnFilterInvalidValues($invalidValue){

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot parse filter value');

        $filter = new LowerThanFilter('the_field', 'C');

        $this->assertFalse($filter([
            'the_field' =>  $invalidValue,
        ]));
    }
}
