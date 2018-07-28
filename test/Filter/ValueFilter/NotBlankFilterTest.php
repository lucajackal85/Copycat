<?php


namespace Jackal\Copycat\Tests\Filter\ValueFilter;

use Jackal\Copycat\Filter\ValueFilter\NotBlankFilter;
use PHPUnit\Framework\TestCase;

class NotBlankFilterTest extends TestCase
{
    public function testNotBlank()
    {
        $filter = new NotBlankFilter('the_field');

        $this->assertTrue($filter([
            'the_field' => 'pippo'
        ]));

        $this->assertTrue($filter([
            'the_field' => '0'
        ]));

        $this->assertFalse($filter([
            'the_field' => ''
        ]));

        $this->assertFalse($filter([
            'the_field' => null
        ]));
    }
}
