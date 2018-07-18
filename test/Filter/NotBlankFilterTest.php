<?php


namespace Jackal\Copycat\Tests\Filter;


use Jackal\Copycat\Filter\ValueFilter\NotBlankFilter;
use PHPUnit\Framework\TestCase;

class NotBlankFilterTest extends TestCase
{
    public function testNotBlank(){
        $filter = new NotBlankFilter('the_field');

        $this->assertTrue($filter([
            'the_field' => 'pippo'
        ]));
    }
}